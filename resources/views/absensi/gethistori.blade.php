@if ($histori->isEmpty())
    <p class="text-center text-gray-500">Data belum ada</p>
@endif

@foreach ($histori as $item)
    <ul class="my-4">
        <li class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4">
            @php
                $path = Storage::url('upload/absensi/' . $item->foto_masuk);
            @endphp
            <img src="{{ url($path) }}" alt="image" class="w-32 h-auto rounded-lg">
            <div class="flex-grow">
                <div class="flex justify-between items-center">
                    <b class="text-lg">{{ date('d-m-Y', strtotime($item->tanggal_presensi)) }}</b>
                    <span class="badge {{ $item->jam_masuk < '07:00' ? 'bg-green-500' : 'bg-red-500' }} text-white px-2 py-1 rounded">
                        {{ $item->jam_masuk }}
                    </span>
                </div>
                <span class="text-gray-700">
                    {{ $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}
                </span>
            </div>
        </li>
    </ul>
@endforeach
