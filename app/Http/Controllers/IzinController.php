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
        $status = "s";
        $keterangan = $request->keterangan;

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
        $tgl_izin_dari = date('Y-m-d', strtotime($request->tgl_izin_dari));
        $tgl_izin_sampai = date('Y-m-d', strtotime($request->tgl_izin_sampai));


        // Simpan data
        $data = [
            'karyawan_id' => $karyawan_id,
            'tanggal_izin_dari' => $tgl_izin_dari,
            'tanggal_izin_sampai' => $tgl_izin_sampai,
            'status' => $status,
            'keterangan' => $keterangan,
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);
        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'berhasil']);
        } else {
            return redirect('/izin')->with(['error' => 'gagal']);
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
        $status = "i";
        $keterangan = $request->keterangan;
        $kode_izin = rand();

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
            return redirect('/sakit')->with(['error' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }
}
