@extends('/layout/layout')
{{-- 
@section('css')
@vite('resources/css/app.css')
@endsection --}}

@section('konten')

    <section class="container">
        <div class="login-container">
            {{-- @if ($errors->has('default'))
    <div class="error-box">
        <p>{{ $errors->first('default') }}</p>
    </div>
@endif --}}

            <section class="bg-gray-100 flex items-center justify-center bg-cover bg-center bg-no-repeat "
            style="background: linear-gradient(to right, #800080, #0000FF); width: 100vw; height: 100vh; background-size: cover; background-position: center; background-repeat: no-repeat;">
                <div class="flex w-full max-w-4xl bg-white shadow-xl rounded-3xl">

                    <div class="hidden md:block w-1/2 overflow-hidden rounded-3xl">
                        <img src="{{ asset('gambar/login.jpg') }}" alt="Profile" class="object-cover h-full">
                    </div>


                    <div
                        class="bg-white bg-opacity-80 p-8 w-full max-w-md flex items-center justify-center shadow-lg rounded-r-3xl">
                        <form action="/sesi/login" method="POST" class="form w-full">
                            @csrf
                            <h2 class="text-4xl font-bold mb-8 text-center">Login</h2>

                            <div class="input-box mb-4 relative">
                                <label for="email" class="text-lg sm:text-xl font-semibold block mb-2">Email</label>

                                <!-- Input Field -->
                                <input type="email" id="email" value="{{ Session::get('email') }}" name="email"
                                    placeholder="Email"
                                    class="border border-gray-300 rounded-lg p-2 w-full @error('email') is-invalid @enderror">

                            </div>

                            <div class="input-box mb-4 relative">
                                <label for="password" class="text-lg sm:text-xl font-semibold block mb-2">Password</label>

                                <!-- Input Field with Show Password Icon -->
                                <div class="relative">
                                    <input type="password" id="password" name="password" placeholder="Password"
                                        class="border border-gray-300 rounded-lg p-2 w-full @error('password') is-invalid @enderror">
                                    <img src="{{ asset('gambar/buka.png') }}" onclick="pass()"
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 h-8 w-8 cursor-pointer"
                                        id="pass-icon" alt="Toggle Password">
                                </div>

                            </div>

                            <div class="akun mb-4">
                                <p>Belum punya akun? <a href="{{ url('/register') }}" class="text-blue-500">Register</a></p>
                            </div>

                            <button type="submit" class="bg-blue-600 text-white py-2 rounded-md w-full">Login</button>

                            <!-- Error Messages Below Login Button -->
                            <div class="mt-4">
                                @if ($errors->has('email'))
                                    <p class="text-red-500 text-sm">{{ $errors->first('email') }}</p>
                                @endif
                                @if ($errors->has('password'))
                                    <p class="text-red-500 text-sm">{{ $errors->first('password') }}</p>
                                @endif
                                @if ($errors->has('default'))
                                    <p class="text-red-500 text-sm">{{ $errors->first('default') }}</p>
                                @endif
                            </div>

                        </form>
                    </div>
                </div>
            </section>

        @section('java')
            <script src="{{ asset('js/index.js') }}"></script>
        @endsection

    @endsection
