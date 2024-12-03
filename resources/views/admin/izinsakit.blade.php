@extends('layout/layoutadmin')

@section('konten')
    <!-- Main Content -->
    <main class="flex-grow p-8 ">
        <h2 class="text-3xl font-bold mb-6">Master Data Karyawan</h2>
        <form action="/presensi/izinsakit" method="get" autocomplete="off">
            <div>
                <div>
                    <input type="date" name="start" id="start" placeholder="Start" value="{{ Request('start') }}">
                </div>

                <div>
                    <input type="date" name="end" id="end" placeholder="End" value="{{ Request('start') }}">
                </div>
            </div>

            <input type="text" name="nama_karyawan" id="nama_karyawan" placeholder="Nama"
                value="{{ Request::get('nama_karyawan') }}">
            <select name="status_approved" id="status_approved">
                <option value="">Pilih Status</option>
                <option value="0" {{ Request::get('status_approved') === '0' ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ Request::get('status_approved') == 1 ? 'selected' : '' }}>Disetujui</option>
                <option value="2" {{ Request::get('status_approved') == 2 ? 'selected' : '' }}>Ditolak</option>
            </select>

            <button type="submit">Cari data</button>
        </form>
        <br>
        <!-- Tabel Karyawan -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 text-left">No</th>
                        <th class="border px-4 py-2 text-left">Nama</th>
                        <th class="border px-4 py-2 text-left">Dari</th>
                        <th class="border px-4 py-2 text-left">Sampai</th>
                        <th class="border px-4 py-2 text-left">Jenis</th>
                        <th class="border px-4 py-2 text-left">Keterangan</th>
                        <th class="border px-4 py-2 text-left">Foto</th>
                        <th class="border px-4 py-2 text-left">Status</th>
                        <th class="border px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($izinsakit as $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $item->nama_karyawan }}</td>
                            <td class="border px-4 py-2">{{ date('d-m-Y', strtotime($item->tanggal_izin_dari)) }}</td>
                            <td class="border px-4 py-2">{{ date('d-m-Y', strtotime($item->tanggal_izin_sampai)) }}</td>
                            <td class="border px-4 py-2">{{ $item->status == 'i' ? 'Izin' : 'Sakit' }}</td>
                            <td class="border px-4 py-2">{{ $item->keterangan }}</td>
                            <td class="border px-4 py-2">
                                @if ($item->doc_sid == null)
                                    <span>-</span>
                                @else
                                    {{ $item->doc_sid }}
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                @if ($item->status_approved == 1)
                                    <span>Disetujui</span>
                                @elseif($item->status_approved == 2)
                                    <span>Ditolak</span>
                                @else
                                    <span>Pending</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2 text-center">
                                @if ($item->status_approved == 0)
                                    <button data-modal-target="modal-izinsakit" data-modal-toggle="modal-izinsakit"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
                                        id_izinsakit="{{ $item->id }}">
                                        Aksi
                                    </button>
                                @else
                                    <button class="bg-red-500 text-white px-3 py-1 rounded"><a
                                            href="/presensi/{{ $item->id }}/batalkanizinsakit">Batalkan</a></button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="inline-flex -space-x-px text-sm">
                {{-- Tombol Previous --}}
                <li>
                    <a href="{{ $izinsakit->previousPageUrl() }}"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 
                    border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        {{ $izinsakit->onFirstPage() ? 'disabled' : '' }}>Previous</a>
                </li>

                {{-- Halaman Pagination --}}
                @foreach ($izinsakit->getUrlRange(1, $izinsakit->lastPage()) as $page => $url)
                    <li>
                        <a href="{{ $url }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight 
                    {{ $izinsakit->currentPage() == $page ? 'text-blue-600 bg-blue-50' : 'text-gray-500 bg-white' }}
                    border border-gray-300 hover:bg-gray-100 hover:text-gray-700 
                    dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- Tombol Next --}}
                <li>
                    <a href="{{ $izinsakit->nextPageUrl() }}"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg 
                    hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        {{ $izinsakit->hasMorePages() ? '' : 'disabled' }}>Next</a>
                </li>
            </ul>
        </nav>
        <!-- Modal -->
        <div id="modal-izinsakit" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-medium text-gray-900 dark:text-white">
                            Izin/Sakit
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="modal-izinsakit">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">
                        <form action="/presensi/approveizinsakit" method="post">
                            @csrf
                            <div class="space-y-4">
                                <input type="text" hidden id="id_izinsakit_form" name="id_izinsakit_form">
                                <select name="status_approved" id="status_approved"
                                    class="block w-full px-4 py-2 bg-white border rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                    <option value="1">Disetujui</option>
                                    <option value="2">Ditolak</option>
                                </select>
                            </div>
                            <div
                                class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button data-modal-hide="modal-izinsakit" type="button"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-600 dark:hover:text-white">Batal</button>
                                <button type="submit"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                    <!-- Modal footer -->

                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- Bagian 2: Logika Modal ----
            const approveButtons = document.querySelectorAll('[data-modal-target="modal-izinsakit"]');
            const modal = document.getElementById('modal-izinsakit');

            approveButtons.forEach((button) => {
                button.addEventListener('click', function() {
                    // Ambil nilai id_izinsakit dari tombol yang diklik
                    const idIzinSakit = this.getAttribute('id_izinsakit');
                    if (idIzinSakit) {
                        document.getElementById('id_izinsakit_form').value =
                            idIzinSakit; // Set nilai ke form modal
                        modal.classList.remove('hidden'); // Tampilkan modal
                    }
                });
            });

            // Event listener untuk menutup modal
            document.querySelectorAll('[data-modal-hide="modal-izinsakit"]').forEach((closeButton) => {
                closeButton.addEventListener('click', function() {
                    modal.classList.add('hidden'); // Sembunyikan modal
                });
            });
        });
    </script>
@endsection
