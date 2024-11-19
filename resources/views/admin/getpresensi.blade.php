<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

@php
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
@endphp

<div class="container mt-4">
    <table class="table table-bordered table-striped">
    <table class="min-w-full border-collapse border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="border border-gray-300 px-4 py-2 text-center">No.</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Jam Masuk</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Jam Keluar</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Keterangan</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Lokasi</th>
                        </tr>
                    </thead>
                   
        <tbody>
            @foreach ($presensi as $item)
                @php
                    $foto_masuk = Storage::url('upload/absensi/' . $item->foto_masuk);
                    $foto_keluar = Storage::url('upload/absensi/' . $item->foto_keluar);
                @endphp
                <span>Terlambat {{ $jamterlambat }}</span>
            @else
                <span>Tepat waktu</span>
            @endif
        </td>



    </tr>
@endforeach
