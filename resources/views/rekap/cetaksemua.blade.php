<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Presensi Karyawan</title>

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
    <!-- Paper.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Custom Styles -->
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

<body class="A4 landscape">
    <!-- Header Section -->
    <section class="sheet padding-10mm">
        <table>
            <tr>
                <td>
                    <img src="{{ asset('gambar/joko_satya.jpg') }}" alt="Logo" width="70" height="70">
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

        <!-- Tabel Presensi -->
        <table class="tabelpresensi">
            <thead>
                <tr>
                    <th rowspan="2">Nama Karyawan</th>
                    <th colspan="{{ $jmlhari }}">Bulan {{ $namabulan[$bulan] }} {{ $tahun }}</th>
                    <th rowspan="2">H</th>
                    <th rowspan="2">I</th>
                    <th rowspan="2">S</th>
                    <th rowspan="2">A</th>
                    <th rowspan="2">T</th>

                </tr>
                <tr>
                    @foreach ($rangetanggal as $d)
                        <th>{{ date('d', strtotime($d)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rekap as $d)
                    <tr>
                        <td>{{ $d->nama_karyawan }}</td>
                        @php
                            $jmlhadir = 0;
                            $jmlsakit = 0;
                            $jmlizin = 0;
                            $jmlalpa = 0;
                        @endphp

                        @for ($i = 1; $i <= $jmlhari; $i++)
                            @php
                                $tgl = 'tgl_' . $i;
                                $datapresensi = $d->$tgl ? explode('|', $d->$tgl) : null;
                                $color = '';
                                // $status = $datapresensi ? $datapresensi[2] : '';

                                if ($d->$tgl != null) {
                                    $status = $datapresensi[2];
                                } else {
                                    $status = '';
                                }

                                if ($status == 'h') {
                                    $jmlhadir += 1;
                                } elseif ($status == 's') {
                                    $jmlsakit += 1;
                                    $color = 'blue';
                                } elseif ($status == 'i') {
                                    $jmlizin += 1;
                                    $color = 'yellow';
                                } elseif (empty($status)) {
                                    $jmlalpa += 1;
                                    $color = 'red';
                                }
                            @endphp
                            <td style="background-color: {{ $color }}">{{ $status }}</td>
                        @endfor
                        <td>{{ !empty($jmlhadir) ? $jmlhadir : '' }}</td>
                        <td>{{ !empty($jmlizin) ? $jmlizin : '' }}</td>
                        <td>{{ !empty($jmlsakit) ? $jmlsakit : '' }}</td>
                        <td>{{ !empty($jmlalpa) ? $jmlalpa : '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tanda Tangan -->
        <table width="100%" style="margin-top: 100px;">
            <tr>
                <td style="text-align: center; vertical-align: bottom; height: 100px;">
                    <u>Qiana Aqila</u><br>
                    <i><b>HRD Manager</b></i>
                </td>
                <td style="text-align: center; vertical-align: bottom; height: 100px;">
                    <u>Daffa</u><br>
                    <i><b>Direktur</b></i>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>
