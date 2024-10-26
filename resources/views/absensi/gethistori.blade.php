@if ($histori->isEmpty())
    <p class="text-center text-gray-500">Data belum ada</p>
@endif

<div class="max-h-96 overflow-y-auto">
    <ul class="px-4 my-4">
        @foreach ($histori as $item) <!-- Pastikan ini adalah loop untuk menampilkan data -->
        <li class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 mb-2">
            @php
                $path = Storage::url('upload/absensi/' . $item->foto_masuk);
            @endphp
            <img src="{{ url($path) }}" alt="image" class="w-32 h-auto rounded-lg">
            
            <div class="flex-grow flex justify-between items-center">
                <!-- Tanggal di sebelah kiri -->
                <div class="text-lg font-bold">
                    {{ date('d-m-Y', strtotime($item->tanggal_presensi)) }}
                </div>

                <!-- Jam masuk dan jam keluar dalam wrapper untuk align right -->
                <div class="flex items-center space-x-2 justify-end">
                    <!-- Jam masuk -->
                    <span class="badge {{ $item->jam_masuk < '07:00' ? 'bg-green-500' : 'bg-red-500' }} text-white px-3 py-2 rounded-lg w-40 h-12 flex items-center justify-center">
                        {{ $item->jam_masuk != null ? $item->jam_masuk : 'Belum absen' }}
                    </span>
                    
                    <!-- Jam keluar dalam badge -->
                    <span class="badge {{ $item->jam_keluar != null ? 'bg-blue-500' : 'bg-gray-400' }} text-white px-3 py-2 rounded-lg w-40 h-12 flex items-center justify-center">
                        {{ $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}
                    </span>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>

