@extends('layout/layoutadmin')

@section('css')
@endsection

@section('konten')
    <!-- Konten Utama -->
    <div class="flex-grow flex flex-col">
        <main class="main-dashboard grid grid-cols-3 gap-8 p-8 w-full mx-auto transition-all">
            <div
                class="main-card flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
                <i class="fas fa-users text-6xl mb-2"></i>
                <h3 class="text-xl">Pegawai</h3>
            </div>
            <div
                class="card-dashboard flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
                <i class="fas fa-briefcase text-6xl mb-2"></i>
                <h3 class="text-xl">Shift</h3>
            </div>
            <div
                class="card-dashboard flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
                <i class="fas fa-calendar-check text-6xl mb-2"></i>
                <h3 class="text-xl">Kehadiran</h3>
            </div>
    </div>
    </main>


@section('java')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
@endsection
