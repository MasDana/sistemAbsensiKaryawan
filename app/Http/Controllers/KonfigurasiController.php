<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $user = Auth::guard('user')->user();
        $lok_kantor = DB::table('lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasikantor', compact('lok_kantor', 'user'));
    }



    public function updatelokasi(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table('lokasi')->where('id', 1)
            ->update([
                'lokasi_kantor' => $lokasi_kantor,
                'radius' => $radius
            ]);

        if ($update) {
            // Berhasil diupdate
            return Redirect::back()->with('success', 'Data lokasi berhasil diperbarui.');
        } else {
            // Gagal diupdate
            return Redirect::back()->with('warning', 'Data lokasi gagal diperbarui.');
        }
    }
}
