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
    <header class="bg-white py-4 px-4 sm:px-6 md:px-8 lg:px-20 shadow-md flex-none">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <a href="{{ url('/dashkar') }}" class="text-black text-2xl">
                    <i class="fas fa-arrow-left"></i> <!-- Ikon panah -->
                </a>
                <h1 class="text-black text-2xl font-bold">Sistem Manajemen Karyawan</h1>
            </div>
            <div class="header-right flex items-center space-x-2 md:space-x-4"> 
                <div class="profile flex items-center space-x-2 md:space-x-4">
                    <img src="{{ asset('gambar/profile1.jpg') }}" alt="Profile" class="w-12 h-12 rounded-full">
                    <span class="text-black">Sariwati</span>
                </div>
                <form action="/sesi/logout" method="get">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>
    

    <div class="card bg-white rounded-2xl shadow-2xl mt-10 mb-10 mx-28">
    
        <!-- Heading -->
        <h1 class="bg-indigo-700 px-6 py-4 text-xl font-bold text-center mb-4 rounded-t-xl text-white">Lakukan Absensi Anda</h1>
        
        <!-- Peta dan Kamera -->
        <div class="p-8 flex lg:space-x-10">
            
            <!-- Kamera Section -->
            <div class="webcam-secti    on w-[700px] lg:mb-0"> <!-- Ukuran disamakan dengan peta -->
                <h2 class="text-xl font-semibold mb-2 text-gray-900">Webcam</h2>
                <div class="webcam-container rounded-lg overflow-hidden">
                    <input type="text" name="" id="lokasi" hidden>
                    <div class="webcam h-48 bg-gray-200 flex items-center justify-center rounded-2xl"> 
                        <span class="text-gray-500">Kamera tidak tersedia</span>
                    </div>
                </div>
            </div>
        
            <!-- Map Section -->
            <div class="map-section w-[1200px] lg:mt-0">
                <h2 class="text-xl font-semibold mb-2 text-gray-900">Lokasi Anda</h2>
                <div id="map" class="h-48 lg:h-64 border rounded-2xl shadow-md overflow-hidden"></div>
            </div>
        </div>
        
        <!-- Tombol Absen Masuk -->
        <div class="flex p-8 items-center justify-center">
            @if ($cek > 0)
                <button id="ambil_absen" class="bg-indigo-600 text-l text-white px-4 py-3 rounded-lg hover:scale-105 transition-transform flex items-center">
                    <i class="fas fa-camera mr-2"></i> Absen Pulang
                </button>
            @else
                <button id="ambil_absen" class="bg-indigo-600 text-l text-white px-4 py-3 rounded-lg hover:scale-105 transition-transform flex items-center">
                    <i class="fas fa-camera mr-2 text-xl"></i> Absen Masuk
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

            var lokasi_kantor = "{{$lok_kantor->lokasi_kantor}}";
            var lok = lokasi_kantor.split(",");
            var latitudekantor = lok[0];
            var longitudekantor = lok[1];

            var radius = "{{$lok_kantor->radius}}";

            // Logging untuk memastikan nilai latitudekantor dan longitudekantor
            console.log("Latitude Kantor:", latitudekantor);
            console.log("Longitude Kantor:", longitudekantor);

            // Inisialisasi map pada posisi kantor
            var map = L.map('map').setView([latitudekantor, longitudekantor], 13);

            // Menambahkan tile layer ke map
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            console.log("Map initialized.");

            // Tambahkan marker dan circle untuk lokasi kantor
            var kantorMarker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            console.log("Marker for kantor added.");

            var kantorCircle = L.circle([latitudekantor, longitudekantor], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: radius
            }).addTo(map);
            console.log("Circle for kantor radius added.");

            // Tambahkan marker untuk lokasi pengguna
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            console.log("Marker for user location added.");
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
                        location.href = '/dashkar';
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</div>

</body>