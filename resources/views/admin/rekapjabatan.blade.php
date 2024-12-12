@extends('layout/layoutadmin')

@section('konten')


    <main class="flex-grow p-8 ">
        <h2 class="text-3xl font-bold mb-6">Master Data Jabatan</h2>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <button id="btntambahjabatan"
                class="text-white bg-blue-700 
                hover:bg-blue-800 focus:ring-4 
                focus:outline-none focus:ring-blue-300 
                font-medium rounded-lg text-sm px-5 py-2.5 mb-4 md:mb-0 md:mr-4">
                <b>+</b> Tambah Data Jabatan
            </button>
            <form action="/rekapjabatan" method="get" class="flex items-center">
                <input type="text" name="nama_jabatan" id="nama_jabatan" placeholder="Nama"
                    value="{{ request('nama_jabatan') }}" class="border border-gray-300 p-2 rounded mr-2" />
                <button type="submit"
                    class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Cari</button>
            </form>
        </div>


        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 item-center">No</th>
                        <th class="border px-4 py-2 item-center">Nama Jabatan</th>
                        <th class="border px-4 py-2 item-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jabatan as $key => $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2 text-center">{{ $jabatan->firstItem() + $key }}</td>
                            <td class="border px-4 py-2">{{ $item->nama_jabatan }}</td>
                            <td class="border px-4 py-2 text-center">
                                <button onclick="editJabatan({{ $item->id }}, '{{ $item->nama_jabatan }}')"
                                    class="fa fa-pencil bg-blue-600 text-white px-3 py-1 rounded hover:bg-yellow-600 transition">

                                </button>
                                <button
                                    class="fa fa-trash bg-red-600 text-white px-3 py-1 rounded hover:bg-red-600 transition"
                                    onclick="confirmDeleteJabatan({{ $item->id }})">
                                    <!-- Mengubah hapusJabatan menjadi confirmDeleteJabatan -->

                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation" class="mt-4">
            <ul class="inline-flex -space-x-px text-sm">
                <li>
                    <a href="{{ $jabatan->previousPageUrl() }}"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700"
                        {{ $jabatan->onFirstPage() ? 'disabled' : '' }}>Previous</a>
                </li>
                @foreach ($jabatan->getUrlRange(1, $jabatan->lastPage()) as $page => $url)
                    <li>
                        <a href="{{ $url }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight 
                    {{ $jabatan->currentPage() == $page ? 'text-blue-600 bg-blue-50' : 'text-gray-500 bg-white' }}
                    border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach
                <li>
                    <a href="{{ $jabatan->nextPageUrl() }}"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700"
                        {{ $jabatan->hasMorePages() ? '' : 'disabled' }}>Next</a>
                </li>
            </ul>
        </nav>
    </main>

    <!-- Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full h-auto overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Tambah Data Jabatan</h3>
                <button type="button" class="text-gray-400 hover:bg-gray-200 p-1 rounded" id="closeModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 8.586l4.95-4.95a1 1 0 111.415 1.415L11.414 10l4.95 4.95a1 1 0 01-1.415 1.415L10 11.414l-4.95 4.95a1 1 0 01-1.415-1.415L8.586 10 3.636 5.05a1 1 0 111.415-1.415L10 8.586z" />
                    </svg>
                </button>
            </div>

            <div class="p-4 max-h-96 overflow-y-auto">
                <form action="{{ url('/store/jabatan-data') }}" method="POST" id="form-jabatan">
                    @csrf

                    <div class="mb-4">
                        <label for="nama_jabatans" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama_jabatans" name="nama_jabatans" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                </form>
            </div>

            <div class="flex justify-end p-4 border-t">
                <button type="button" id="closeModalFooter"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit" form="form-jabatan" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </div>
    </div>

    {{-- EDIT DATA --}}


    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full h-auto overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Edit Data Jabatan</h3>
                <button type="button" class="text-gray-400 hover:bg-gray-200 p-1 rounded" id="closeEditModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 8.586l4.95-4.95a1 1 0 111.415 1.415L11.414 10l4.95 4.95a1 1 0 01-1.415 1.415L10 11.414l-4.95 4.95a1 1 0 01-1.415-1.415L8.586 10 3.636 5.05a1 1 0 111.415-1.415L10 8.586z" />
                    </svg>
                </button>
            </div>

            <div class="p-4 max-h-96 overflow-y-auto">
                <form id="form-edit-jabatan" action="/update/jabatan/{id}" method="POST">
                    @csrf
                    @method('PUT') <!-- Gunakan PUT untuk update data -->
                    <input type="hidden" id="jabatan_id" name="jabatan_id">
                    <div class="mb-4">
                        <label for="edit_nama_jabatans" class="block text-sm font-medium text-gray-700">Nama Jabatan</label>
                        <input type="text" id="edit_nama_jabatans" name="nama_jabatans" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                </form>

            </div>

            <div class="flex justify-end p-4 border-t">
                <button type="button" id="closeEditModalFooter"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit" form="form-edit-jabatan"
                    class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </div>
    </div>


@section('java')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Setup CSRF token untuk semua permintaan AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Modal handlers
            $('#btntambahjabatan').on('click', function() {
                $('#default-modal').removeClass('hidden');
            });

            $('#closeModal, #closeModalFooter').on('click', function() {
                $('#default-modal').addClass('hidden');
                $('#form-jabatan')[0].reset();
            });

            // Form submit handler untuk tambah jabatan
            $("#form-jabatan").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "/store/jabatan-data",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data jabatan berhasil disimpan.',
                        }).then(() => {
                            $('#default-modal').addClass('hidden');
                            $('#form-jabatan')[0].reset();
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat menyimpan data.',
                        });
                    }
                });
            });
        });

        $(document).ready(function() {
            // Fungsi untuk membuka modal edit
            window.editJabatan = function(id, namaJabatan) {
                $('#edit-modal').removeClass('hidden'); // Tampilkan modal edit
                $('#form-edit-jabatan').attr('action', `/update/jabatan/${id}`); // Update action
                $('#edit_nama_jabatans').val(namaJabatan); // Isi nama jabatan
            };

            // Tutup modal edit saat tombol "x" atau "Batal" diklik
            $('#closeEditModal, #closeEditModalFooter').on('click', function() {
                $('#edit-modal').addClass('hidden'); // Tutup modal edit
                $('#form-edit-jabatan')[0].reset(); // Reset form edit
            });

            // Form submit handler untuk edit jabatan
            $("#form-edit-jabatan").submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: $(this).attr('action'),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data jabatan berhasil diupdate.',
                        }).then(() => {
                            $('#edit-modal').addClass('hidden');
                            $('#form-edit-jabatan')[0].reset();
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat mengupdate data.',
                        });
                    }
                });
            });
        });




        function confirmDeleteJabatan(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus jabatan ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteJabatan(id);
                }
            });
        }

        function deleteJabatan(id) {
            $.ajax({
                type: "DELETE",
                url: `/jabatan/${id}`, // Gantilah URL ini dengan rute API untuk hapus jabatan
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token untuk keamanan
                },
                success: function(response) {
                    Swal.fire(
                        'Berhasil!',
                        'Jabatan berhasil dihapus.',
                        'success'
                    ).then(() => {
                        // Refresh halaman untuk menampilkan perubahan
                        window.location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus jabatan.',
                        'error'
                    );
                }
            });
        }
    </script>
    </body>

    </html>
@endsection
@endsection
