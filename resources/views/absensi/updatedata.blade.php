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

    <section class="bg-gray-100 flex items-center justify-center bg-cover bg-center bg-no-repeat min-w-screen min-h-screen" style="background-image: url('{{ asset('gambar/bgloginblur.jpg') }}');">
        <card class="w-full max-w-4xl h-auto p-12 bg-white shadow-xl rounded-3xl overflow-auto">
            <!-- Header Card -->
            <div class="mb-8 border-b-2 border-gray-400 pb-4 flex items-center">
                <h1 class="mr-5 text-2xl font-semibold text-gray-900">Edit Profile Karyawan</h1> 
                <i class="fa-solid fa-pen text-gray-900"></i> <!-- Ikon di sebelah kanan -->
            </div>
            
            <form action="/karyawan/{{$karyawan->id}}" method="post" class="space-y-6">
                @csrf
    
                <!-- Nama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative">
                        <label class="block text-gray-600 font-medium mb-2 text-sm">Nama Karyawan</label>
                        <input type="text" name="nama_karyawan" placeholder="Nama"
                               value="{{ $karyawan->nama_karyawan }}"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"> <!-- Tambahkan padding right -->
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
                        <label class="block text-gray-600 font-medium mb-2 text-sm">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" 
                                value="{{ $karyawan->tanggal_lahir }}"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                     
                    <div>
                        <label class="block text-gray-600 font-medium mb-2 text-sm">Gender</label>
                            <div class="flex gap-4 mt-2">
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="Male" 
                                        {{ $karyawan->gender == 'Male' || is_null($karyawan->gender) ? 'checked' : '' }}
                                        class="form-radio text-blue-500">
                                    <span class="ml-2">Male</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="gender" value="Female"
                                        {{ $karyawan->gender == 'Female' ? 'checked' : '' }}
                                        class="form-radio text-blue-500">
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
                        @foreach($jabatan as $j)
                            <option value="{{ $j->id }}" {{ $karyawan->jabatan_id == $j->id ? 'selected' : '' }}>
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
    
                    <div class="relative mb-4">
                        <label class="block text-gray-600 font-medium mb-2 text-sm">Password</label>
                        <input id="password" type="password" name="password" placeholder="Password"
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10"> <!-- Tambahkan padding right untuk ruang ikon -->
                        <span id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/6 cursor-pointer">
                            <i class="fa-solid fa-eye-slash text-gray-400" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
    
                <!-- Tombol Submit -->
                <div class="grid grid-cols-2 gap-4 justify-end mt-2">
                    <a href="{{ url('/dashkar') }}" 
                       class="px-6 py-3 text-center text-white bg-gray-500 rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                       Kembali
                    </a>
                
                    <button type="submit" 
                            class="px-6 py-3 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit
                    </button>
                </div>
            </form>
        </card>
    </section>
    
    
    

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="{{ asset('js/updatedata.js') }}"></script>

</body>
</html>