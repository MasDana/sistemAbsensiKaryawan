@extends('layout/layout')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/absensi.css') }}">
@endsection

@section('konten')

<div>
    <input type="text" name="" id="lokasi">
    <div class="webcam"></div>
</div>

<div id="map"></div>

<button id="ambil_absen">Absen Masuk</button>

@section('java')
    <script src="{{ asset('js/absensi.js') }}"></script>
@endsection

@endsection

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <style>
    #map {
        height: 500px;
    }
    </style>

    @vite('resources/css/app.css')

</head>
    <body>

        <div>
            <input type="text" name="" id="lokasi">
            <div class="webcam"></div>
        </div>
        
        <div id="map">
                
        </div>
            
        <button id="ambil_absen" type="submit">
        Absen Masuk
        </button>    

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
                    enableHighAccuracy: true, // Menambah akurasi
                    timeout: 5000,            // Maksimal waktu menunggu lokasi
                    maximumAge: 0             // Jangan gunakan lokasi yang di-cache
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
                alert("Geolocation gagal. Tidak dapat mengambil lokasi.");
            }
        
            $("#ambil_absen").click(function(e) {
                e.preventDefault(); // Mencegah form submit otomatis
                
                Webcam.snap(function(uri) {
                    image = uri;
                });
                
                var lokasi = $("#lokasi").val();
                
                $.ajax({
                    type: "POST",
                    url: '/absensi/store',
                    data: {
                        _token: "{{ csrf_token() }}", // Pastikan ini sesuai dengan format Blade
                        image: image,
                        lokasi: lokasi,
                    },
                    cache: false,
                    success: function(respond) {
                    if (respond == 0) {
                        alert('Success');
                    } else if (respond == 1) {
                        alert('Error');
                    }
                },

                });
            });
        </script>
        

    </body>
</html>



