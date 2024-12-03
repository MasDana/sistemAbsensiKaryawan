@php
    $user = Auth::guard('karyawan')->user();
@endphp


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
        integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>

    
    @yield('css')

    @vite('resources/css/app.css')

</head>

<body>
    
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

    <div class="body bg-gray-100 min-h-screen flex flex-col">
        <header class="bg-white py-4 px-4 shadow-md">
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
                    <i class="fa fa-user"></i> 
                    <span>{{ $user->nama_karyawan }}</span>
                    </div>
                    <div class="logout">
                        <form action="/sesi/logout" method="get">
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 w-30 h-10 rounded-md hover:bg-red-700 transition">
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
                    <li class="sidebar-title text-lg font-semibold mb-2 mt-4">Absensi</li>
                    <li class="mb-2">
                        <a href="{{ url('/absensi') }}"
                            class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                            <i class="fas fa-users mr-2"></i> Absen
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/presensi/histori') }}"
                            class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                            <i class="fas fa-calendar-check mr-2"></i> Histori Absen
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/presensi/izin') }}"
                            class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                            <i class="fas fa-briefcase mr-2"></i> Izin
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ url('/editprofile') }}"
                            class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                            <i class="fas fa-bar-chart mr-2"></i> Edit Profile
                        </a>
                    </li>
                </ul>
            </nav>
            @yield('konten')
        </div>
    </div>


    <script src="{{ asset('js/dashboard.js') }}"></script>

    @yield('java')

</body>

</html>
