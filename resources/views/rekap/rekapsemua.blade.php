@extends('layout/layoutadmin')

@section('konten')
    <main class="flex-grow p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl text-left font-bold text-gray-800 mb-2">Rekap Kehadiran Keseluruhan Karyawan</h2>
            <p class="text-xl text-left text-gray-700">Rekapan Keseluruhan Kehadiran Karyawan Secara Berkala</p>
        </div>
        <div class="flex flex-col gap-y-4 mt-4 mb-6">
            <form action="/presensi/laporansemua" method="POST" target="_blank" id="formLaporan">
                @csrf
                <div class="flex gap-4 items-center">
                    <select name="bulan" id="bulan" placeholder="bulan"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $namabulan[$i] }}</option>
                        @endfor
                    </select>
                    <select name="tahun" id="tahun"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Pilih Tahun</option>
                        @php
                            $tahunmulai = 2023;
                            $tahunsekarang = date('Y');
                        @endphp
                        @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                            <option value="{{ $tahun }}">{{ $tahun }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex gap-4 mt-4">
                    <!-- Tambahkan atribut name untuk tombol print -->
                    <button type="submit" name="action" value="print"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none">Print</button>
                </div>
            </form>
        </div>
        </div>


        <script>
            // Tangkap form berdasarkan ID
            const formLaporan = document.getElementById('formLaporan');

            formLaporan.addEventListener('submit', function(event) {
                // Tangkap nilai dari dropdown
                const bulan = document.getElementById('bulan').value;
                const tahun = document.getElementById('tahun').value;

                // Periksa apakah semua field sudah dipilih
                if (!bulan || !tahun) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Harap pilih semua field (bulan dan tahun) sebelum melanjutkan.',
                    });
                    event.preventDefault();
                }
            });
        </script>
    @endsection
