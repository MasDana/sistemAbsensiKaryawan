<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rekap Karyawan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

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

</head>
<body class="body bg-gray-100 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-white py-4 px-4 sm:px-6 md:px-8 lg:px-20 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <div class="toggle-sidebar mr-4 md:mr-8">
                <button id="toggleButton" class="text-gray-700 focus:outline-none">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            <h1 class="text-black text-2xl font-bold">Sistem Manajemen Karyawan</h1>
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

<!-- Main Content Wrapper -->
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
                <a href="{{ url('/konfigurasi/lokasikantor') }}" class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                    <i class="fas fa-clock mr-2"></i> Lokasi
                </a>    
            </li>
        </ul>
    </nav>

<!-- Main Content -->
<main class="flex-grow p-8 ">
<h2 class="text-3xl font-bold mb-6">Master Data Karyawan</h2>
    <!-- Tombol Tambah Data dan Form Pencarian -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <button id="btntambahkaryawan" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-4 md:mb-0 md:mr-4">
            Tambah Data
        </button>
        <form action="/rekapkaryawan" method="get" class="flex items-center">
            <input type="text" name="nama_karyawan" id="nama_karyawan" placeholder="Nama" value="{{ request('nama_karyawan') }}" class="border border-gray-300 p-2 rounded mr-2" />
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Cari</button>
        </form>
    </div>

    <!-- Tabel Karyawan -->
    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full bg-white border rounded-lg">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2 text-left">No</th>
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">Jabatan</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-left">No Hp</th>
                    <th class="border px-4 py-2 text-left">Gender</th>
                    <th class="border px-4 py-2 text-left">Alamat</th>
                    <th class="border px-4 py-2 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($karyawan as $key => $item)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2">{{ $karyawan->firstItem() + $key }}</td>
                        <td class="border px-4 py-2">{{ $item->nama_karyawan }}</td>
                        <td class="border px-4 py-2">{{ $item->nama_jabatan }}</td>
                        <td class="border px-4 py-2">{{ $item->email }}</td>
                        <td class="border px-4 py-2">{{ $item->no_hp }}</td>
                        <td class="border px-4 py-2">{{ $item->gender }}</td>
                        <td class="border px-4 py-2">{{ $item->alamat }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Aksi</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<nav aria-label="Page navigation" class="mt-4">
    <ul class="inline-flex -space-x-px text-sm">
        {{-- Tombol Previous --}}
        <li>
            <a href="{{ $karyawan->previousPageUrl() }}" 
               class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
               {{ $karyawan->onFirstPage() ? 'disabled' : '' }}>Previous</a>
        </li>

        {{-- Halaman Pagination --}}
        @foreach ($karyawan->getUrlRange(1, $karyawan->lastPage()) as $page => $url)
            <li>
                <a href="{{ $url }}" 
                   class="flex items-center justify-center px-3 h-8 leading-tight 
                          {{ $karyawan->currentPage() == $page ? 'text-blue-600 bg-blue-50' : 'text-gray-500 bg-white' }}
                          border border-gray-300 hover:bg-gray-100 hover:text-gray-700 
                          dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    {{ $page }}
                </a>
            </li>
        @endforeach

        {{-- Tombol Next --}}
        <li>
            <a href="{{ $karyawan->nextPageUrl() }}" 
               class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
               {{ $karyawan->hasMorePages() ? '' : 'disabled' }}>Next</a>
        </li>
    </ul>
</nav>
</main>
<!-- Modal -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full h-auto overflow-hidden">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">Tambah Data Karyawan</h3>
            <button type="button" class="text-gray-400 hover:bg-gray-200 p-1 rounded" id="closeModal">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 8.586l4.95-4.95a1 1 0 111.415 1.415L11.414 10l4.95 4.95a1 1 0 01-1.415 1.415L10 11.414l-4.95 4.95a1 1 0 01-1.415-1.415L8.586 10 3.636 5.05a1 1 0 111.415-1.415L10 8.586z"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4 max-h-96 overflow-y-auto"> <!-- Set max height and enable scrolling -->
            <form action="{{ url('/store/karyawan-data') }}" method="POST" id="form-karyawan">
                @csrf
                <!-- Input Nama -->
                <div class="mb-4">
                    <label for="nama_karyawans" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="nama_karyawans" name="nama_karyawans" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>
                
                <!-- Dropdown Jabatan -->
                <div class="mb-4">
                    <label for="jabatan_id" class="block text-sm font-medium text-gray-700">Jabatan</label>
                    <select id="jabatan_id" name="jabatan_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                        <option value="">Pilih Jabatan</option>
                        @foreach($jabatan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>

                <!-- Input No HP -->
                <div class="mb-4">
                    <label for="no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
                    <input type="tel" id="no_hp" name="no_hp" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>

                <!-- Input Tanggal Lahir -->
                <div class="mb-4">
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>

                <!-- Radio Button Gender -->
                <div class="mb-4">
                    <h3 class="text-gray-700">Gender</h3>
                    <div class="flex space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" id="male" name="gender" value="male" class="form-radio" checked>
                            <span class="ml-2">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" id="female" name="gender" value="female" class="form-radio">
                            <span class="ml-2">Perempuan</span>
                        </label>
                    </div>
                </div>

                <!-- Input Alamat -->
                <div class="mb-4">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
                </div>

                <!-- Input Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end p-4 border-t">
            <button type="button" id="closeModalFooter" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
            <button type="submit" form="form-karyawan" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </div>
</div>


    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function(){
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Modal handlers
            $('#btntambahkaryawan').on('click', function() {
                $('#default-modal').removeClass('hidden');
            });

            $('#closeModal, #closeModalFooter').on('click', function() {
                $('#default-modal').addClass('hidden');
                $('#form-karyawan')[0].reset();
            });

            // Form submit handler
            $("#form-karyawan").submit(function(e){
                e.preventDefault();
                
                // Create FormData object
                var formData = new FormData(this);

                // Submit form using AJAX
                $.ajax({
                    type: "POST",
                    url: "/store/karyawan-data",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response){
                        // Show success message if provided
                        if(response.message) {
                            alert(response.message);
                        }

                        // Close modal and reset form
                        $('#default-modal').addClass('hidden');
                        $('#form-karyawan')[0].reset();
                        
                        // Reload page to show new data
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Log error to console for debugging
                        console.error(xhr.responseText);
                        
                        // Show error message
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert("Terjadi kesalahan saat menyimpan data");
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>