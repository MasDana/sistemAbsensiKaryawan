@foreach ($presensi as $item)
@php
    $foto_masuk=Storage::url('upload/absensi/'.$item->foto_masuk);
    $foto_keluar=Storage::url('upload/absensi/'.$item->foto_keluar);

@endphp
<tr>
            <td class="text-center border border-gray-300">{{ $loop->iteration }}</td>
            <td class="text-center border border-gray-300">{{ $item->karyawan_id }}</td>
            <td class="text-center border border-gray-300">{{ $item->nama_karyawan }}</td>
            <td class="text-center border border-gray-300">{{ $item->jam_masuk != null ? $item->jam_masuk : 'Belum absen' }}</td>
            <td class="flex justify-center items-center h-full"><img src="{{ url($foto_masuk) }}" alt="" class="w-20 h-20 object-cover center"></td>
            <td class="text-center border border-gray-300">{{ $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}</td>
            <td class="flex justify-center items-center h-full"><img src="{{ url($foto_keluar) }}" alt="" class="w-20 h-20 object-cover center"></td>
            <td class="text-center border border-gray-300">
                @if ($item->jam_masuk >= '16:00')
                    <span>Terlambat</span>
                @else
                    <span>Tepat waktu</span>
                @endif
            </td>
        </tr>

@endforeach