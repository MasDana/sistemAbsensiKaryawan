@extends('layout/layoutadmin')

@section('konten')


    <!-- Main Content -->
    <main class="flex-grow p-8 ">
        <h2 class="text-3xl font-bold mb-6">Master Data Jabatan</h2>
        <!-- Tombol Tambah Data dan Form Pencarian -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <button id="btntambahjabatan"
                class="text-white bg-blue-700 
                hover:bg-blue-800 focus:ring-4 
                focus:outline-none focus:ring-blue-300 
                font-medium rounded-lg text-sm px-5 py-2.5 mb-4 md:mb-0 md:mr-4">
                Tambah Data
            </button>
            <form action="/rekapjabatan" method="get" class="flex items-center">
                <input type="text" name="nama_jabatan" id="nama_jabatan" placeholder="Nama"
                    value="{{ request('nama_jabatan') }}" class="border border-gray-300 p-2 rounded mr-2" />
                <button type="submit"
                    class="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800 transition">Cari</button>
            </form>
        </div>

        <!-- Tabel Karyawan -->
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
                            <td class="border px-4 py-2">{{ $jabatan->firstItem() + $key }}</td>
                            <td class="border px-4 py-2">{{ $item->nama_jabatan }}</td>
                            <td class="border px-4 py-2 text-center">
                                {{-- Tombol Edit --}}
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
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold">Tambah Data Jabatan</h3>
                <button type="button" class="text-gray-400 hover:bg-gray-200 p-1 rounded" id="closeModal">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 8.586l4.95-4.95a1 1 0 111.415 1.415L11.414 10l4.95 4.95a1 1 0 01-1.415 1.415L10 11.414l-4.95 4.95a1 1 0 01-1.415-1.415L8.586 10 3.636 5.05a1 1 0 111.415-1.415L10 8.586z" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 max-h-96 overflow-y-auto">
                <form action="{{ url('/store/jabatan-data') }}" method="POST" id="form-jabatan">
                    @csrf
                    <!-- Input Nama -->
                    <div class="mb-4">
                        <label for="nama_jabatans" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" id="nama_jabatans" name="nama_jabatans" required
                            class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end p-4 border-t">
                <button type="button" id="closeModalFooter"
                    class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Batal</button>
                <button type="submit" form="form-jabatan" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </div>
    </div>


@section('java')
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
            $('#btntambahjabatan').on('click', function() {
                $('#default-modal').removeClass('hidden');
            });

            $('#closeModal, #closeModalFooter').on('click', function() {
                $('#default-modal').addClass('hidden');
                $('#form-jabatan')[0].reset();
            });

            // Form submit handler
            $("#form-jabatan").submit(function(e) {
                e.preventDefault();

                // Create FormData object
                var formData = new FormData(this);

                // Submit form using AJAX
                $.ajax({
                    type: "POST",
                    url: "/store/jabatan-data",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Show success message if provided
                        if (response.message) {
                            alert(response.message);
                        }

                        // Close modal and reset form
                        $('#default-modal').addClass('hidden');
                        $('#form-jabatan')[0].reset();

                        // Reload page to show new data
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Log error to console for debugging
                        console.error(xhr.responseText);

                        // Show error message
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert("Terjadi kesalahan saat menyimpan data");
                        }
                    }
                });
            });
        });
    </script>
    </body>

    </html>
@endsection
@endsection
