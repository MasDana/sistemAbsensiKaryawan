@extends('layout/layout')

@section('css')

@endsection

@section('konten')

<div class="body bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-white py-4 px-4 sm:px-6 md:px-8 lg:px-20 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <div class="toggle-sidebar mr-4 md:mr-8">
                    <button id="toggleButton" class="text-gray-700 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
                <div class="text-black text-2xl font-bold flex items-center"> 
                    <h1>Sistem Manajemen Karyawan</h1>
                </div>
            </div>
            <div class="header-right flex items-center space-x-2 md:space-x-4"> 
                <div class="profile flex items-center space-x-2 md:space-x-4">
                    <img src="{{ asset('gambar/tara.png') }}" alt="Profile" class="w-12 h-12 rounded-full">
                    <span class="text-black">{{ $user -> name }}</span>
                </div>
                <div class="logout">
                    <form action="/sesi/logout" method="get">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-grow">
        <!-- Sidebar -->
        <nav class="sidebar bg-white text-black w-60 p-8 shadow-right flex-none">
            <ul>
                <li class="sidebar-title text-lg font-semibold mb-2">Report</li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-home mr-2"></i> Beranda
                    </a>
                </li>
                <li class="sidebar-title text-lg font-semibold mb-2 mt-4">Manage</li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-users mr-2"></i> Karyawan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ url('/presensi/monitoring') }}" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-calendar-check mr-2"></i> Monitor Presensi
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-briefcase mr-2"></i> Jabatan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#"class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-clock mr-2"></i> Schedule 
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Konten Utama -->
        <div class="flex-grow flex flex-col">
            <main class="main-dashboard grid grid-cols-3 gap-8 p-8 w-full mx-auto transition-all">
                <div class="main-card flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
                    <i class="fas fa-users text-6xl mb-2"></i>
                    <h3 class="text-xl">Pegawai</h3>
                </div>
                <div class="card-dashboard flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
                    <i class="fas fa-briefcase text-6xl mb-2"></i>
                    <h3 class="text-xl">Shift</h3>
                </div>
                <div class="card-dashboard flex flex-col items-center justify-center bg-indigo-600 text-white rounded-lg shadow-lg h-40">
                    <i class="fas fa-calendar-check text-6xl mb-2"></i>
                    <h3 class="text-xl">Kehadiran</h3>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="footer bg-white text-black py-4 px-4 sm:px-6 md:px-8 lg:px-20 mt-auto">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="copyright">&copy; 2024 Manajemen Karyawan</div>
                    <div class="links space-x-4">
                        <a href="#" class="hover:text-indigo-400">Terms of Service</a>
                        <a href="#" class="hover:text-indigo-400">Privacy Policy</a>
                        <a href="#" class="hover:text-indigo-400">English</a>
                    </div>
                </div>
            </footer>

        </div>
    </div>
</div>

@section('java')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection

@endsection
