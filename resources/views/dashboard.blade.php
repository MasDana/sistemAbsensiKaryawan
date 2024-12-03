@extends('layout/layoutadmin')

@section('css')
@endsection

@section('konten')
    <!-- Konten Utama -->
    <div class="main-dashboard grid grid-cols-2 gap-8 p-8 w-full mx-auto transition-all">
        <!-- Card Karyawan -->
        <div class="main-card flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
            <i class="fas fa-users text-6xl mb-2"></i>
            <h3 class="text-xl">Pegawai</h3>
            <p class="text-2xl font-bold">{{ $totalKaryawan }}</p>
        </div>

        <!-- Card Kehadiran -->
        <div
            class="card-dashboard flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
            <i class="fas fa-calendar-check text-6xl mb-2"></i>
            <h3 class="text-xl">Kehadiran</h3>
            <p class="text-2xl font-bold">{{ $totalKehadiranHariIni }}</p>
        </div>
    </div>
    </main>


@section('java')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
@endsection
