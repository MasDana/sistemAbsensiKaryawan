{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="w-full bg-white shadow-md p-6">
        <h2 class="text-center text-xl font-semibold mb-4">Histori Presensi</h2>

        <form action="#" class="space-y-4">
            <!-- Dropdown Bulan -->
            <div>
                <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                <select id="bulan" name="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}"> {{ $namabulan [$i] }}</option>
                   @endfor
                </select>
            </div>

            <!-- Dropdown Tahun -->
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select id="tahun" name="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Tahun</option>
                    @php
                        $tahunmulai = 2023;
                        $tahunsekarang = date("Y");
                    @endphp
                     @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                     <option value="{{ $tahun }}"> {{ $tahun }}</option>
                     @endfor
                </select>
            </div>

            <div class="flex justify-center space-x-2">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Submit
                </button>
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Search
                </button>
            </div>
        </form>
    </div>

</body>
</html>x --}}
@extends('layout/layoutkaryawan')

@section('css')
@endsection

@section('konten')
    <main class="flex-grow p-8">
        <div class="text-center mb-8">
            <h2 class="text-3xl text-left font-bold text-gray-800 mb-2">Rekapan Izin & Sakit</h2>
            <p class="text-xl text-left text-gray-700">Daftar rekap izin dan sakit karyawan</p>
        </div>

        <div class="flex justify-start items-center gap-4 mt-4 mb-6">
            <form method="POST" action="#" class="flex items-center gap-4">
                @csrf
                <div class="form-group">
                    <select id="bulan" name="bulan"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Bulan</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                {{ $namabulan[$i] }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="form-group">
                    <select id="tahun" name="tahun"
                        class="form-control rounded-md border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tahun</option>
                        @php
                            $tahunmulai = 2023;
                            $tahunsekarang = date('Y');
                        @endphp
                        @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                            <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                        @endfor
                    </select>
                </div>
                <button type="button" id="cari"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cari
                </button>
            </form>
        </div>

        <!-- Hasil -->
        <div id="showhistori" class="space-y-6 max-h-[600px] overflow-y-auto"></div>

        <!-- Script Ajax -->
        <script>
            $(function() {
                $("#cari").click(function() {
                    var bulan = $("#bulan").val();
                    var tahun = $("#tahun").val();
                    $.ajax({
                        type: 'POST',
                        url: '/gethistori',
                        data: {
                            _token: "{{ csrf_token() }}",
                            bulan: bulan,
                            tahun: tahun,
                        },
                        cache: false,
                        success: function(respond) {
                            $("#showhistori").html(respond);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
        </script>
    </main>
@endsection

@section('java')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
