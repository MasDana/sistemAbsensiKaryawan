@php
function selisih($jam_masuk, $jam_keluar)
{
    list($h, $m, $s) = explode(":", $jam_masuk);
    $dtAwal = mktime($h, $m, $s, "1", "1", "1");
    list($h, $m, $s) = explode(":", $jam_keluar);
    $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
    $dtSelisih = $dtAkhir - $dtAwal;
    $totalmenit = $dtSelisih / 60;
    $jam = explode(".", $totalmenit / 60);
    $sisamenit = ($totalmenit / 60) - $jam[0];
    $sisamenit2 = $sisamenit * 60;
    $jml_jam = $jam[0];
    return $jml_jam . ":" . round($sisamenit2);
}
@endphp


@foreach ($presensi as $item)
@php
    $foto_masuk=Storage::url('upload/absensi/'.$item->foto_masuk);
    $foto_keluar=Storage::url('upload/absensi/'.$item->foto_keluar);

@endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->karyawan_id }}</td>
        <td>{{ $item->nama_karyawan }}</td>
        <td>{{ $item->jam_masuk != null ? $item->jam_masuk : 'Belum absen' }}</td>
        {{-- <td>{{ $item->foto_masuk }}</td> --}}
        <td><img src="{{ url($foto_masuk) }}" alt="" class="avatar"></td>
        <td>{{ $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}</td>
        {{-- <td>{{ $item->foto_keluar }}</td> --}}
        <td><img src="{{ url($foto_keluar) }}" alt="" class="avatar"></td>
        <td>
            @if (strtotime($item->jam_masuk) >= strtotime('06:00:00'))
                @php
                    $jamterlambat = selisih('06:00:00', $item->jam_masuk);
                @endphp
                <span>Terlambat {{ $jamterlambat }}</span>
            @else
                <span>Tepat waktu</span>
            @endif
        </td>
        
        

    </tr>
@endforeach


