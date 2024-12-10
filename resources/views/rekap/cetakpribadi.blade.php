<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi th,
        .tabelpresensi td {
            border: 2px solid #000000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body class="A4">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <!-- Write HTML just like a web page -->
        <table>
            <tr>
                <td>
                    <img src="{{ asset('gambar/joko_satya.jpg') }}" alt="" width="70" height="70">
                </td>
                <td>
                    <h3>
                        LAPORAN PRESENSI KARYAWAN <br>
                        PERIODE BULAN {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT UDAYANA BALI SEJAHTERA <br>
                    </h3>
                    <span>Jalan Universitas Udayana No 10 </span>
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $karyawan->nama_karyawan }}</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>{{ $karyawan->nama_jabatan }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $karyawan->email }}</td>
            </tr>
            <tr>
                <td>No Hp</td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>

        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Foto Masuk</th>
                <th>Foto Pulang</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($presensi as $d)
                @php
                    $path_in = Storage::url('public/upload/absensi/' . $d->foto_masuk);
                    $path_out = Storage::url('public/upload/absensi/' . $d->foto_keluar);
                    // Hitung jam terlambat berdasarkan jam masuk jika lebih dari jam 10:00
                    $jamterlambat =
                        strtotime($d->jam_masuk) > strtotime('10:00:00') ? selisih('10:00:00', $d->jam_masuk) : null;
                @endphp

                @if ($d->status == 'h')
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tanggal_presensi)) }}</td>
                        <td>{{ $d->jam_masuk }}</td>
                        <td>{{ $d->jam_keluar ? $d->jam_keluar : 'Belum Absen' }}</td>
                        <td>
                            @if ($d->foto_masuk)
                                <img src="{{ url($path_in) }}" alt="Foto Masuk" class="foto" width="50">
                            @else
                                No Photo
                            @endif
                        </td>
                        <td>
                            @if ($d->foto_keluar)
                                <img src="{{ url($path_out) }}" alt="Foto Pulang" class="foto" width="50">
                            @else
                                No Photo
                            @endif
                        </td>
                        <td>Hadir</td>

                        <td>
                            @if (!$d->jam_keluar)
                                <!-- Jika tidak ada jam keluar, hanya tampilkan jam terlambat jika ada -->
                                @if ($jamterlambat)
                                    Terlambat {{ $jamterlambat }}
                                @endif
                            @elseif ($jamterlambat)
                                <!-- Jika ada jam keluar dan terlambat, tampilkan jam terlambat -->
                                Terlambat {{ $jamterlambat }}
                            @else
                                Tepat Waktu
                            @endif
                        </td>

                    </tr>
                @else
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tanggal_presensi)) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            @if ($d->status == 's')
                                <p>Sakit</p>
                            @elseif($d->status == 'i')
                                <p>Izin</p>
                            @endif
                        </td>
                        <td>{{ $d->keterangan }}</td>

                    </tr>
                @endif
            @endforeach
        </table>

        <table width="100%" style="margin-top:100px">
            <tr>
                <td></td>
                <td colspan="2" style="text-align:center">Denpasar, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom; height:100px;">
                    <u>Qiana Aqila</u><br>
                    <i><b>HRD Manager</b></i>
                </td>
                <td style="text-align: center; vertical-align:bottom; height:100px;">
                    <u>Daffa</u><br>
                    <i><b>Direktur</b></i>
                </td>
            </tr>
        </table>

    </section>

</body>

</html>
