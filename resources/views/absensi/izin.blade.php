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

<body class="bg-gray-100 min-h-screen overflow-y-auto">

    <!-- Header -->
    <header class="bg-white py-4 px-4 sm:px-6 md:px-8 lg:px-20 shadow-md flex-none">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-6">
                <a href="{{ url('/dashkar') }}" class="text-black text-2xl">
                    <i class="fas fa-arrow-left"></i>
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

    <!-- Main Content -->
    <main class="container mx-auto p-4 space-y-4">
        @foreach ($data_izin as $item)
            @php
                $status = $item->status == 'i' ? 'Izin' : ($item->status == 's' ? 'Sakit' : 'Not Found');
            @endphp
            <li class="bg-white shadow-md rounded-lg p-4 flex items-center space-x-4 mb-2">
                <div class="flex-grow flex justify-between items-center">
                    <div class="text-lg font-bold">
                        <b>{{ date('d-m-Y', strtotime($item->tanggal_izin_dari)) }} ({{ $status }})</b><br>
                        <small>{{ date('d-m-Y', strtotime($item->tanggal_izin_dari)) }} s/d
                            {{ date('d-m-Y', strtotime($item->tanggal_izin_sampai)) }}</small>
                        <p>{{ $item->keterangan }}</p>
                    </div>
                    <div class="flex items-center space-x-2 justify-end">
                        @if ($item->status_approved == 0)
                            <span class="badge bg-warning">Waiting</span>
                        @elseif($item->status_approved == 1)
                            <span class="badge bg-success">Approved</span>
                        @elseif($item->status_approved == 2)
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                        <div class="flex items-center space-x-2 justify-end">
                            @if ($item->status == 'i')
                                <!-- Untuk izin -->
                                <a href="{{ url('/izin/edit/' . $item->id) }}"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600 transition">Edit
                                    Izin</a>
                                <form action="{{ url('/izin/delete/' . $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data izin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600 transition">Hapus
                                        Izin</button>
                                </form>
                            @elseif ($item->status == 's')
                                <!-- Untuk sakit -->
                                <a href="{{ url('/sakit/edit/' . $item->id) }}"
                                    class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600 transition">Edit
                                    Sakit</a>
                                <form action="{{ url('/sakit/delete/' . $item->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data sakit?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600 transition">Hapus
                                        Sakit</button>
                                </form>
                            @endif
                        </div>


                    </div>
                </div>
            </li>
        @endforeach
    </main>

    <script>
        document.querySelector('[data-toggle="dropdown"]').addEventListener('click', function() {
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
