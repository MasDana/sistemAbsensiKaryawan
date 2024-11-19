@extends('/layout/layout')

@section('css')

@endsection

@section('konten')

    <section class="bg-gray-100 flex items-center justify-center bg-cover bg-center bg-no-repeat bg-fixed w-full h-screen"
        style="background-image: url('{{ asset('gambar/bgloginblur.jpg') }}');">

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/sesi/create" method="POST" class="w-full max-w-3xl bg-white p-16 rounded-lg shadow-lg">
            @csrf
            <h1 class="text-3xl font-bold text-center mb-6">Register</h1>

            {{-- <div class="mb-4">
            <label for="employee_id" class="block text-gray-700">Employee Id</label>
            <input type="text" id="employee_id" name="employee_id" placeholder="Nomor Karyawan" class="w-full px-4 py-2 border rounded-lg @error('employee_id') border-red-500 @enderror">
            @error('employee_id')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div> --}}

            <div class="mb-4">
                <label for="nama_karyawan" class="block text-gray-700">Nama Karyawan</label>
                <input type="text" id="nama_karyawan" name="nama_karyawan" placeholder="Nama Karyawan"
                    class="w-full px-4 py-2 border rounded-lg @error('nama_karyawan') border-red-500 @enderror">
                @error('nama_karyawan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-1/2">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" id="email" name="email" placeholder="Email"
                    class="w-full px-4 py-2 border rounded-lg @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            </div>

            <div class="w-1/2">
                <label for="no_hp" class="block text-gray-700">No Hp</label>
                <input type="text" id="no_hp" name="no_hp" placeholder="Nomor Hp"
                    class="w-full px-4 py-2 border rounded-lg @error('no_hp') border-red-500 @enderror" required>
                @error('no_hp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            </div>

            <div class="flex mb-4 space-x-4">
                <div class="w-1/2">
                    <label for="tanggal_lahir" class="block text-gray-700">Tanggal Lahir</label>
                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                        class="w-full px-4 py-2 border rounded-lg @error('tanggal_lahir') border-red-500 @enderror">
                    @error('tanggal_lahir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700">Alamat</label>
                    <input type="text" id="alamat" name="alamat" placeholder="Alamat"
                        class="w-full px-4 py-2 border rounded-lg @error('alamat') border-red-500 @enderror">
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mb-4">
                <h3 class="text-gray-700">Gender</h3>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" id="male" name="gender" value="male" class="form-radio" checked>
                        <span class="ml-2">Male</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="female" name="gender" value="female" class="form-radio">
                        <span class="ml-2">Female</span>
                    </label>
                </div>
            </div>

            {{-- <div class="flex mb-4 space-x-4"> --}}
            <div class="w-1/2">
                <label for="jabatan_id" class="block text-gray-700">Jabatan</label>
                <select id="jabatan_id" name="jabatan_id" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="" disabled selected>Pilih Jabatan</option>
                    @foreach ($jabatan as $jabatan)
                        <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                    @endforeach
                </select>
            </div>

            {{-- <div class="w-1/2">
                <label for="schedule_id" class="block text-gray-700">Schedule</label>
                <select id="schedule_id" name="schedule_id" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="" disabled selected>Pilih Schedule</option>
                    @foreach ($schedules as $schedule)
                        <option value="{{ $schedule->id }}">{{ $schedule->slug }}</option>
                    @endforeach
                </select>
            </div> --}}
            {{-- </div> --}}

            <div class="flex mb-4 space-x-4">
                <div class="w-1/2">
                    <label for="password" class="block text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Password"
                            class="w-full px-4 py-2 border rounded-lg @error('password') border-red-500 @enderror">
                        <img src="{{ asset('gambar/buka.png') }}" onclick="pass2()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 cursor-pointer"
                            alt="Toggle Password">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-1/2">
                    <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            placeholder="Confirm Password" class="w-full px-4 py-2 border rounded-lg">
                        <img src="{{ asset('gambar/buka.png') }}" onclick="pass1()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 cursor-pointer"
                            alt="Toggle Password">
                    </div>
                </div>
            </div>

            <div class="text-center mb-6">
                <p>Sudah punya akun? <a href="{{ url('/sesi') }}" class="text-blue-500">Login</a></p>
            </div>

            <button type="submit"
                class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition">Register</button>
        </form>

    </section>

@section('java')

    <script src="{{ asset('js/register.js') }}"></script>

@endsection
