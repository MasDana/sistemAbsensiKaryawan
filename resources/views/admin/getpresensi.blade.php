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
            @if ($item -> jam_masuk >= '16:00')
            <span>Terlambat</span>
            @else
                <span>tepat waktu</span>
            @endif
        </td>

    </tr>
@endforeach