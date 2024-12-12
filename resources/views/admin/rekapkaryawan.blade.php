@extends('layout/layoutadmin')

@section('konten')
    <!-- Main Content -->
    <main class="flex-grow p-8 ">
        <h2 class="text-3xl font-bold mb-6">Master Data Karyawan</h2>
        <!-- Tombol Tambah Data dan Form Pencarian -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <button id="btntambahkaryawan"
                class=" text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-4 md:mb-0 md:mr-4">
                <b>+</b> Tambah Data Karyawan
            </button>
            <form action="/rekapkaryawan" method="get" class="flex items-center">
                <input type="text" name="nama_karyawan" id="nama_karyawan" placeholder="Nama"
                    value="{{ request('nama_karyawan') }}" class="border border-gray-300 p-2 rounded mr-2" />
                <button type="submit"
                    class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Cari</button>
            </form>
        </div>

        <!-- Tabel Karyawan -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full bg-white border rounded-lg">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border px-4 py-2 text-left">No</th>
                        <th class="border px-4 py-2 text-left">Nama</th>
                        <th class="border px-4 py-2 text-left">Jabatan</th>
                        <th class="border px-4 py-2 text-left">Email</th>
                        <th class="border px-4 py-2 text-left">No Hp</th>
                        <th class="border px-4 py-2 text-left">Gender</th>
                        <th class="border px-4 py-2 text-left">Alamat</th>
                        <th class="border px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($karyawan as $key => $item)
                        <tr class="hover:bg-gray-100">
                            <td class="border px-4 py-2">{{ $karyawan->firstItem() + $key }}</td>
                            <td class="border px-4 py-2">{{ $item->nama_karyawan }}</td>
                            <td class="border px-4 py-2">{{ $item->nama_jabatan }}</td>
                            <td class="border px-4 py-2">{{ $item->email }}</td>
                            <td class="border px-4 py-2">{{ $item->no_hp }}</td>
                            <td class="border px-4 py-2">
                                @if ($item->gender == 'male')
                                    <p>Male</p>
                                @else
                                    <p>Female</p>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $item->alamat }}</td>
                            <td class="border px-4 py-2 text-center">
                                <!-- Tombol Edit -->
                                <button
                                    class="fa fa-pencil-alt btn-edit bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
                                    data-id="{{ $item->id }}">
                                </button>

                                <!-- Tombol Hapus -->
                                <button
                                    class="fa fa-trash bg-red-600 text-white px-3 py-1 rounded hover:bg-red-600 transition"
                                    onclick="confirmDelete({{ $item->id }})">
                                </button>
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
                    <a href="{{ $karyawan->previousPageUrl() }}"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 
                    border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        {{ $karyawan->onFirstPage() ? 'disabled' : '' }}>Previous</a>
                </li>

                {{-- Halaman Pagination --}}
                @foreach ($karyawan->getUrlRange(1, $karyawan->lastPage()) as $page => $url)
                    <li>
                        <a href="{{ $url }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight 
                    {{ $karyawan->currentPage() == $page ? 'text-blue-600 bg-blue-50' : 'text-gray-500 bg-white' }}
                    border border-gray-300 hover:bg-gray-100 hover:text-gray-700 
                    dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ $page }}
                        </a>
                    </li>
                @endforeach

                {{-- Tombol Next --}}
                <li>
                    <a href="{{ $karyawan->nextPageUrl() }}"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg 
                    hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                        {{ $karyawan->hasMorePages() ? '' : 'disabled' }}>Next</a>
                </li>
            </ul>
        </nav>
    </main>
    <!-- Modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full h-auto overflow-hidden">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Tambah Data Karyawan</h3>
                <button type="button" class="text-gray-400 hover:bg-gray-200 p-1 rounded" id="closeModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 8.586l4.95-4.95a1 1 0 111.415 1.415L11.414 10l4.95 4.95a1 1 0 01-1.415 1.415L10 11.414l-4.95 4.95a1 1 0 01-1.415-1.415L8.586 10 3.636 5.05a1 1 0 111.415-1.415L10 8.586z" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 max-h-96 overflow-y-auto"> <!-- Set max height and enable scrolling -->
                <form action="{{ url('/store/karyawan-data') }}" method="POST" id="form-karyawan">
                    @csrf
                    <!-- Input Nama -->
                    <div class="mb-4">
                        <label for="nama_karyawans" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama_karyawans" name="nama_karyawans" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Dropdown Jabatan -->
                    <div class="mb-4">
                        <label for="jabatan_id" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <select id="jabatan_id" name="jabatan_id" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Input No HP -->
                    <div class="mb-4">
                        <label for="no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
                        <input type="tel" id="no_hp" name="no_hp" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Input Tanggal Lahir -->
                    <div class="mb-4">
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Radio Button Gender -->
                    <div class="mb-4">
                        <h3 class="text-gray-700">Gender</h3>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" id="male" name="gender" value="male" class="form-radio"
                                    checked>
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" id="female" name="gender" value="female" class="form-radio">
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Input Alamat -->
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
                    </div>

                    <!-- Input Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end p-4 border-t">
                <button type="button" id="closeModalFooter"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit" form="form-karyawan"
                    class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </div>
    </div>


    {{-- EDIT KARYAWAN --}}

    <!-- Modal Edit -->
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full h-auto overflow-hidden">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Edit Data Karyawan</h3>
                <button type="button" class="text-gray-400 hover:bg-gray-200 p-1 rounded" id="closeEditModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 8.586l4.95-4.95a1 1 0 111.415 1.415L11.414 10l4.95 4.95a1 1 0 01-1.415 1.415L10 11.414l-4.95 4.95a1 1 0 01-1.415-1.415L8.586 10 3.636 5.05a1 1 0 111.415-1.415L10 8.586z" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 max-h-96 overflow-y-auto">
                <form action="{{ url('/update/karyawan-data') }}" method="POST" id="edit-form-karyawan">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">

                    <!-- Input Nama -->
                    <div class="mb-4">
                        <label for="edit_nama_karyawans" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="edit_nama_karyawans" name="nama_karyawans" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Dropdown Jabatan -->
                    <div class="mb-4">
                        <label for="edit_jabatan_id" class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <select id="edit_jabatan_id" name="jabatan_id" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Pilih Jabatan</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Input Email -->
                    <div class="mb-4">
                        <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="edit_email" name="email" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Input No HP -->
                    <div class="mb-4">
                        <label for="edit_no_hp" class="block text-sm font-medium text-gray-700">No HP</label>
                        <input type="tel" id="edit_no_hp" name="no_hp" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>

                    <!-- Radio Button Gender -->
                    <div class="mb-4">
                        <h3 class="text-gray-700">Gender</h3>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" id="edit_male" name="gender" value="male" class="form-radio">
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" id="edit_female" name="gender" value="female"
                                    class="form-radio">
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <!-- Input Alamat -->
                    <div class="mb-4">
                        <label for="edit_alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="edit_alamat" name="alamat" rows="3" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md"></textarea>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end p-4 border-t">
                <button type="button" id="closeEditModalFooter"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit" form="edit-form-karyawan"
                    class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </div>
    </div>


@section('java')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Modal handlers
            $('#btntambahkaryawan').on('click', function() {
                $('#default-modal').removeClass('hidden');
            });

            $('#closeModal, #closeModalFooter').on('click', function() {
                $('#default-modal').addClass('hidden');
                $('#form-karyawan')[0].reset();
            });

            // Form submit handler
            $("#form-karyawan").submit(function(e) {
                e.preventDefault();

                // Create FormData object
                var formData = new FormData(this);

                // Submit form using AJAX
                $.ajax({
                    type: "POST",
                    url: "/store/karyawan-data",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data berhasil disimpan.',
                        }).then(() => {
                            // Close modal and reset form
                            $('#default-modal').addClass('hidden');
                            $('#form-karyawan')[0].reset();

                            // Reload page to show new data
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
            // Open edit modal and populate fields
            $('.btn-edit').on('click', function() {
                var id = $(this).data('id');

                // Fetch data via AJAX
                $.ajax({
                    url: `/karyawan/${id}/edit`,
                    type: 'GET',
                    success: function(response) {
                        // Populate the modal with response data
                        $('#edit_id').val(response.id);
                        $('#edit_nama_karyawans').val(response.nama_karyawan);
                        $('#edit_jabatan_id').val(response.jabatan_id);
                        $('#edit_email').val(response.email);
                        $('#edit_no_hp').val(response.no_hp);
                        $('#edit_alamat').val(response.alamat);

                        if (response.gender === 'male') {
                            $('#edit_male').prop('checked', true);
                        } else {
                            $('#edit_female').prop('checked', true);
                        }

                        // Show modal
                        $('#edit-modal').removeClass('hidden');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memuat data karyawan!',
                        });
                    }
                });
            });

            // Close modal
            $('#closeEditModal, #closeEditModalFooter').on('click', function() {
                $('#edit-modal').addClass('hidden');
                $('#edit-form-karyawan')[0].reset();
            });

            // Handle form submission for editing data
            $('#edit-form-karyawan').on('submit', function(e) {
                e.preventDefault();

                // Gather form data
                var formData = $(this).serialize();

                // Submit form via AJAX
                $.ajax({
                    url: `/update/karyawan-data`,
                    type: 'PUT',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'Data berhasil diperbarui.',
                        }).then(() => {
                            // Close modal and reset form
                            $('#edit-modal').addClass('hidden');
                            $('#edit-form-karyawan')[0].reset();

                            // Reload page to show updated data
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message ||
                                'Terjadi kesalahan saat memperbarui data.',
                        });
                    }
                });
            });
        });


        function confirmDelete(id) {
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: "Apakah Anda yakin ingin menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteKaryawan(id);
                }
            });
        }

        function deleteKaryawan(id) {
            $.ajax({
                type: "DELETE",
                url: `/karyawan/${id}`, // Rute API untuk hapus data
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'Data berhasil dihapus.',
                    }).then(() => {
                        // Refresh halaman untuk menampilkan perubahan
                        window.location.reload();
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: xhr.responseJSON?.message || 'Terjadi kesalahan saat menghapus data.',
                    });
                }
            });
        }
    </script>
@endsection
@endsection
