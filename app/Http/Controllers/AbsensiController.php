<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Pengajuanizin;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;

class AbsensiController extends Controller
{
    public function index()
    {
        $hariIni = date("Y-m-d");
        $karyawan_id = Auth::guard('karyawan')->user()->id;

        // Mengganti 'id' menjadi 'karyawan_id' pada query
        $cek = DB::table('presensi')
            ->where('tanggal_presensi', $hariIni)
            ->where('karyawan_id', $karyawan_id) // Menggunakan karyawan_id, bukan id
            ->count();
        $lok_kantor = DB::table('lokasi')
            ->where('id', 1)
            ->first();


        return view('absensi.create', compact('cek', 'lok_kantor'));
    }

    public function dashboardadmin()
    {
        $user = Auth::guard('user')->user();
        $totalKaryawan = DB::table('karyawan')->count();
        $totalKehadiranHariIni = DB::table('presensi')
            ->whereDate('tanggal_presensi', now()->toDateString())
            ->count();

        return view('admin.dashboard', compact('user', 'totalKaryawan', 'totalKehadiranHariIni'));
    }


    public function store(Request $request)
    {
        $karyawan_id = Auth::guard('karyawan')->user()->id;
        $tanggal_presensi = date("Y-m-d");
        $jam = date("H:i:s");


        $lok_kantor = DB::table('lokasi')->where('id', 1)->first();
        $lok = explode(",", $lok_kantor->lokasi_kantor);

        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];

        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $image = $request->image;
        $folderPath = "upload/absensi";
        $formatName = $karyawan_id . "-" . $tanggal_presensi . "-" . time();
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";

        // Cek apakah karyawan sudah presensi hari ini
        $cek = DB::table('presensi')
            ->where('tanggal_presensi', $tanggal_presensi)
            ->where('karyawan_id', $karyawan_id)
            ->count();

        if ($radius > $lok_kantor->radius) {
            return response()->json([
                'status' => 'error',
                'message' => 'Maaf, anda berada di luar radius. Jarak anda ' . $radius . ' meter dari kantor.'
            ]);
        } else {
            if ($cek > 0) {
                // Cek apakah sudah ada jam_keluar di record presensi
                $presensi = DB::table('presensi')
                    ->where('tanggal_presensi', $tanggal_presensi)
                    ->where('karyawan_id', $karyawan_id)
                    ->first();

                if ($presensi->jam_keluar != null) {
                    // Jika jam_keluar sudah diisi, absen pulang tidak bisa dilakukan lagi
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Anda sudah melakukan absen pulang hari ini.'
                    ]);
                }

                // Jika belum ada jam_keluar, lakukan update untuk absen pulang
                $data_pulang = [
                    'jam_keluar' => $jam,
                    'foto_keluar' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')
                    ->where('tanggal_presensi', $tanggal_presensi)
                    ->where('karyawan_id', $karyawan_id)
                    ->update($data_pulang);

                if ($update) {
                    Storage::disk('public')->put($folderPath . "/" . $fileName, $image_base64);
                    return response()->json(['status' => 'success', 'message' => 'Terima kasih, absen pulang berhasil dicatat']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan. Hubungi tim IT.']);
                }
            } else {
                // Jika belum presensi masuk, lakukan insert
                $data_masuk = [
                    'karyawan_id' => $karyawan_id,
                    'tanggal_presensi' => $tanggal_presensi,
                    'jam_masuk' => $jam,
                    'foto_masuk' => $fileName,
                    'lokasi_in' => $lokasi,
                    'status' => 'h'
                ];
                $simpan = DB::table('presensi')->insert($data_masuk);
                if ($simpan) {
                    Storage::disk('public')->put($folderPath . "/" . $fileName, $image_base64);
                    return response()->json(['status' => 'success', 'message' => 'Absen masuk berhasil dicatat']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan. Hubungi tim IT.']);
                }
            }
        }
    }


    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function dashboard()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m");
        $tahunini = date("Y");
        $karyawan_id = Auth::guard('karyawan')->user()->id;

        $presensihariini = DB::table('presensi')
            ->where('tanggal_presensi', $hariini)
            ->first();


        $historibulanini = DB::table('presensi')
            ->select('presensi.*', 'keterangan', 'doc_sid')
            ->leftJoin('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
            ->where('presensi.karyawan_id', $karyawan_id)
            ->whereRaw('MONTH(tanggal_presensi) = ?', [$bulanini])
            ->whereRaw('YEAR(tanggal_presensi) = ?', [$tahunini])
            ->orderBy('tanggal_presensi')
            ->get();


        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(karyawan_id) as totalhadir, SUM(IF(jam_masuk > "09:00:00", 1, 0)) as jumlah_tlt')
            ->where('karyawan_id', $karyawan_id)
            ->whereRaw('MONTH(tanggal_presensi) = ?', [$bulanini])
            ->whereRaw('YEAR(tanggal_presensi) = ?', [$tahunini])
            ->first();


        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('absensi.dashboard', compact('karyawan_id', 'presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi'));
    }

    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('absensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $karyawan_id = Auth::guard('karyawan')->user()->id;
        $histori = DB::table('presensi')->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
            ->where('karyawan_id', $karyawan_id)
            ->orderBy('tanggal_presensi')
            ->get();

        return view('absensi.gethistori', compact('histori'));
    }

    public function monitoring()
    {
        $user = Auth::guard('user')->user();
        return view('admin.monitoring', compact('user'));
    }

    public function getpresensi(Request $request)
    {
        if ($request->has('tanggal_presensi')) {
            // Query untuk satu tanggal
            $presensi = DB::table('presensi')
                ->select('presensi.*', 'nama_karyawan', 'keterangan')
                ->leftJoin('karyawan', 'presensi.karyawan_id', '=', 'karyawan.id')
                ->leftJoin('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
                ->where('tanggal_presensi', $request->tanggal_presensi)
                ->get();
        } else {
            // Query untuk rentang tanggal
            $presensi = DB::table('presensi')
                ->select('presensi.*', 'nama_karyawan', 'keterangan')
                ->join('karyawan', 'presensi.karyawan_id', '=', 'karyawan.id')
                ->leftJoin('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
                ->whereBetween('tanggal_presensi', [$request->start_date, $request->end_date])
                ->get();
        }

        return view('admin.getpresensi', compact('presensi'));
    }


    public function editprofile()
    {

        $id = Auth::guard('karyawan')->user()->id;
        $karyawan = DB::table('karyawan')->where('id', $id)->first();

        // Ambil semua jabatan untuk dropdown
        $jabatan = DB::table('jabatan')->get();

        return view('absensi.updatedata', compact('karyawan', 'jabatan'));
    }


    public function updateprofile(Request $request)
    {
        $id = Auth::guard('karyawan')->user()->id;

        // Ambil data request
        $nama_karyawan = $request->nama_karyawan;
        $jabatan_id = $request->jabatan_id;
        $no_hp = $request->no_hp;
        $tanggal_lahir = $request->tanggal_lahir;
        $gender = $request->gender ?? 'Male';
        $alamat = $request->alamat;
        $email = $request->email;

        // Cek apakah password tidak kosong
        if (!empty($request->password)) {
            $password = Hash::make($request->password);

            // Update semua data termasuk password
            $data = [
                'nama_karyawan' => $nama_karyawan,
                'jabatan_id' => $jabatan_id,
                'no_hp' => $no_hp,
                'tanggal_lahir' => $tanggal_lahir,
                'gender' => $gender,
                'alamat' => $alamat,
                'email' => $email,
                'password' => $password
            ];
        } else {
            // Update tanpa password jika tidak diisi
            $data = [
                'nama_karyawan' => $nama_karyawan,
                'jabatan_id' => $jabatan_id,
                'no_hp' => $no_hp,
                'tanggal_lahir' => $tanggal_lahir,
                'gender' => $gender,
                'alamat' => $alamat,
                'email' => $email
            ];
        }

        // Lakukan update pada database
        $update = DB::table('karyawan')->where('id', $id)->update($data);

        // Redirect back setelah update
        if ($update) {
            return Redirect::back()->with('success', 'Profile berhasil diupdate!');
        } else {
            return Redirect::back()->with('error', 'Gagal mengupdate profile!');
        }
    }

    public function izin(Request $request)
    {
        $karyawan = Auth::guard('karyawan')->user()->id;

        if (!empty($request->bulan) && !empty($request->tahun)) {
            $data_izin = DB::table('pengajuan_izin')
                ->where('karyawan_id', $karyawan)
                ->whereRaw('MONTH(tanggal_izin_dari) = ?', [$request->bulan]) // Gunakan parameter binding
                ->whereRaw('YEAR(tanggal_izin_dari) = ?', [$request->tahun])
                ->orderBy('tanggal_izin_dari', 'desc')
                ->limit(5)
                ->get();
        } else {
            $data_izin = DB::table('pengajuan_izin')
                ->where('karyawan_id', $karyawan)
                ->orderBy('tanggal_izin_dari', 'desc') // Urutkan data meskipun tanpa filter
                ->get();
        }

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('absensi.izin', compact('data_izin', 'namabulan'));
    }


    public function buatizin()
    {
        return view('absensi.buatizin');
    }

    public function izinsakit(Request $request)
    {
        // $izinsakit  = DB::table('pengajuan_izin')
        //     ->join('karyawan', 'pengajuan_izin.karyawan_id', '=', 'karyawan.id')
        //     ->select(
        //         'pengajuan_izin.id as izin_id',          // Alias untuk id pengajuan izin
        //         'pengajuan_izin.karyawan_id',            // Karyawan id
        //         'pengajuan_izin.tanggal_izin_dari',     // Tanggal izin dari
        //         'pengajuan_izin.tanggal_izin_sampai',   // Tanggal izin sampai
        //         'pengajuan_izin.status',                 // Status izin
        //         'pengajuan_izin.keterangan',            // Keterangan izin
        //         'pengajuan_izin.doc_sid',
        //         'pengajuan_izin.status_approved',
        //         'karyawan.nama_karyawan'
        //     )
        //     ->orderByDesc('tanggal_izin_dari')
        //     ->get();

        // $izinsakit  = DB::table('pengajuan_izin')
        //     ->join('karyawan', 'pengajuan_izin.karyawan_id', '=', 'karyawan.id')
        //     ->select(
        //         'pengajuan_izin.id as izin_id',          // Alias untuk id pengajuan izin
        //         'pengajuan_izin.karyawan_id',            // Karyawan id
        //         'pengajuan_izin.tanggal_izin_dari',     // Tanggal izin dari
        //         'pengajuan_izin.tanggal_izin_sampai',   // Tanggal izin sampai
        //         'pengajuan_izin.status',                 // Status izin
        //         'pengajuan_izin.keterangan',            // Keterangan izin
        //         'pengajuan_izin.doc_sid',
        //         'pengajuan_izin.status_approved',
        //         'karyawan.nama_karyawan'
        //     )
        //     ->orderByDesc('tanggal_izin_dari')
        //     ->get();

        $request->validate([
            'start' => 'date_format:Y-m-d|nullable',
            'end' => 'date_format:Y-m-d|nullable',
        ]);
        $query = Pengajuanizin::query();
        $query->select('pengajuan_izin.kode_izin', 'tanggal_izin_dari', 'tanggal_izin_sampai', 'nama_karyawan', 'status', 'keterangan', 'doc_sid', 'status_approved');
        $query->join('karyawan', 'pengajuan_izin.karyawan_id', '=', 'karyawan.id');
        if (!empty($request->start) && !empty($request->end)) {
            $query->whereBetween('tanggal_izin_dari', [$request->start, $request->end]);
        }
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_karyawan', 'like', '%' . $request->nama_karyawan . '%');
        }
        // if ($request->status_approved  === '0' || $request->status_approved === '1' || $request->status_approved === '2') {
        //     $query->where('status_approved', $request->status_approved);
        // }
        if (in_array($request->status_approved, ['0', '1', '2'], true)) {
            $query->where('status_approved', $request->status_approved);
        }

        $query->orderBy('tanggal_izin_dari', 'desc');
        $izinsakit = $query->paginate(10);
        $izinsakit->appends($request->all());


        return view('admin.izinsakit', compact('izinsakit'));
    }


    public function approveizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $kode_izin = $request->kode_izin_form;
        $dataizin = DB::table('pengajuan_izin')
            ->where('kode_izin', $kode_izin)
            ->first();
        $idkaryawan = $dataizin->karyawan_id;
        $status = $dataizin->status;
        $tgldari = $dataizin->tanggal_izin_dari;
        $tglsampai = $dataizin->tanggal_izin_sampai;

        DB::beginTransaction();
        try {
            if ($status_approved == 1) {
                while (strtotime($tgldari) <= strtotime($tglsampai)) {
                    DB::table('presensi')->insert([
                        'karyawan_id' => $idkaryawan,
                        'tanggal_presensi' => $tgldari,
                        'status' => $status,
                        'kode_izin' => $kode_izin
                    ]);
                    $tgldari = date("Y-m-d", strtotime("+1 days", strtotime($tgldari)));
                }
            }
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
                'status_approved' => $status_approved
            ]);
            DB::commit();
            return Redirect::back();
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back();
        }


        // $update = DB::table('pengajuan_izin')->where('id', $id_izinsakit_form)->update([
        //     'status_approved' => $status_approved
        // ]);

        // if ($update) {
        //     return Redirect::back();
        // } else {
        //     return Redirect::back();
        // }
    }

    public function batalkanizinsakit($kode_izin)
    {

        DB::beginTransaction();
        try {
            $update = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
                'status_approved' => 0
            ]);
            DB::table('presensi')
                ->where('kode_izin', $kode_izin)
                ->delete();
            DB::commit();
            return Redirect::back();
        } catch (\Throwable $th) {
            DB::rollBack();
        }

        $update = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
            'status_approved' => 0
        ]);

        if ($update) {
            return Redirect::back();
        } else {
            return Redirect::back();
        }
    }


    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return response()->json($karyawan);
    }

    public function update(Request $request)
    {
        $karyawan = Karyawan::findOrFail($request->id);

        $karyawan->update([
            'nama_karyawan' => $request->nama_karyawans,
            'jabatan_id' => $request->jabatan_id,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
        ]);

        // Kirim respons JSON untuk SweetAlert2
        return response()->json(['message' => 'Data karyawan berhasil diperbarui.']);
    }

    public function updateJabatan(Request $request, $id)
    {

        // Validasi input
        $request->validate([
            'nama_jabatans' => 'required|string|max:255',
        ]);

        // Temukan data berdasarkan ID
        $jabatan = Jabatan::findOrFail($id);

        // Update data
        $jabatan->nama_jabatan = $request->nama_jabatans;
        $jabatan->save();

        // Berikan respons sukses
        return Redirect::back();
    }

    // public function destroy($id)
    // {
    //     try {
    //         $karyawan = Karyawan::findOrFail($id);
    //         $karyawan->delete();

    //         return response()->json(['success' => 'Data karyawan berhasil dihapus']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Terjadi kesalahan saat menghapus data'], 500);
    //     }
    // }

    // public function hapusJabatan($id)
    // {
    //     try {
    //         // Cari jabatan berdasarkan ID
    //         $jabatan = Jabatan::findOrFail($id);


    //         // Hapus jabatan
    //         $jabatan->delete();

    //         return response()->json(['message' => 'Data jabatan berhasil dihapus']);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Terjadi kesalahan saat menghapus data.'], 500);
    //     }
    // }


    // public function destroy($id)
    // {
    //     try {
    //         $karyawan = Karyawan::findOrFail($id);
    //         $karyawan->delete();

    //         return response()->json(['success' => 'Data karyawan berhasil dihapus']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Terjadi kesalahan saat menghapus data'], 500);
    //     }
    // }

    public function destroy($id)
    {
        try {
            // Cari data karyawan berdasarkan ID
            $karyawan = Karyawan::findOrFail($id);

            // Backup data ke tabel backupkaryawan
            DB::table('backupkaryawan')->insert([
                'id_karyawan' => $karyawan->id,
                'nama_karyawan' => $karyawan->nama_karyawan,
                'jabatan_id' => $karyawan->jabatan_id,
                'email' => $karyawan->email,
                'no_hp' => $karyawan->no_hp,
                'password' => $karyawan->password, // Backup hash password
                'tanggal_lahir' => $karyawan->tanggal_lahir,
                'gender' => $karyawan->gender,
                'alamat' => $karyawan->alamat,
                'created_at' => $karyawan->created_at,
                'updated_at' => $karyawan->updated_at,
            ]);

            // Hapus data karyawan dari tabel utama
            $karyawan->delete();

            return response()->json(['success' => 'Data karyawan berhasil dihapus dan di-backup']);
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah
            return response()->json(['error' => 'Terjadi kesalahan saat menghapus data'], 500);
        }
    }

    // public function hapusJabatan($id)
    // {
    //     try {
    //         // Cari jabatan berdasarkan ID
    //         $jabatan = Jabatan::findOrFail($id);


    //         // Hapus jabatan
    //         $jabatan->delete();

    //         return response()->json(['message' => 'Data jabatan berhasil dihapus']);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => 'Terjadi kesalahan saat menghapus data.'], 500);
    //     }
    // }

    public function hapusJabatan($id)
    {
        try {
            // Cari jabatan berdasarkan ID
            $jabatan = Jabatan::findOrFail($id);

            // Backup data ke tabel backupjabatan
            DB::table('backupjabatan')->insert([
                'id_jabatan' => $jabatan->id,
                'nama_jabatan' => $jabatan->nama_jabatan,
                'created_at' => $jabatan->created_at,
                'updated_at' => $jabatan->updated_at,
            ]);

            // Hapus jabatan
            $jabatan->delete();

            return response()->json(['message' => 'Data jabatan berhasil dihapus dan di-backup']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data.'], 500);
        }
    }

    public function cekpengajuan(Request $request)
    {
        try {
            $tanggal_izin_dari = $request->tanggal_izin_dari; // Tanggal yang diajukan
            $id = Auth::guard('karyawan')->user()->id; // ID karyawan

            // Validasi apakah $tanggal_izin_dari ada
            if (!$tanggal_izin_dari) {
                return response()->json(['error' => 'Tanggal tidak ditemukan'], 400);
            }

            // Periksa apakah tanggal bertabrakan
            $cek = DB::table('pengajuan_izin')
                ->where('karyawan_id', $id)
                ->where(function ($query) use ($tanggal_izin_dari) {
                    $query->whereRaw('? BETWEEN tanggal_izin_dari AND tanggal_izin_sampai', [$tanggal_izin_dari])
                        ->orWhereBetween('tanggal_izin_dari', [$tanggal_izin_dari, $tanggal_izin_dari])
                        ->orWhereBetween('tanggal_izin_sampai', [$tanggal_izin_dari, $tanggal_izin_dari]);
                })
                ->count();

            return response()->json($cek > 0 ? 1 : 0);
        } catch (\Exception $e) {
            // Tangkap error jika ada masalah
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
