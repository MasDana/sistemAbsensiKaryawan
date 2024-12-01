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
        style="background-image: url('{{ asset('gambar/bgloginblur.jpg') }}');">

        <form action="/izin/store" method="post" id="formizin">
            @csrf

            <div class="container mx-auto py-16">
                <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto"
                    style="max-height: 450px; overflow-y: auto;">
                    <h2 class="text-xl font-semibold mb-4 text-center">Form Izin</h2>


                    <!-- Start Datepicker -->
                    <div class="mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="text" name="tgl_izin_dari" id="start_date"
                            class="datepicker mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>

                    <!-- End Datepicker -->
                    <div class="mb-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="text" name="tgl_izin_sampai" id="end_date"
                            class="datepicker mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Hidden Input for Status -->
                    <input type="hidden" name="status" value="i">

                    <!-- Jumlah Hari -->
                    <div class="mb-4">
                        <label for="jml_hari" class="block text-sm font-medium text-gray-700">Jumlah Hari</label>
                        <input type="text" name="jml_hari" id="jml_hari" readonly
                            class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Keterangan -->
                    <div class="mb-4">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Enter your description"></textarea>
                    </div>
                    <!-- Button Group -->
                    <div class="text-center">
                        <!-- Submit Button -->
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md mr-4">
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
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Inisialisasi Materialize Datepicker untuk Start Date dan End Date
        $(document).ready(function() {

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

            // Initialize the start date and end date datepickers
            $('#start_date').datepicker({
                format: 'yyyy-mm-dd', // Format yang diinginkan
                autoClose: true, // Menutup datepicker setelah memilih tanggal
                yearRange: [1920, new Date().getFullYear()] // Rentang tahun
            });

            $('#end_date').datepicker({
                format: 'yyyy-mm-dd', // Format yang diinginkan
                autoClose: true, // Menutup datepicker setelah memilih tanggal
                yearRange: [1920, new Date().getFullYear()] // Rentang tahun
            });

            // Fungsi untuk menghitung jumlah hari izin
            function calculateDays() {
                var startDate = $('#start_date').val();
                var endDate = $('#end_date').val();
                if (startDate && endDate) {
                    var start = new Date(startDate);
                    var end = new Date(endDate);
                    var timeDifference = end - start;
                    var daysDifference = timeDifference / (1000 * 3600 * 24); // Konversi dari milidetik ke hari
                    if (daysDifference < 0) {
                        alert("Tanggal akhir tidak boleh lebih kecil dari tanggal mulai.");
                        $('#jml_hari').val('');
                    } else {
                        $('#jml_hari').val(daysDifference + 1); // Menambahkan 1 agar inklusif
                    }
                }
            }

            // Menghitung jumlah hari saat tanggal mulai atau akhir berubah
            $('#start_date, #end_date').change(function() {
                calculateDays();
            });

            // Validasi form
            $("#formizin").submit(function(event) {
                event.preventDefault(); // Mencegah pengiriman form default

                let formData = $(this).serialize();

                $.ajax({
                    url: '/izin/store',
                    type: 'POST',
                    data: formData,
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
                        if (xhr.status === 400) {
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
