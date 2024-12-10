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


class RekapController extends Controller
{
    public function rekappribadi()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $tahunini = date("Y");
        $karyawan = DB::table('karyawan')->orderBy('nama_karyawan')->get();
        return view('rekap.rekappribadi', compact('namabulan', 'tahunini', 'karyawan'));
    }

    public function laporanpribadi(Request $request)
    {
        $id = $request->karyawan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $karyawan = DB::table('karyawan')
            ->join('jabatan', 'karyawan.jabatan_id', '=', 'jabatan.id')
            ->where('karyawan.id', $id)
            ->select('karyawan.*', 'jabatan.nama_jabatan')
            ->first();
        $presensi = DB::table('presensi')
            ->select('presensi.*', 'keterangan')
            ->leftJoin('pengajuan_izin', 'presensi.kode_izin', '=', 'pengajuan_izin.kode_izin')
            ->where('presensi.karyawan_id', $id)
            ->whereRaw('MONTH(tanggal_presensi) = ?', [$bulan])
            ->whereRaw('YEAR(tanggal_presensi) = ?', [$tahun])
            ->orderBy('tanggal_presensi')
            ->get();
        // dd($karyawan, $presensi);
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('rekap.cetakpribadi', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function rekapsemua()
    {

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $tahunini = date("Y");

        return view('rekap.rekapsemua', compact('namabulan'));
    }

    public function laporansemua(Request $request)
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $dari =  $tahun . "-" . $bulan . "-01";
        $sampai = date("Y-m-t", strtotime($dari));
        $selectdate = "";
        $fielddate = "";
        $i = 1;

        while (strtotime($dari) <= strtotime($sampai)) {
            $rangetanggal[] = $dari;
            $selectdate .= "MAX(IF(tanggal_presensi = '$dari', CONCAT(
                IFNULL(jam_masuk, 'NA'), '|',
                IFNULL(jam_keluar, 'NA'),'|',
                IFNULL(presensi.status, 'NA'), '|',
                IFNULL(presensi.kode_izin, 'NA'), '|',
                IFNULL(keterangan, 'NA')), NULL)) as tgl_" . $i . ",";

            $fielddate .= "tgl_" . $i . ",";
            $i++;
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        $jmlhari = count($rangetanggal);
        $lastrange = $jmlhari - 1;
        $sampai = $rangetanggal[$lastrange];
        if ($jmlhari == 30) {
            array_push($rangetanggal, NULL);
        } else if ($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL);
        } else if ($jmlhari == 28) {
            array_push($rangetanggal, NULL, NULL, NULL);
        }

        $query = Karyawan::query();
        $query = $query->selectRaw("$fielddate karyawan.id, nama_karyawan");

        $query->leftJoin(
            DB::raw("(
        SELECT 
        $selectdate
        presensi.karyawan_id
        FROM presensi
        LEFT JOIN pengajuan_izin ON presensi.kode_izin = pengajuan_izin.kode_izin
        WHERE tanggal_presensi BETWEEN '$rangetanggal[0]' AND '$sampai' 
        GROUP BY presensi.karyawan_id

        )presensi"),
            function ($join) {
                $join->on('karyawan.id', '=', 'presensi.karyawan_id');
            }
        );

        $query->orderBy('nama_karyawan');
        $rekap = $query->get();


        return view('rekap.cetaksemua', compact('bulan', 'tahun', 'rekap', 'namabulan', 'rangetanggal', 'jmlhari'));
    }
}
