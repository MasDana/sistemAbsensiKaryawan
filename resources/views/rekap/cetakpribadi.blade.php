<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4 Attendance Report</title>

    <!-- Normalize or reset CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

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

        @media print {
            .page-break {
                page-break-after: always;
                margin-top: 20px;
            }
        }
    </style> @vite('resources/css/app.css')
</head>

<body class="A4">
    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        // Fungsi selisih waktu tetap sama
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

    <section class="sheet padding-20mm">
        <!-- Header tetap sama -->
        <table class="w-full">
            <tr class="w-full flex flex-row gap-4">
                <td class="mr-4 flex justify-center items-center">
                    <img src="{{ asset('gambar/logo_unud.png') }}" alt="Logo Udayana" width="100px" height="100px">
                </td>
                <td class="flex flex-col justify-start items-start text-start">
                    <h3 class="text-lg font-bold">
                        LAPORAN PRESENSI KARYAWAN <br>
                        PERIODE BULAN {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        PT UDAYANA BALI SEJAHTERA <br>
                    </h3>
                    <span class="text-sm">Jalan Universitas Udayana No 10</span>
                </td>
            </tr>
        </table>

        <!-- Informasi karyawan tetap sama -->
        <table class="mt-4">
            <!-- ... -->
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
            <tbody>
                @foreach ($presensi as $d)
                    @php
                        $path_in = Storage::url('public/upload/absensi/' . $d->foto_masuk);
                        $path_out = Storage::url('public/upload/absensi/' . $d->foto_keluar);
                        $jamterlambat =
                            strtotime($d->jam_masuk) > strtotime('10:00:00')
                                ? selisih('10:00:00', $d->jam_masuk)
                                : null;
                        $isHalamanBaru = $loop->iteration % 10 == 1 && $loop->iteration != 1;
                    @endphp

                    @if ($isHalamanBaru)
        </table>
        <div class="halaman-baru"></div>
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
            @endif

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
                <td>{{ $d->status == 'h' ? 'Hadir' : ($d->status == 's' ? 'Sakit' : 'Izin') }}</td>
                <td>{{ $d->keterangan }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Bagian tanda tangan tetap sama -->
        <table width="100%" style="margin-top:100px">
            <!-- ... -->
        </table>
    </section>
</body>

</html>
