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


@foreach ($presensi as $item)
    @php
        $foto_masuk = Storage::url('upload/absensi/' . $item->foto_masuk);
        $foto_keluar = Storage::url('upload/absensi/' . $item->foto_keluar);

    @endphp

    @if ($item->status == 'h')
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->karyawan_id }}</td>
            <td>{{ $item->nama_karyawan }}</td>
            <td>{{ $item->jam_masuk != null ? $item->jam_masuk : 'Belum absen' }}</td>
            {{-- <td>{{ $item->foto_masuk }}</td> --}}
            <td class="flex justify-center items-center"><img src="{{ url($foto_masuk) }}" alt=""
                    class="w-[100px] h-[100px] rounded-md object-cover"></td>
            <td>{{ $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}</td>
            {{-- <td>{{ $item->foto_keluar }}</td> --}}
            <td class="flex justify-center items-center"><img src="{{ url($foto_keluar) }}" alt=""
                    class="w-[100px] h-[100px] rounded-md object-cover"></td>
            <td>{{ $item->status = 'Hadir' }}</td>
            <td>
                @if (strtotime($item->jam_masuk) >= strtotime('09:00:00'))
                    @php
                        $jamterlambat = selisih('09:00:00', $item->jam_masuk);
                    @endphp
                    <span>Terlambat {{ $jamterlambat }}</span>
                @else
                    <span>Tepat waktu</span>
                @endif
            </td>

        </tr>
    @else
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->karyawan_id }}</td>
            <td>{{ $item->nama_karyawan }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                @if ($item->status == 's')
                    <p>Sakit</p>
                @elseif($item->status == 'i')
                    <p>Izin</p>
                @endif
            </td>
            <td>{{ $item->keterangan }}</td>
        </tr>
    @endif
@endforeach
