@extends('layout/layoutkaryawan')

@section('css')
@endsection

@section('konten')
    <!-- Konten Utama -->
        <!-- Konten Utama -->
        <div class="flex-grow overflow-y-auto p-6">
            <!-- Card Profil -->
            <div class="card flex items-center bg-white p-6 rounded-lg shadow-md w-full mb-8">
                <div
                    class="image-section flex-shrink-0 flex items-center justify-center bg-indigo-600 p-1.5 w-40 h-40 rounded-full">
                    <img src= "{{ asset('gambar/joko_satya.jpg') }}" alt="Profile picture"
                        class="w-full h-full rounded-full">
                </div>
                <div class="text-section ml-8 flex flex-col justify-center">
                    <h2 class="text-2xl font-bold">Joko Satya </h2>
                    <h3 class="text-lg font-bold text-gray-600 mt-2">Business Analyst Strategy Development</h3>
                </div>
            </div>

            {{-- Absen Masuk dan Pulang --}}
            <div class="card bg-white p-6 rounded-lg shadow-md mb-8 flex flex-col">
                <div class="grid grid-cols-2 gap-6 mb-4"> <!-- Grid untuk dua kolom tanpa flex-grow -->
                    <!-- Card Absen Masuk -->
                    <div class="card bg-green-600 text-white p-4 rounded-lg shadow-lg flex items-center justify-center">
                        <ion-icon name="camera" class="text-4xl mr-4"></ion-icon>
                        <div>
                            <h4 class="font-semibold">Masuk</h4>
                            <span>{{ $presensihariini != null ? $presensihariini->jam_masuk : 'Belum absen' }}</span>
                        </div>
                    </div>
                    <!-- Card Absen Pulang -->
                    <div class="card bg-red-600 text-white p-4 rounded-lg shadow-lg flex items-center justify-center">
                        <ion-icon name="camera" class="text-4xl mr-4"></ion-icon>
                        <div>
                            <h4 class="font-semibold">Pulang</h4>
                            <span>{{ $presensihariini != null && $presensihariini->jam_keluar != null ? $presensihariini->jam_keluar : 'Belum absen' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Menu-bar -->
            <h1 class="text-xl font-semibold">Rekap Presensi Bulan {{ $namabulan[$bulanini] }} Tahun {{ $tahunini }}
            </h1> <br>
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="relative card bg-white py-4 px-4 rounded-xl shadow-md text-center">
                    <a href="#" class="text-indigo-800 text-4xl">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                    <span class="text-sm font-semibold mt-2 block">Hadir</span>
                    <span
                        class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">{{ $rekappresensi->totalhadir }}</span>
                </div>

                <div class="relative card bg-white py-4 px-4 rounded-xl shadow-md text-center">
                    <a href="#" class="text-indigo-800 text-4xl">
                        <i class="fa-solid fa-clock"></i>
                    </a>
                    <span class="text-sm font-semibold mt-2 block">Terlambat</span>
                    <span
                        class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold rounded-full h-6 w-6 flex items-center justify-center">{{ $rekappresensi->jumlah_tlt }}</span>
                </div>
            </div>


            {{-- Rincian Absen --}}
            <div class="card presencetab bg-white px-4 py-2 mb-24 rounded-lg shadow-md flex flex-col overflow-y-auto">
                <div class="tab-content mt-1 p-2">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($historibulanini as $item)
                                <li class="mb-4"> <!-- Tambahkan margin bawah -->
                                    <div class="item flex items-center space-x-4">
                                        <div class="icon-box bg-primary">
                                            <i class="fa-solid fa-fingerprint text-indigo-700 text-4xl"></i>
                                            <!-- Ikon -->
                                        </div>
                                        <div class="in flex-grow flex justify-between items-center">
                                            <div class="text-lg font-semibold">
                                                {{ date('d-m-y', strtotime($item->tanggal_presensi)) }}
                                            </div>
                                            <div class="flex space-x-2 items-center justify-end">
                                                <span
                                                    class="badge bg-green-500 text-white px-3 py-2 rounded-lg w-40 h-12 flex items-center justify-center">
                                                    {{ $item->jam_masuk }}
                                                </span>
                                                <span
                                                    class="badge bg-red-500 text-white px-3 py-2 rounded-lg w-40 h-12 flex items-center justify-center">
                                                    {{ $presensihariini != null && $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}
                                                </span>
                                                <span
                                                    class="badge bg-blue-500 text-white px-3 py-2 rounded-lg w-40 h-12 flex items-center justify-center">
                                                    @if (strtotime($item->jam_masuk) >= strtotime('09:00:00'))
                                                        @php
                                                            $jamterlambat = selisih('09:00:00', $item->jam_masuk);
                                                        @endphp
                                                        <span>Terlambat {{ $jamterlambat }}</span>
                                                    @elseif (strtotime($item->jam_masuk) >= strtotime('06:00:00'))
                                                        <span>Tepat waktu</span>
                                                    @else
                                                        <span>Terlambat
                                                            {{ selisih('09:00:00', $item->jam_masuk) }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
        </div>


@section('java')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    
@endsection
@endsection


