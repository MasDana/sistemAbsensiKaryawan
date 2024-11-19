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
    <form action="/sakit/{{ $datasakit->id }}/update" method="post" id="formizin" enctype="multipart/form-data">
        @csrf

        <div class="container">
            <br><br><br><br><br><br><br>
            <div class="col s12 m10 offset-m1 l6 offset-l3">
                <div class="row">
                    <div class="row">
                        <div class="input-field">
                            <input type="text" name="tgl_izin_dari" id="start_date" class="datepicker" required
                                value="{{ $datasakit->tanggal_izin_sampai }}">
                            <label for="start_date">Start Date</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field">
                            <input type="text" name="tgl_izin_sampai" id="end_date" class="datepicker" required
                                value="{{ $datasakit->tanggal_izin_sampai }}">
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
                    placeholder="Enter your description">{{ $datasakit->keterangan }}</textarea>
                <br>
                @if ($datasakit->doc_sid != null)
                    <div>
                        @php
                            $docsid = Storage::url('/uploads/sid/' . $datasakit->doc_sid);
                        @endphp
                        <img src="{{ url($docsid) }}" alt="" width="100px">
                    </div>
                @endif
                <div class="flex items-center justify-center w-full">
                    <label for="file_input"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                    to
                                    upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)
                            </p>
                        </div>
                        <input type="file" id="file_input" name="file_input" class="hidden" accept="image/*"
                            required />
                    </label>
                </div>
                <div id="file_preview" class="mt-4 hidden">
                    <img id="preview_img" src="#" alt="Preview" class="max-w-full h-auto" />
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">Allowed file types: SVG,
                    PNG,
                    JPG or GIF (MAX. 800x400px).</p>

                <div class="mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                </div>
            </div>
    </form>

    <script>
        $(document).ready(function() {
            // Inisialisasi Materialize Datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoClose: true,
                yearRange: [1920, new Date().getFullYear()]
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
            calculateDays();
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
                event.preventDefault();

                if (!calculateDays()) {
                    M.toast({
                        html: 'Harap periksa tanggal kembali',
                        classes: 'red'
                    });
                    return false;
                }

                const fileInput = $('#file_input')[0];
                if (!fileInput.files || fileInput.files.length === 0) {
                    M.toast({
                        html: 'Harap pilih file untuk diupload',
                        classes: 'red'
                    });
                    return false;
                }

                if ($('#keterangan').val().trim() === '') {
                    M.toast({
                        html: 'Keterangan harus diisi',
                        classes: 'red'
                    });
                    return false;
                }

                M.toast({
                    html: 'Form berhasil disubmit!',
                    classes: 'green'
                });
                this.submit();
            });
        });
    </script>
</body>

</html>
