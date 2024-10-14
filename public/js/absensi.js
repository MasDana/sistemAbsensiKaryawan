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

// var map; // Declare the map variable outside

// if (navigator.geolocation) {
//     navigator.geolocation.watchPosition(successCallback, errorCallback, {
//         enableHighAccuracy: true,
//         timeout: 10000,
//         maximumAge: 0
//     });
// }

// function successCallback(position) {
//     var latitude = position.coords.latitude;
//     var longitude = position.coords.longitude;

//     // Jika map belum diinisialisasi, buat map baru
//     if (!map) {
//         map = L.map('map').setView([latitude, longitude], 13);
//         L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
//             maxZoom: 19,
//             attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'



//         }).addTo(map);
//     } else {
//         // Jika map sudah ada, cukup perbarui view-nya
//         map.setView([latitude, longitude]);
//     }

//     // Menambahkan marker ke posisi terbaru
//     L.marker([latitude, longitude]).addTo(map)
//         .bindPopup("Lokasi Anda: " + latitude + ", " + longitude)
//         .openPopup();


// }

// function errorCallback(error) {
//     console.error("Error getting location: ", error);
// }
