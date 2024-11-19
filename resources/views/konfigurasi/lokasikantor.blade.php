@extends('layout/layoutadmin')

@section('konten')
    <!-- Konten Utama -->
    <main class="main-dashboard flex-grow p-8 bg-gray-100">
        <h2 class="text-3xl font-bold mb-6">Master Data Lokasi</h2>
        <div class="w-full p-4">
            <form action="/konfigurasi/updatelok" method="post" class="space-y-4 bg-white rounded shadow-md p-6">
                @csrf

                <!-- Input Lokasi Kantor -->
                <div>
                    <label for="lokasi_kantor" class="block text-sm font-medium text-gray-700">Lokasi Kantor</label>
                    <input type="text" name="lokasi_kantor" value="{{ $lok_kantor->lokasi_kantor }}" id="lokasi_kantor"
                        placeholder="Masukkan Lokasi Kantor"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Input Radius -->
                <div>
                    <label for="radius" class="block text-sm font-medium text-gray-700">Radius (m)</label>
                    <input type="text" name="radius" value="{{ $lok_kantor->radius }}" id="radius"
                        placeholder="Masukkan Radius"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-500 focus:outline-none">
                </div>

                <!-- Tombol Update -->
                <div>
                    <button type="submit"
                        class="w-full py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </main>
@endsection
