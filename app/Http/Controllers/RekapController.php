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
            ->where('karyawan_id', $id)
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
        while (strtotime($dari) <= strtotime($sampai)) {
            $rangetanggal[] = $dari;
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        $jmlhari = count($rangetanggal);

        if ($jmlhari == 30) {
            array_push($rangetanggal, NULL);
        } else if ($jmlhari == 29) {
            array_push($rangetanggal, NULL, NULL);
        }

        $query = Karyawan::query();
        $query = $query->selectRaw("
        karyawan.id, 
        nama_karyawan,
        tgl_1,
        tgl_2,
        tgl_3,
        tgl_4,
        tgl_5,
        tgl_6,
        tgl_7,
        tgl_8,
        tgl_9,
        tgl_10,
        tgl_11,
        tgl_12,
        tgl_13,
        tgl_14,
        tgl_15,
        tgl_16,
        tgl_17,
        tgl_18,
        tgl_19,
        tgl_20,
        tgl_21,
        tgl_22,
        tgl_23,
        tgl_24,
        tgl_25,
        tgl_26,
        tgl_27,
        tgl_28,
        tgl_29,
        tgl_30,
        tgl_31
    ");
        $query->leftJoin(
            DB::raw("(
        SELECT presensi.karyawan_id,
    MAX(IF(tanggal_presensi = '$rangetanggal[0]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_1,

    MAX(IF(tanggal_presensi = '$rangetanggal[1]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_2,

    MAX(IF(tanggal_presensi = '$rangetanggal[2]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_3,

    MAX(IF(tanggal_presensi = '$rangetanggal[3]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_4,

    MAX(IF(tanggal_presensi = '$rangetanggal[4]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_5,

    MAX(IF(tanggal_presensi = '$rangetanggal[5]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_6,

    MAX(IF(tanggal_presensi = '$rangetanggal[6]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_7,

    MAX(IF(tanggal_presensi = '$rangetanggal[7]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_8,

    MAX(IF(tanggal_presensi = '$rangetanggal[8]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'),'|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_9,

    MAX(IF(tanggal_presensi = '$rangetanggal[9]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_10,

    MAX(IF(tanggal_presensi = '$rangetanggal[10]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_11,

    MAX(IF(tanggal_presensi = '$rangetanggal[11]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_12,

    MAX(IF(tanggal_presensi = '$rangetanggal[12]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_13,

    MAX(IF(tanggal_presensi = '$rangetanggal[13]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_14,

    MAX(IF(tanggal_presensi = '$rangetanggal[14]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_15,

    MAX(IF(tanggal_presensi = '$rangetanggal[15]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_16,

    MAX(IF(tanggal_presensi = '$rangetanggal[16]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_17,

    MAX(IF(tanggal_presensi = '$rangetanggal[17]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_18,

    MAX(IF(tanggal_presensi = '$rangetanggal[18]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_19,

    MAX(IF(tanggal_presensi = '$rangetanggal[19]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_20,

    MAX(IF(tanggal_presensi = '$rangetanggal[20]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_21,

    MAX(IF(tanggal_presensi = '$rangetanggal[21]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_22,

    MAX(IF(tanggal_presensi = '$rangetanggal[22]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_23,

    MAX(IF(tanggal_presensi = '$rangetanggal[23]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_24,

    MAX(IF(tanggal_presensi = '$rangetanggal[24]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_25,

    MAX(IF(tanggal_presensi = '$rangetanggal[25]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_26,

    MAX(IF(tanggal_presensi = '$rangetanggal[26]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_27,

    MAX(IF(tanggal_presensi = '$rangetanggal[27]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_28,

    MAX(IF(tanggal_presensi = '$rangetanggal[28]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_29,

    MAX(IF(tanggal_presensi = '$rangetanggal[29]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_30,

    MAX(IF(tanggal_presensi = '$rangetanggal[30]', CONCAT(
        IFNULL(jam_masuk, 'NA'), '|',
        IFNULL(jam_keluar, 'NA'), '|',
        IFNULL(presensi.status, 'NA'), '|',
        
        IFNULL(presensi.kode_izin, 'NA'), '|',
        IFNULL(keterangan, 'NA')), NULL)) as tgl_31

        FROM presensi
        LEFT JOIN pengajuan_izin ON presensi.kode_izin = pengajuan_izin.kode_izin
        WHERE tanggal_presensi BETWEEN '$dari' AND '$sampai' 
        GROUP BY karyawan_id

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
