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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    {{-- <script src="{{ asset('js/dashboard.js') }}"></script> <!-- Hanya untuk menyertakan file eksternal --> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>

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
                    <a href="{{ url('/dashboard') }}" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
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
                    <a href="{{ url('/konfigurasi/lokasikantor') }}"class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                        <i class="fas fa-clock mr-2"></i> Lokasi
                    </a>    
                </li>
            </ul>
        </nav>

        <!-- Konten Utama -->
        <div class="flex-grow flex flex-col">
            <main class="main-dashboard transition-all p-8">
                <!-- Judul -->
                <h2 class="text-3xl font-bold mb-6">Monitoring Presensi</h2>

                <div class="relative mb-6">
                    <input
                        id="tanggal"
                        class="peer h-full w-full rounded-lg border border-gray-300 px-4 py-2.5 bg-white text-sm text-gray-700 placeholder-gray-400 transition-all focus:border-indigo-600 focus:outline-none"
                        placeholder=""
                    />
                    <label for="tanggal"
                        class="absolute left-3 -top-2.5 bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:left-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:left-3 peer-focus:text-xs peer-focus:text-indigo-600 rounded-lg">
                        Pilih Rentang Tanggal
                    </label>
                    
                </div>
                

                <!-- Tabel -->
                <table class="min-w-full border-collapse border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="border border-gray-300 px-4 py-2 text-center">No.</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Jam Masuk</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Jam Keluar</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Keterangan</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Lokasi</th>
                        </tr>
                    </thead>
                    <tbody id="loadpresensi"></tbody>
                </table>
            </main>

            <!-- Footer -->
            <footer class="footer bg-white text-black py-4 px-4 sm:px-6 md:px-8 lg:px-20 mt-auto">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="copyright">&copy; 2024 Manajemen Karyawan</div>
                    <div class="links space-x-4">
                        <a href="#" class="hover:text-indigo-400">Terms of Service</a>
                        <a href="#" class="hover:text-indigo-400">Privacy Policy</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tampilkanpeta" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Lokasi Presensi User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map"></div> 
            </div>
        </div>
    </div>
</div>



@section('java')
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection


    <script>
        const datepicker = flatpickr("#tanggal", {
            mode: "range", 
            dateFormat: "Y-m-d", 
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {
                    const startDate = selectedDates[0].toLocaleDateString('en-CA');
                    const endDate = selectedDates[1].toLocaleDateString('en-CA');    
                    if (startDate === endDate) {
                $.ajax({
                    type: 'POST',
                    url: '/getpresensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal_presensi: startDate 
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: '/getpresensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        start_date: startDate,
                        end_date: endDate
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            }
        }
    }
});
        
        // Styling tambahan untuk datepicker
        datepicker.config.onReady.push(function() {
            const calendarContainer = datepicker.calendarContainer;
            const calendarMonthNav = datepicker.monthNav;
            const calendarNextMonthNav = datepicker.nextMonthNav;
            const calendarPrevMonthNav = datepicker.prevMonthNav;
            const calendarDaysContainer = datepicker.daysContainer;
    
            // Styling elemen-elemen di dalam datepicker
            calendarContainer.className = `${calendarContainer.className} bg-white p-4 border border-blue-gray-50 rounded-lg shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 focus:outline-none break-words whitespace-normal`;
            calendarMonthNav.className = `${calendarMonthNav.className} flex items-center justify-between mb-4 [&>div.flatpickr-month]:-translate-y-3`;
            calendarNextMonthNav.className = `${calendarNextMonthNav.className} absolute !top-2.5 !right-1.5 h-6 w-6 bg-transparent hover:bg-blue-gray-50 !p-1 rounded-md transition-colors duration-300`;
            calendarPrevMonthNav.className = `${calendarPrevMonthNav.className} absolute !top-2.5 !left-1.5 h-6 w-6 bg-transparent hover:bg-blue-gray-50 !p-1 rounded-md transition-colors duration-300`;
            calendarDaysContainer.className = `${calendarDaysContainer.className} [&_span.flatpickr-day]:!rounded-md [&_span.flatpickr-day.selected]:!bg-gray-900 [&_span.flatpickr-day.selected]:!border-gray-900`;
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
</body>
