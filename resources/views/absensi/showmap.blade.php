

<!-- Elemen Peta -->
<div id="map" style="height: 300px;
      width: 100%;" ></div>

<!-- Link Leaflet CSS dan JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
  // Mendapatkan lokasi dari Laravel
  var lokasi = "{{ $presensi->lokasi_in }}";
  var lok = lokasi.split(",");
  
  // Memastikan lokasi valid
  if (lok.length === 2) {
      var latitude = parseFloat(lok[0]);
      var longitude = parseFloat(lok[1]);
      
      if (!isNaN(latitude) && !isNaN(longitude)) {
          // Inisialisasi peta
          var map = L.map('map').setView([latitude, longitude], 13);
          L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
              maxZoom: 19,
              attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
          }).addTo(map);
          
          // Tambahkan marker dan circle
          var marker = L.marker([latitude, longitude]).addTo(map);
          var circle = L.circle([latitude, longitude], {
              color: 'red',
              fillColor: '#f03',
              fillOpacity: 0.5,
              radius: 20
          }).addTo(map);

          // Tambahkan popup
          var popupContent = "{{ $presensi->nama_lengkap ?? 'Lokasi User' }}";
          var popup = L.popup()
              .setLatLng([latitude, longitude])
              .setContent(popupContent)
              .openOn(map);
      } else {
          console.error("Invalid coordinates provided.");
      }
  } else {
      console.error("Location data is not in the expected format.");
  }
</script>
