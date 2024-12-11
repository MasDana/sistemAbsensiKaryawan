@extends('layout/layoutadmin')

@section('konten')
    <div>

<main class="flex-grow p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl text-left font-bold text-gray-800 mb-2">Rekapan Kehadiran Karyawan</h2>
        <p class="text-xl text-left text-gray-700">Rekapan Rinci Kehadiran karyawan Secara Berkala</p>
    </div>
        <div class="flex flex-col gap-y-4 mt-4 mb-6">
            <form action="/presensi/laporanpribadi" method="POST" target="_blank">
                @csrf
                <!-- Bagian Dropdown -->
                <div class="flex gap-4 items-center">
                    <select name="bulan" id="bulan"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $namabulan[$i] }}</option>
                        @endfor
                    </select>
                    <select name="tahun" id="tahun"
                        class="rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tahun</option>
                        @php
                            $tahunmulai = 2023;
                            $tahunsekarang = date('Y');
                        @endphp
                        @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endfor
                    </select>
                    <select name="karyawan" id="karyawan"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Karyawan</option>
                        @foreach ($karyawan as $d)
                            <option value="{{ $d->id }}">{{ $d->nama_karyawan }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Card untuk Tombol -->
                <div class="flex gap-4 mt-4">
                    <button type="submit" name="action" value="print"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">
                        Print
                    </button>
                </div>

            </form>
        </div>
        
</main>
@endsection
