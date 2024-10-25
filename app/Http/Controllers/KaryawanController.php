<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{

    public function index()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }
    public function edit()
    {
        $id = Auth::guard('karyawan')->user()->id;
        return view('karyawan.index');
        $karyawan = DB::table('karyawan')->where('id', $id)->first();
        dd($karyawan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:karyawan,email,' . $id,
            'no_hp' => 'nullable|string|max:15',
            'ttl' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'jabatan' => 'required|exists:jabatan,id',
        ]);

        $employee = Karyawan::find($id);

        $employee->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'ttl' => $request->ttl,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'jabatan_id' => $request->jabatan,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate');
    }
}
