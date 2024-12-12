<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Absensi</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body>

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
                        <span>Joko Satya</span>
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
                    <li class="sidebar-title text-lg font-semibold mb-2 mt-4">Dashboard</li>
                    <li class="mb-2">
                        <a href="{{ url('/dashkar') }}"
                            class="flex items-center p-2 hover:bg-indigo-600 rounded transition">
                            <i class="fas fa-house mr-2"></i> Beranda
                        </a>
                    </li>
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

            <!-- Konten -->
            <div class="flex-grow ">
                <div class="body bg-gray-100 min-h-screen flex justify-center items-center">
                    <div class="card bg-white rounded-2xl shadow-2xl mt-6 mb-6 w-full lg:w-4/5 mx-auto">
                        <h1 class="bg-indigo-700 px-6 py-4 text-xl font-bold text-center mb-4 rounded-t-xl text-white">
                            Perbarui Data Anda
                        </h1>

                        <div class="p-4">
                            <form action="/karyawan/{{ $karyawan->id }}" method="post" class="space-y-4"
                                id="updateForm">
                                @csrf
                                <!-- Nama -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="relative">
                                        <label class="block text-gray-600 font-medium mb-2 text-sm">Nama
                                            Karyawan</label>
                                        <input type="text" name="nama_karyawan" placeholder="Nama"
                                            value="{{ $karyawan->nama_karyawan }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 mt-3">
                                            <i class="fa-solid fa-user text-gray-400"></i>
                                        </span>
                                    </div>

                                    <!-- No HP -->
                                    <div class="relative">
                                        <label class="block text-gray-600 font-medium mb-2 text-sm">No HP</label>
                                        <input type="text" name="no_hp" placeholder="No HP"
                                            value="{{ $karyawan->no_hp }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 mt-3">
                                            <i class="fa-solid fa-phone text-gray-400"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Tanggal Lahir dan Gender -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-gray-600 font-medium mb-2 text-sm">Tanggal
                                            Lahir</label>
                                        <input type="date" name="tanggal_lahir"
                                            value="{{ $karyawan->tanggal_lahir }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-gray-600 font-medium mb-2 text-sm">Gender</label>
                                        <div class="flex gap-4 mt-2">
                                            <label class="flex items-center">
                                                <input type="radio" name="gender" value="male"
                                                    {{ $karyawan->gender == 'male' || is_null($karyawan->gender) ? 'checked' : '' }}>
                                                <span class="ml-2">Male</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="gender" value="female"
                                                    {{ $karyawan->gender == 'female' ? 'checked' : '' }}>
                                                <span class="ml-2">Female</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="relative">
                                    <label class="block text-gray-600 font-medium mb-2 text-sm">Alamat</label>
                                    <input type="text" name="alamat" placeholder="Alamat"
                                        value="{{ $karyawan->alamat }}"
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 mt-3">
                                        <i class="fa-solid fa-map-marker-alt text-gray-400"></i>
                                    </span>
                                </div>

                                <!-- Jabatan -->
                                <div>
                                    <label class="block text-gray-600 font-medium mb-2 text-sm">Jabatan</label>
                                    <select name="jabatan_id"
                                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @foreach ($jabatan as $j)
                                            <option value="{{ $j->id }}"
                                                {{ $karyawan->jabatan_id == $j->id ? 'selected' : '' }}>
                                                {{ $j->nama_jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Email dan Password -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="relative">
                                        <label class="block text-gray-600 font-medium mb-2 text-sm">Email</label>
                                        <input type="text" name="email" placeholder="Email"
                                            value="{{ $karyawan->email }}"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 mt-2">
                                            <i class="fa-solid fa-envelope text-gray-400"></i>
                                        </span>
                                    </div>

                                    <div class="relative mb-2">
                                        <label class="block text-gray-600 font-medium mb-2 text-sm">Password</label>
                                        <input type="password" name="password" placeholder="Password"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                                    </div>
                                </div>

                                <!-- Button -->
                                <div class="flex justify-end items-end mt-2">
                                    <button type="submit"
                                        class="px-6 py-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/updatedata.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

    <script>
        // Menampilkan SweetAlert setelah update
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
            });
        @endif
    </script>

</body>

</html>
