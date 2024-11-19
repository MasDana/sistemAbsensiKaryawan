{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="w-full bg-white shadow-md p-6">
        <h2 class="text-center text-xl font-semibold mb-4">Histori Presensi</h2>

        <form action="#" class="space-y-4">
            <!-- Dropdown Bulan -->
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select id="bulan" name="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}"> {{ $namabulan [$i] }}</option>
                   @endfor
                </select>
            </div>

            <!-- Dropdown Tahun -->
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select id="tahun" name="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Tahun</option>
                    @php
                        $tahunmulai = 2023;
                        $tahunsekarang = date("Y");
                    @endphp
                     @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                     <option value="{{ $tahun }}"> {{ $tahun }}</option>
                     @endfor
                </select>
            </div>

            <div class="flex justify-center space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit
                </button>
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Search
                </button>
            </div>
        </form>
    </div>

</body>
</html>x --}}

<!DOCTYPE html>
<html lang="id">

@vite('resources/css/app.css')


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
        integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../path/to/sweetalert.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" />


</head>

<body class="bg-gray-100 min-h-screen ">

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
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div>
        @foreach ($data_izin as $item)
            <!-- Pastikan ini adalah loop untuk menampilkan data -->
            @php
                if ($item->status == 'i') {
                    $status = 'Izin';
                } elseif ($item->status == 's') {
                    $status = 'Sakit';
                } else {
                    $status = 'Not Found';
                }
            @endphp
            <li class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 mb-2">
                <div class="flex-grow flex justify-between items-center">
                    <!-- Tanggal di sebelah kiri -->
                    <div class="text-lg font-bold">
                        <b> {{ date('d-m-Y', strtotime($item->tanggal_izin_dari)) }} ({{ $status }}) </b><br>
                        <small>{{ date('d-m-Y', strtotime($item->tanggal_izin_dari)) }} s/d
                            {{ date('d-m-Y', strtotime($item->tanggal_izin_sampai)) }}</small>
                        <p>{{ $item->keterangan }}</p>
                    </div>

                    <div class="flex items-center space-x-2 justify-end">
                        @if ($item->status_approved == 0)
                            <span class="badge bg-warning">Waiting</span>
                        @elseif($item->status_approved == 1)
                            <span class="badge bg-warning">Approved</span>
                        @elseif($item->status_approved == 2)
                            <span class="badge bg-warning">Rejected</span>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </div>

    <div class="fixed bottom-16 right-16 dropdown">
        <button class="bg-blue-500 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg"
            data-toggle="dropdown">
            <ion-icon name="add-outline" class="w-6 h-6"></ion-icon>
        </button>
        <div class="dropdown-menu hidden mt-2 bg-white shadow-lg rounded-lg py-2">
            <a class="dropdown-item flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100" href="/izin">
                <ion-icon name="document-outline" class="w-5 h-5 mr-2"></ion-icon>
                <p>Izin Absen</p>
            </a>
            <a class="dropdown-item flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100" href="/sakit">
                <ion-icon name="document-outline" class="w-5 h-5 mr-2"></ion-icon>
                <p>Sakit</p>
            </a>
        </div>
    </div>

    <script>
        document.querySelector('[data-toggle="dropdown"]').addEventListener('click', function() {
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
