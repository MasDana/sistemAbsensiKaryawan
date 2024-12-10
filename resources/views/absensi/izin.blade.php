@extends('layout/layoutkaryawan')

@section('css')
@endsection

@section('konten')
    <main class="flex-grow p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl text-left font-bold text-gray-800 mb-2">Pengajuan Izin Karyawan</h2>
            <p class="text-xl text-left text-gray-700">Daftar pengajuan izin karyawan yang sedang diproses</p>

        </div>
        <div class="flex justify-start items-center gap-4 mt-4 mb-6">
            <form method="GET" action="/presensi/izin" class="flex items-center gap-4">
                <div class="form-group">
                    <select name="bulan" id="bulan"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option {{ Request('bulan') == $i ? 'selected' : '' }} value="{{ $i }}">
                                {{ $namabulan[$i] }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <select name="tahun" id="tahun"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tahun</option>
                        @php
                            $tahun_awal = 2022;
                            $tahun_sekarang = date('Y');
                            for ($t = $tahun_awal; $t <= $tahun_sekarang; $t++) {
                                echo '<option ' .
                                    (Request('tahun') == $t ? 'selected' : '') .
                                    " value='$t'>$t</option>";
                            }
                        @endphp
                    </select>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cari Data
                </button>
            </form>
        </div>


        <!-- Daftar Izin -->
        <div class="space-y-6 max-h-[600px] overflow-y-auto">
            @foreach ($data_izin as $item)
                @php
                    $status = $item->status == 'i' ? 'Izin' : ($item->status == 's' ? 'Sakit' : 'Not Found');
                @endphp
                <div
                    class="bg-white p-4 flex flex-col md:flex-row items-center space-x-6 hover:bg-gray-200 rounded-xl transition duration-300 max-h-96 overflow-y-auto">
                    <div class="flex-grow">
                        <div class="text-xl font-semibold text-gray-900">
                            <b>{{ date('d-m-Y', strtotime($item->tanggal_izin_dari)) }}
                                ({{ $status }})
                            </b><br>
                            <small class="text-gray-600">{{ date('d-m-Y', strtotime($item->tanggal_izin_dari)) }}
                                s/d
                                {{ date('d-m-Y', strtotime($item->tanggal_izin_sampai)) }}</small>
                            <p class="mt-2 text-gray-900">{{ $item->keterangan }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4 justify-end">
                        @if ($item->status_approved == 0)
                            <span class="bg-blue-500 text-white text-xs px-3 py-1 rounded-full">Waiting</span>
                        @elseif($item->status_approved == 1)
                            <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full">Approved</span>
                        @elseif($item->status_approved == 2)
                            <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full">Rejected</span>
                        @endif
                        <div class="flex items-center space-x-4 justify-end">
                            @if ($item->status == 'i')
                                <!-- Untuk izin -->
                                <a href="{{ url('/izin/edit/' . $item->kode_izin) }}"
                                    class="bg-yellow-400 text-white text-sm px-4 py-2 rounded-lg hover:bg-yellow-500 transition duration-200 ease-in-out flex items-center space-x-2">
                                    <i class="fas fa-edit"></i><span>Edit</span>
                                </a>
                                <form action="{{ url('/izin/delete/' . $item->kode_izin) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data izin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 ease-in-out flex items-center space-x-2">
                                        <i class="fas fa-trash"></i><span>Hapus</span>
                                    </button>
                                </form>
                            @elseif ($item->status == 's')
                                <!-- Untuk sakit -->
                                <a href="{{ url('/sakit/edit/' . $item->kode_izin) }}"
                                    class="bg-yellow-400 text-white text-sm px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200 ease-in-out flex items-center space-x-2">
                                    <i class="fas fa-edit"></i><span>Edit</span>
                                </a>
                                <form action="{{ url('/sakit/delete/' . $item->kode_izin) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data sakit?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 ease-in-out flex items-center space-x-2">
                                        <i class="fas fa-trash"></i><span>Hapus</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div id="confirmationModal"
                    class="fixed inset-0 z-50 hidden bg-gray-800 bg-opacity-50 items-center justify-center">
                    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6">
                        <h2 class="text-lg font-bold text-gray-800">Konfirmasi Penghapusan</h2>
                        <p class="text-sm text-gray-600 my-4">Yakin ingin menghapus data ini?</p>
                        <div class="flex justify-end space-x-2">
                            <button onclick="closeModal()"
                                class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                                Batal
                            </button>
                            <form id="deleteForm" method="POST" action="">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Garis Pemisah -->
                <hr class="border-t-2 border-gray-200 my-4">
            @endforeach
        </div>

        <!-- Tombol Lingkaran di Pojok Kanan Bawah -->
        <div>
            <button id="scrollToTopBtn"
                class="fixed bottom-6 right-6 bg-blue-500 text-white rounded-full w-16 h-16 flex justify-center items-center shadow-lg hover:bg-blue-600 focus:outline-none transition duration-300">
                <i class="fas fa-chevron-up"></i>
            </button>

            <!-- Dropdown Lingkaran di Pojok Kanan Bawah -->
            <div id="dropdownMenu" class="fixed bottom-24 right-8 flex flex-col space-y-2 z-10">
                <!-- Tombol Sakit -->
                <button id="sakitBtn"
                    class="bg-blue-500 text-white rounded-full w-14 h-14 flex justify-center items-center shadow-lg hover:bg-blue-600 focus:outline-none transition duration-300">
                    Sakit
                </button>
                <!-- Tombol Izin -->
                <button id="izinBtn"
                    class="bg-blue-500 text-white rounded-full w-14 h-14 flex justify-center items-center shadow-lg hover:bg-blue-600 focus:outline-none transition duration-300">
                    Izin
                </button>
            </div>

            <!-- Overlay Gelap -->
            <div id="overlay" class="fixed inset-0 bg-gray-950 bg-opacity-50 hidden z-0"></div>
        </div>

    </main>



    <!-- Scroll to Top JavaScript -->
    <script>
        // Mendapatkan tombol, dropdown, dan overlay
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        const dropdownMenu = document.getElementById('dropdownMenu');
        const overlay = document.getElementById('overlay');

        // Toggle dropdown visibility saat tombol lingkaran diklik
        scrollToTopBtn.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
            overlay.classList.toggle('hidden'); // Tampilkan atau sembunyikan overlay
        });

        // Tombol Sakit dan Izin
        const sakitButton = document.getElementById('sakitBtn');
        const izinButton = document.getElementById('izinBtn');

        // Redirect saat tombol sakit diklik
        sakitButton.addEventListener('click', () => {
            window.location.href = '/sakit'; // Redirect ke /sakit
        });

        // Redirect saat tombol izin diklik
        izinButton.addEventListener('click', () => {
            window.location.href = '/izin'; // Redirect ke /izin
        });

        // Menutup overlay dan dropdown jika overlay diklik
        overlay.addEventListener('click', () => {
            dropdownMenu.classList.add('hidden');
            overlay.classList.add('hidden');
        });
    </script>

    <script>
        function openModal(type, id) {
            const modal = document.getElementById('confirmationModal');
            const deleteForm = document.getElementById('deleteForm');
            if (type === 'izin') {
                deleteForm.action = /izin/delete / $ {
                    id
                };
            } else if (type === 'sakit') {
                deleteForm.action = /sakit/delete / $ {
                    id
                };
            }
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('confirmationModal');
            modal.classList.add('hidden');
        }
    </script>

    </html>
@section('java')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
@endsection
