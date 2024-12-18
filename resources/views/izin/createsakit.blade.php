<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>Date Range Picker</title>
</head>

<body class="bg-gray-100 min-h-screen overflow-hidden">
    <section class="w-screen h-screen bg-cover bg-center bg-no-repeat"
        style="background: linear-gradient(to right, #800080, #0000FF); width: 100vw; height: 100vh; background-size: cover; background-position: center; background-repeat: no-repeat;">

        <form action="/sakit/store" method="post" id="formizin" enctype="multipart/form-data">
            @csrf

            <div class="container mx-auto py-16">
                <div class="bg-white shadow-lg rounded-lg p-6 max-w-8xl mx-auto"
                    style="max-height: 700px; overflow-y: auto;">
                    <h2 class="text-2xl font-bold mb-4 text-center">Form Izin Sakit</h2>

                    <!-- Start Datepicker -->
                    <div class="mb-4">
                        <label for="start_date" class="block text-lg font-semibold text-black">Tanggal Mulai</label>
                        <input type="text" name="tgl_izin_dari" id="start_date"
                            class="datepicker mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>

                    <!-- End Datepicker -->
                    <div class="mb-4">
                        <label for="end_date" class="block text-lg font-semibold text-black">Tanggal Selesai</label>
                        <input type="text" name="tgl_izin_sampai" id="end_date"
                            class="datepicker mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Hidden Input for Status -->
                    <input type="hidden" name="status" value="i">

                    <!-- Jumlah Hari -->
                    <div class="mb-4">
                        <label for="jml_hari" class="block text-lg font-semibold text-black">Jumlah Hari</label>
                        <input type="text" name="jml_hari" id="jml_hari" readonly
                            class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="block text-lg font-semibold text-black mb-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Enter your description" required></textarea>
                    </div>
                    <!-- File Upload -->
                    <div class="mb-4">
                        <label for="file_input" class="block text-lg font-semibold text-black mb-2">Upload File
                            Bukti</label>
                        <div class="flex items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                            onclick="document.getElementById('file_input').click();">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                                        class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX.
                                    800x400px)</p>
                            </div>
                            <input type="file" id="file_input" name="file_input" class="hidden" accept="image/*"
                                required onchange="previewFile()" />
                        </div>
                        <div id="file_preview" class="mt-4 hidden">
                            <img id="preview_img" src="#" alt="Preview" class="max-w-full h-auto" />
                        </div>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Allowed file
                            types: SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center mt-4">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md">
                            Submit
                        </button>
                        <!-- Cancel Button -->
                        <button type="button"
                            class="bg-red-500 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-md"
                            onclick="window.history.back();">
                            Batal
                        </button>
                    </div>
                </div>
            </div>


        </form>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            $(document).ready(function() {
                // Inisialisasi Materialize Datepicker
                $('.datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoClose: true,
                    yearRange: [1920, new Date().getFullYear()]
                });

                $('#start_date').change(function(e) {
                    var tanggal_izin_dari = $(this).val();
                    $.ajax({
                        type: 'post',
                        url: '/presensi/cekpengajuanizin',
                        data: {
                            _token: "{{ csrf_token() }}",
                            tanggal_izin_dari: tanggal_izin_dari
                        },
                        cache: false,
                        success: function(respond) {
                            if (respond == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: 'Tanggal Sudah Digunakan',
                                }).then((result) => {
                                    $("#start_date").val("");
                                });
                            }
                        }
                    });
                });

                // Fungsi untuk menghitung jumlah hari izin
                function calculateDays() {
                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();
                    if (startDate && endDate) {
                        var start = new Date(startDate);
                        var end = new Date(endDate);
                        var timeDifference = end - start;
                        var daysDifference = timeDifference / (1000 * 3600 * 24);
                        if (daysDifference < 0) {
                            M.toast({
                                html: 'Tanggal akhir tidak boleh lebih kecil dari tanggal mulai',
                                classes: 'red'
                            });
                            $('#jml_hari').val('');
                            return false;
                        } else {
                            $('#jml_hari').val(daysDifference + 1);
                            return true;
                        }
                    }
                    return false;
                }

                // Event listener untuk perubahan tanggal
                $('#start_date, #end_date').change(calculateDays);

                // Preview gambar yang diupload
                $('#file_input').change(function() {
                    const file = this.files[0];
                    const fileType = file.type;
                    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];

                    if (!validImageTypes.includes(fileType)) {
                        M.toast({
                            html: 'File harus berupa gambar (SVG, PNG, JPG, atau GIF)',
                            classes: 'red'
                        });
                        this.value = '';
                        $('#file_preview').addClass('hidden');
                        return;
                    }

                    if (file.size > 2 * 1024 * 1024) { // 2MB limit
                        M.toast({
                            html: 'Ukuran file tidak boleh lebih dari 2MB',
                            classes: 'red'
                        });
                        this.value = '';
                        $('#file_preview').addClass('hidden');
                        return;
                    }

                    // Preview gambar
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            $('#preview_img').attr('src', e.target.result);
                            $('#file_preview').removeClass('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });

                // Validasi form sebelum submit
                $("#formizin").submit(function(event) {
                    event.preventDefault(); // Cegah submit default

                    // Validasi tanggal
                    if (!calculateDays()) {
                        M.toast({
                            html: 'Harap periksa tanggal kembali',
                            classes: 'red'
                        });
                        return false;
                    }

                    // Validasi file input
                    const fileInput = $('#file_input')[0];
                    if (!fileInput.files || fileInput.files.length === 0) {
                        M.toast({
                            html: 'Harap pilih file untuk diupload',
                            classes: 'red'
                        });
                        return false;
                    }

                    // Validasi keterangan
                    if ($('#keterangan').val().trim() === '') {
                        M.toast({
                            html: 'Keterangan harus diisi',
                            classes: 'red'
                        });
                        return false;
                    }

                    // Jika validasi berhasil, kirim form dengan AJAX
                    const formData = new FormData(this); // Ambil data form

                    $.ajax({
                        url: '/sakit/store', // URL untuk proses penyimpanan
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                            }).then(() => {
                                window.location.reload(); // Reload halaman
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 500) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON.message,
                                });
                            } else {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan, coba lagi nanti.',
                                });
                            }
                        }
                    });
                });

            });
        </script>
</body>

</html>
