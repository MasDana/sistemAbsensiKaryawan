@extends('layout/layout')

@extends('layout/script')

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
                    <span class="text-black">Nama</span>
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

    <!-- Main content -->
    <div class="flex flex-grow">
        <!-- Sidebar -->
        <nav class="sidebar bg-white text-black w-60 p-8 shadow-right flex-none">
            <ul>
                <li class="sidebar-title text-lg font-semibold mb-2">Report</li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-gray-400 rounded transition">
                        <i class="fas fa-home mr-2"></i> Beranda
                    </a>
                </li>
                <li class="sidebar-title text-lg font-semibold mb-2 mt-4">Manage</li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-gray-400 rounded transition">
                        <i class="fas fa-calendar-check mr-2"></i> Kehadiran
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-gray-00 rounded transition">
                        <i class="fas fa-clock mr-2"></i> Jadwal Kerja
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Konten Utama -->
        <div class="flex-grow flex flex-col">
            <main class="employee-dashboard p-8 flex-grow transition-all">
                <h1 class="text-left text-2xl text-black font-bold mb-5">Dashboard Karyawan</h1>
                <div class="card flex bg-white p-8 rounded-lg shadow-md">
                    <div class="image-section">
                        <img src="{{ asset('gambar/profile1.jpg') }}" alt="Profile picture of I Putu Putri Kumala Sari" class="w-[500px] h-[350px] rounded-lg ml-">
                    </div>
                    <div class="text-section ml-6">
                        <h2 class="text-4xl font-bold ">I Putu Putri Kumala Sari</h2>
                        <h3 class="text-2xl font-bold text-gray-600 mt-2">Business Analyst Strategy Development</h3>
                        <p class="text-black text-xl mt-4  leading-relaxed">"The key to success in business analysis is the ability to accurately interpret data, understand needs, and turn opportunities into solid, sustainable strategies for business growth."</p>
                    </div>
                </div>
            </main>

            <main class="main-dashboard grid grid-cols-2 gap-8 p-8 w-full h-[40vh] mx-auto transition-all">
                <div class="main-card flex flex-col items-center justify-center bg-gray-600 text-white rounded-lg shadow-lg h-full">
                    <i class="fas fa-chart-line text-8xl mb-2"></i>
                    <h3 class="text-2xl">Pencapaian</h3>
                </div>
                <div class="card-dashboard flex flex-col items-center justify-center bg-gray-600 text-white rounded-lg shadow-lg h-full">
                    <i class="fas fa-briefcase text-8xl mb-2"></i>
                    <h3 class="text-2xl">Kinerja</h3>
                </div>
            </main>

            <footer class="footer bg-white text-black my-0 py-4 px-4 sm:px-6 md:px-8 lg:px-20">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="copyright">&copy; 2024 Manajemen Karyawan</div>
                    <div class="links space-x-4">
                        <a href="#" class="hover:text-indigo-400">Terms of Service</a>
                        <a href="#" class="hover:text-indigo-400">Privacy Policy</a>
                        <a href="#" class="hover:text-indigo-400">English</a>
                    </div>
                    <div class="social"></div>
                </div>
            </footer>

        </div>
    </div>
</div>


@section('java')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
