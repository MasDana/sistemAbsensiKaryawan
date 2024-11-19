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

<body>
    <form action="/izin/{{ $dataizin->id }}/update" method="post" id="formizin">
        @csrf

        <div class="container">
            <br><br><br><br><br><br><br>
            <div class="col s12 m10 offset-m1 l6 offset-l3">
                <div class="row">
                    <div class="row">
                        <!-- Start Datepicker -->
                        <div class="input-field">
                            <input type="text" name="tgl_izin_dari" id="start_date" class="datepicker" required
                                value="{{ $dataizin->tanggal_izin_dari }}">
                            <label for="start_date">Start Date</label>
                        </div>
                    </div>

                    <div class="row">
                        <!-- End Datepicker -->
                        <div class="input-field">
                            <input type="text" name="tgl_izin_sampai" id="end_date" class="datepicker" required
                                value="{{ $dataizin->tanggal_izin_sampai }}">
                            <label for="end_date">End Date</label>
                        </div>
                    </div>

                </div>
            </div>
            <input type="hidden" name="status" value="i">

            <div class="mt-4">
                <input type="text" name="jml_hari" id="jml_hari" placeholder="Jumlah Hari" readonly
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <div class="mt-4">
                <textarea name="keterangan" id="keterangan" cols="30" rows="10"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Enter your description">{{ $dataizin->keterangan }}</textarea>
            </div>

            <div class="mt-4">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
            </div>
    </form>

    <script>
        // Inisialisasi Materialize Datepicker untuk Start Date dan End Date
        $(document).ready(function() {
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
            calculateDays();
            // Menghitung jumlah hari saat tanggal mulai atau akhir berubah
            $('#start_date, #end_date').change(function() {
                calculateDays();
            });

            // Validasi form
            $("#formizin").submit(function(event) {
                var startDate = $("#start_date").val();
                var endDate = $("#end_date").val();
                var keterangan = $("#keterangan").val();

                if (startDate === "") {
                    alert("Tanggal mulai harus diisi");
                    return false;
                } else if (endDate === "") {
                    alert("Tanggal akhir harus diisi");
                    return false;
                } else if (keterangan === "") {
                    alert("Keterangan harus diisi");
                    return false;
                } else {
                    alert("Form submitted successfully!");
                }
            });
        });
    </script>
</body>

</html>
