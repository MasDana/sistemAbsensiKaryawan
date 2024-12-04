@extends('layout/layoutadmin')

@section('konten')
    <!-- Konten Utama -->
    <div class="flex-grow flex flex-col">
        <main class="main-dashboard transition-all p-8">
            <!-- Judul -->
            <h2 class="text-3xl font-bold mb-6">Monitoring Presensi</h2>

            <div class="relative mb-6">
                <input id="tanggal"
                    class="peer h-full w-full rounded-lg border border-gray-300 px-4 py-2.5 bg-white text-sm text-gray-700 placeholder-gray-400 transition-all focus:border-indigo-600 focus:outline-none"
                    placeholder="" />
                <label for="tanggal"
                    class="absolute left-3 -top-2.5 bg-white px-1 text-xs text-gray-500 transition-all peer-placeholder-shown:top-2 peer-placeholder-shown:left-4 peer-placeholder-shown:text-sm peer-placeholder-shown:text-gray-400 peer-focus:-top-2.5 peer-focus:left-3 peer-focus:text-xs peer-focus:text-indigo-600 rounded-lg">
                    Pilih Rentang Tanggal
                </label>
            </div>


            <!-- Tabel -->
            <table class="min-w-full border-collapse border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                <thead>
                    <tr class="bg-indigo-600 text-white ">
                        <th class="border border-gray-300 px-4 py-2 text-center">No.</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Nama</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Jam Masuk</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Jam Keluar</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Keterangan</th>
                        <!-- <th class="border border-gray-300 px-4 py-2 text-center">Posisi</th> -->
                    </tr>
                </thead>
                <tbody id="loadpresensi" class="border text-center"></tbody>
            </table>
        </main>

    </div>
@section('java')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
<script>
    // Inisialisasi datepicker dengan mode range
    const datepicker = flatpickr("#tanggal", {
        mode: "range", // Aktifkan pemilihan rentang tanggal
        dateFormat: "Y-m-d", // Format yang dikirimkan dalam format 'YYYY-MM-DD'
        onChange: function(selectedDates) {
            // Pastikan ada dua tanggal yang dipilih
            if (selectedDates.length === 2) {
                const startDate = selectedDates[0].toLocaleDateString('en-CA'); // Format YYYY-MM-DD
                const endDate = selectedDates[1].toLocaleDateString('en-CA');
                // Kirim permintaan AJAX setelah kedua tanggal dipilih
                if (startDate === endDate) {
                    $.ajax({
                        type: 'POST',
                        url: '/getpresensi',
                        data: {
                            _token: "{{ csrf_token() }}",
                            tanggal_presensi: startDate // Kirim satu tanggal
                        },
                        cache: false,
                        success: function(respond) {
                            $("#loadpresensi").html(respond);
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '/getpresensi',
                        data: {
                            _token: "{{ csrf_token() }}",
                            start_date: startDate,
                            end_date: endDate
                        },
                        cache: false,
                        success: function(respond) {
                            $("#loadpresensi").html(respond);
                        }
                    });
                }
            }
        }
    });

    // Styling tambahan untuk datepicker
    datepicker.config.onReady.push(function() {
        const calendarContainer = datepicker.calendarContainer;
        const calendarMonthNav = datepicker.monthNav;
        const calendarNextMonthNav = datepicker.nextMonthNav;
        const calendarPrevMonthNav = datepicker.prevMonthNav;
        const calendarDaysContainer = datepicker.daysContainer;

        calendarContainer.className +=
            " bg-white p-4 border border-blue-gray-50 rounded-lg shadow-lg shadow-blue-gray-500/10 font-sans text-sm font-normal text-blue-gray-500 focus:outline-none break-words whitespace-normal";
        calendarMonthNav.className +=
            " flex items-center justify-between mb-4 [&>div.flatpickr-month]:-translate-y-3";
        calendarNextMonthNav.className +=
            " absolute !top-2.5 !right-1.5 h-6 w-6 bg-transparent hover:bg-blue-gray-50 !p-1 rounded-md transition-colors duration-300";
        calendarPrevMonthNav.className +=
            " absolute !top-2.5 !left-1.5 h-6 w-6 bg-transparent hover:bg-blue-gray-50 !p-1 rounded-md transition-colors duration-300";
        calendarDaysContainer.className +=
            " [&_span.flatpickr-day]:!rounded-md [&_span.flatpickr-day.selected]:!bg-gray-900 [&_span.flatpickr-day.selected]:!border-gray-900";
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@endsection
