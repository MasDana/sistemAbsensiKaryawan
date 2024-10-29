<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $lok_kantor = DB::table('lokasi')->where('id', 1)->first();
        return view('konfigurasi.lokasikantor', compact('lok_kantor'));
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
                return Redirect::back()->with('success', 'Berhasil');
            } else {
                return Redirect::back()->with('warning', 'Gagal');
            }
    }
    
}
