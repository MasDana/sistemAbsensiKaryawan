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

<!DOCTYPE html>
<html lang="id">

@vite('resources/css/app.css')


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../path/to/sweetalert.min.js"></script>
    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" />

    
  </head>

  <body class="bg-gray-100 min-h-screen ">

    <header class="bg-indigo-600 text-white p-2 flex items-center">
        <!-- Kontainer Kiri: Ikon Panah -->
        <a href="#" class="text-white text-2xl ml-4">
            <i class="fas fa-arrow-left"></i>
        </a>
    
        <!-- Kontainer Tengah: Teks Blank Page -->
        <div class="flex-grow flex items-center justify-center">
            <h1 class="text-xl font-semibold">Blank Page</h1>
        </div>
    
        <!-- Kontainer Kanan: Ruang Kosong -->
        <div class="w-10">

        </div>
    </header>

    <form action="#" class="space-y-4">
        <!-- Dropdown Bulan -->
        <div>
            <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
            <select id="bulan" name="bulan" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Bulan</option>
                @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ date("m")==$i ? 'selected' : '' }}> {{ $namabulan [$i] }}</option>
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
                 <option value="{{ $tahun }}" {{ date("Y")==$tahunsekarang ? 'selected' : '' }}> {{ $tahun }}</option>
                 @endfor
            </select>
        </div>

        <div class="flex justify-center space-x-2">
            <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500" id="cari">
                Search
            </button>
        </div>

        <div id="showhistori"></div>
    </form>
    
    

    <!-- Bar bawah -->
    <footer class="fixed bottom-0 w-full bg-white shadow-md flex items-center px-0.5 py-0.5">
        <div class="grid grid-cols-5 gap-2 items-center justify-center w-full">
            <div class="item-menu text-center">
                <a href="#" class="text-gray-700 hover:text-indigo-600 h-6 w-6 flex items-center justify-center mx-auto">
                    <ion-icon name="file-tray-full-outline" class="text-4xl"></ion-icon>
                </a>
                <span class="text-xs font-semibold mt-1 block">Today</span>
            </div>
    
            <div class="item-menu text-center">
                <a href="#" class="text-gray-700 hover:text-indigo-600 h-6 w-6 flex items-center justify-center mx-auto">
                    <ion-icon name="calendar-outline" class="text-4xl"></ion-icon>
                </a>
                <span class="text-xs font-semibold mt-1 block">Calendar</span>
            </div>
    
            <div class="item-menu text-center flex flex-col items-center transform -translate-y-4"> 
                <a href="#" class="w-16 h-16 bg-indigo-600 rounded-full flex items-center justify-center text-white shadow-lg mx-auto">
                    <ion-icon name="camera" class="text-3xl"></ion-icon>
                </a>
                <span class="text-xs font-semibold mt-1">Camera</span>
            </div>
    
            <div class="item-menu text-center">
                <a href="#" class="text-gray-700 hover:text-indigo-600 h-6 w-6 flex items-center justify-center mx-auto">
                    <ion-icon name="document-text-outline" class="text-4xl"></ion-icon>
                </a>
                <span class="text-xs font-semibold mt-1 block">Docs</span>
            </div>
    
            <div class="item-menu text-center">
                <a href="#" class="text-gray-700 hover:text-indigo-600 h-6 w-6 flex items-center justify-center mx-auto">
                    <i class="fa-regular fa-user text-4xl"></i>
                </a>
                <span class="text-xs font-semibold mt-1 block">Profile</span>
            </div>
        </div>
    </footer>


    <script>
        $(function(){
            $("#cari").click(function(e){
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();
                $.ajax({
                    type : 'POST',  // Ganti titik koma dengan koma
                    url : '/gethistori',  // URL diapit tanda kutip
                    data: {  // Ganti titik koma dengan koma, dan perbaiki format 'data'
                        _token : "{{ csrf_token() }}",
                        bulan : bulan,
                        tahun : tahun,
                    },
                    cache : false,
                    success: function(respond){
                        $("#showhistori").html(respond);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);  // Tambahkan untuk menangani kesalahan
                    }
                });
            });
        });
    </script>
    
</body>

</html>