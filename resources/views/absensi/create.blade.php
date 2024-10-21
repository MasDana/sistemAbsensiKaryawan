<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="../path/to/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    
    <style>
        #map {
            height: 400px;
        }
    </style>

    @vite('resources/css/app.css')

</head>
<body>
<div class="body bg-gray-100 min-h-screen flex flex-col">
    <!-- Header -->
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
                    <a href="{{ url('/absensi') }}" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-calendar-check mr-2"></i> Kehadiran
                    </a>
                </li>
                <li class="mb-2">
                    <a href="#" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-briefcase mr-2"></i> Jabatan
                    </a>
                </li>
                <li class="mb-2">
                    <a href="{{ route('schedule.index') }}" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-clock mr-2"></i> Schedule 
                    </a>
                </li>
            </ul>
        </nav>

       <!-- Main Content -->
<div class="flex-grow p-6">
    <!-- Header -->
    <div class="bg-indigo-600 text-white p-4 rounded-lg mb-4 text-center">
        <h2 class="text-2xl font-semibold">Proses Absensi</h2>
    </div>
    <!-- Peta dan Kamera -->
    <div class="flex flex-col lg:flex-row lg:space-x-6">
        <!-- Kamera Section -->
        <div class="webcam-section lg:w-1/2">
            <h2 class="text-xl font-semibold mb-4">Webcam</h2>
            <div class="webcam-container">
                <input type="text" name="" id="lokasi" hidden>
                <div class="webcam"></div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="map-section lg:w-1/2 mt-6 lg:mt-0">
            <h2 class="text-xl font-semibold mb-4">Lokasi Anda</h2>
            <div id="map" class="h-64 lg:h-80"></div>
        </div>
    </div>

    <!-- Tombol Absen Masuk -->
    <div class="flex mt-6">
    @if ($cek > 0)
        <button id="ambil_absen" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:scale-105 transition-transform">
            Absen Pulang
        </button>
    @else
        <button id="ambil_absen" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:scale-105 transition-transform">
            Absen Masuk
        </button>
     @endif
    </div>
</div>

    <script>
        Webcam.set({
            height: 400,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });
        
        Webcam.attach('.webcam');
        
        var lokasi = document.getElementById('lokasi');
        
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(successCallback, errorCallback, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        }
        
        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 500
            }).addTo(map);
        }
        
        function errorCallback() {
            swal("Error", "Geolocation gagal. Tidak dapat mengambil lokasi.", "error");
        }

        $("#ambil_absen").click(function(e) {
    e.preventDefault();
    
    // Ambil gambar dari webcam
    Webcam.snap(function(uri) {
        var image = uri; // Simpan gambar dalam variabel
        
        var lokasi = $("#lokasi").val();
        
        // Proses AJAX setelah gambar berhasil diambil
        $.ajax({
            type: "POST",
            url: '/absensi/store',
            data: {
                _token: "{{ csrf_token() }}",
                image: image,
                lokasi: lokasi,
            },
            cache: false,
            success: function(response){
                if (response.status === 'success') {
                    swal("Berhasil!", response.message, "success");
                    setTimeout(function() {
                        location.href = '/dashboard';
                    }, 3000); // Waktu delay dalam milidetik (3000 ms = 3 detik)
                } else if (response.status === 'error') {
                    swal("Gagal!", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "Terjadi kesalahan saat memproses data.", "error");
            }
        });
    });
});

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</div>

</body>