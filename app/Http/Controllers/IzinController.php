<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IzinController extends Controller
{
    public function createizin()

    {
        return view('izin.createizin');
    }

    public function storeizin(Request $request)
    {
        // Ambil ID karyawan
        $karyawan_id = Auth::guard('karyawan')->user()->id;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;

        // Validasi data
        $request->validate([
            'tgl_izin_dari' => 'required|date',
            'tgl_izin_sampai' => 'required|date',
            'status' => 'required',
            'keterangan' => 'required',
        ], [
            'tgl_izin_dari.required' => 'Tanggal mulai harus diisi.',
            'tgl_izin_sampai.required' => 'Tanggal akhir harus diisi.',
            'status.required' => 'Status harus diisi.',
            'keterangan.required' => 'Keterangan harus diisi.',
        ]);

        // Konversi tanggal jika diperlukan
        // $tgl_izin_dari = date('Y-m-d', strtotime($request->tgl_izin_dari));
        // $tgl_izin_sampai = date('Y-m-d', strtotime($request->tgl_izin_sampai));
        $bulan = date("m", strtotime($tgl_izin_dari));
        $tahun = date("Y", strtotime($tgl_izin_dari));
        $thn = substr($tahun, 2, 2);


        $lastizin = DB::table('pengajuan_izin')
            ->whereRaw('MONTH(tanggal_izin_dari)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_izin_dari)="' . $tahun . '"')
            ->orderBy('kode_izin', 'desc')
            ->first();
        $lastkodeizin = $lastizin != null ? $lastizin->kode_izin : "";
        $format = "IZ" . $bulan . $thn;
        $kode_izin = buatkode($lastkodeizin, $format, 3);

        // Simpan data
        $data = [
            'kode_izin' => $kode_izin,
            'karyawan_id' => $karyawan_id,
            'tanggal_izin_dari' => $tgl_izin_dari,
            'tanggal_izin_sampai' => $tgl_izin_sampai,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ];

        $cekpresensi = DB::table('presensi')
            ->where('tanggal_presensi', '>=', $tgl_izin_dari)
            ->where('tanggal_presensi', '<=', $tgl_izin_sampai)
            ->count();
        if ($cekpresensi < 1) {
            return redirect('/presensi/izin');
        } else {
            $simpan = DB::table('pengajuan_izin')->insert($data);
            if ($simpan) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Izin berhasil disimpan.'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan, izin gagal disimpan.'
                ], 500);
            }

            return view('izin.createizin');
        }
    }
    // public function editizin($kode_izin)
    // {
    //     $dataizin = DB::table('pengajuan_izin')->where('id', $kode_izin)->first();
    //     return view('izin.editizin', compact('dataizin'));
    // }

    public function editizin($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();

        // Cek apakah status_approved adalah 1 atau 2
        if ($dataizin && ($dataizin->status_approved == 1 || $dataizin->status_approved == 2)) {
            return redirect('/presensi/izin')->with('error', 'Data izin tidak dapat diedit karena sudah disetujui.');
        }

        return view('izin.editizin', compact('dataizin'));
    }


    public function updateizin($id, Request $request)
    {
        $karyawan_id = Auth::guard('karyawan')->user()->id;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;

        try {
            $data = [
                'tanggal_izin_dari' => $tgl_izin_dari,
                'tanggal_izin_sampai' => $tgl_izin_sampai,
                'keterangan' => $keterangan,
            ];

            DB::table('pengajuan_izin')->where('id', $id)->update($data);
            return redirect('/presensi/izin');
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with('error', 'Something went wrong!');
        }
    }


    public function deleteizin($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();

        if ($dataizin && ($dataizin->status_approved == 1 || $dataizin->status_approved == 2)) {
            return redirect('/presensi/izin')->with('error', 'Data izin tidak dapat dihapus karena sudah disetujui.');
        }

        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->delete();
            return redirect('/presensi/izin')->with('success', 'Data izin berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with('error', 'Terjadi kesalahan saat menghapus data izin.');
        }
    }

    public function createsakit()

    {
        return view('izin.createsakit');
    }


    public function storesakit(Request $request)
    {
        // Validasi data
        $request->validate([
            'tgl_izin_dari' => 'required|date',
            'tgl_izin_sampai' => 'required|date',
            'status' => 'required',
            'keterangan' => 'required',
            'file_input' => 'required|file|mimes:jpg,png,jpeg,gif,svg|max:2048'
        ], [
            'tgl_izin_dari.required' => 'Tanggal mulai harus diisi.',
            'tgl_izin_sampai.required' => 'Tanggal akhir harus diisi.',
            'status.required' => 'Status harus diisi.',
            'keterangan.required' => 'Keterangan harus diisi.',
            'file_input.required' => 'File harus diupload.',
            'file_input.mimes' => 'Format file harus jpg, png, jpeg, gif, atau svg.',
            'file_input.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
        ]);

        $karyawan_id = Auth::guard('karyawan')->user()->id;
        $tgl_izin_dari = date('Y-m-d', strtotime($request->tgl_izin_dari));
        $tgl_izin_sampai = date('Y-m-d', strtotime($request->tgl_izin_sampai));
        $status = "s"; // Status untuk sakit
        $keterangan = $request->keterangan;

        $bulan = date("m", strtotime($tgl_izin_dari));
        $tahun = date("Y", strtotime($tgl_izin_dari));
        $thn = substr($tahun, 2, 2);


        $lastizin = DB::table('pengajuan_izin')
            ->whereRaw('MONTH(tanggal_izin_dari)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_izin_dari)="' . $tahun . '"')
            ->orderBy('kode_izin', 'desc')
            ->first();
        $lastkodeizin = $lastizin != null ? $lastizin->kode_izin : "";
        $format = "IZ" . $bulan . $thn;
        $kode_izin = buatkode($lastkodeizin, $format, 3);

        // Proses upload file
        $sid = null;
        if ($request->hasFile('file_input')) {
            try {
                $file = $request->file('file_input');
                $sid = $kode_izin . "." . $file->getClientOriginalExtension();

                // Pastikan direktori exists
                $storage_path = storage_path('app/public/uploads/sid');
                if (!File::exists($storage_path)) {
                    File::makeDirectory($storage_path, 0777, true);
                }

                // Upload file menggunakan move
                $file->move($storage_path, $sid);

                // Atau gunakan store jika prefer menggunakan Laravel Storage
                // $file->storeAs('public/uploads/sid', $sid);

            } catch (\Exception $e) {
                return redirect('/sakit')->with(['error' => 'Gagal upload file: ' . $e->getMessage()]);
            }
        }

        // Simpan data ke database
        $data = [
            'kode_izin' => $kode_izin,
            'karyawan_id' => $karyawan_id,
            'tanggal_izin_dari' => $tgl_izin_dari,
            'tanggal_izin_sampai' => $tgl_izin_sampai,
            'status' => $status,
            'doc_sid' => $sid,
            'keterangan' => $keterangan
        ];


        try {
            $simpan = DB::table('pengajuan_izin')->insert($data);
            if ($simpan) {
                return redirect('/presensi/izin')->with(['success' => 'Data berhasil disimpan']);
            }
        } catch (\Exception $e) {
            // Jika gagal menyimpan ke database, hapus file yang sudah diupload
            if ($sid && File::exists(storage_path('app/public/uploads/sid/' . $sid))) {
                File::delete(storage_path('app/public/uploads/sid/' . $sid));
            }
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            // return redirect('/sakit')->with(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }



    public function editsakit($kode_sakit)
    {
        $datasakit = DB::table('pengajuan_izin')->where('kode_izin', $kode_sakit)->first();
        return view('izin.editsakit', compact('datasakit'));
    }

    public function updatesakit($kode_sakit, Request $request)
    {
        $tgl_izin_dari = date('Y-m-d', strtotime($request->tgl_izin_dari));
        $tgl_izin_sampai = date('Y-m-d', strtotime($request->tgl_izin_sampai));
        $keterangan = $request->keterangan;

        // Proses upload file
        $sid = null;

        if ($request->hasFile('file_input')) {
            try {
                $file = $request->file('file_input');
                $sid = $kode_sakit . "." . $file->getClientOriginalExtension();

                // Pastikan direktori ada
                $storage_path = storage_path('app/public/uploads/sid');
                if (!File::exists($storage_path)) {
                    File::makeDirectory($storage_path, 0777, true);
                }

                // Upload file menggunakan move
                $file->move($storage_path, $sid);

                // Atau gunakan storeAs jika prefer menggunakan Laravel Storage
                // $file->storeAs('public/uploads/sid', $sid);

            } catch (\Exception $e) {
                return redirect('/presensi/izin')->with(['error' => 'File gagal diunggah: ' . $e->getMessage()]);
            }
        }

        // Data untuk diperbarui
        $data = [
            'tanggal_izin_dari' => $tgl_izin_dari,
            'tanggal_izin_sampai' => $tgl_izin_sampai,
            'keterangan' => $keterangan,
            'doc_sid' => $sid, // Tetap null jika tidak ada file
        ];

        try {
            DB::table('pengajuan_izin')
                ->where('id', $kode_sakit)
                ->update($data);

            return redirect('/presensi/izin')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with(['error' => 'Data Gagal Disimpan: ' . $e->getMessage()]);
        }
    }

    public function deletesakit($kode_sakit)
    {
        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_sakit)->delete();
            return redirect('/presensi/izin')->with('success', 'Data sakit berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect('/presensi/izin')->with('error', 'Terjadi kesalahan saat menghapus data sakit.');
        }
    }
}
