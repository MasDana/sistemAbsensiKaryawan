<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

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
        return view('dashboard', compact('user'));
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
                    'lokasi_in' => $lokasi
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
            ->where('karyawan_id', $karyawan_id)
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
        return view('absensi.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi'));
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
        return view('admin.monitoring');
    }

    public function getpresensi(Request $request)
    {
        if ($request->has('tanggal_presensi')) {
            // Query untuk satu tanggal
            $presensi = DB::table('presensi')
                ->select('presensi.*', 'nama_karyawan')
                ->join('karyawan', 'presensi.karyawan_id', '=', 'karyawan.id')
                ->where('tanggal_presensi', $request->tanggal_presensi)
                ->get();
        } else {
            // Query untuk rentang tanggal
            $presensi = DB::table('presensi')
                ->select('presensi.*', 'nama_karyawan')
                ->join('karyawan', 'presensi.karyawan_id', '=', 'karyawan.id')
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

    public function izin()
    {
        return view('absensi.izin');
    }

    public function buatizin()
    {
        return view('absensi.buatizin');
    }

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)->first();
    
        return view('absensi.showmap', compact('presensi'));
    }
    
}

