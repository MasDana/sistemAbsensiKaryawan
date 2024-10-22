{{-- <!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Mobilekit Mobile UI Kit</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/img/icon/192x192.png">
    <link rel="stylesheet" href="{{ asset('css/dashkar.css') }}">
    <link rel="manifest" href="{{ asset('js/__manifest.json') }}">
</head>

<body style="background-color:#e9ecef;">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->



    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar">
                    <img src="{{ asset('gambar/avatar1.jpg') }}" alt="avatar" class="imaged w64 rounded">
                </div>
                <div id="user-info">
                    <h2 id="user-name">Adam Abdi Al A'la</h2>
                    <span id="user-role">Head of IT</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar-number"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="warning" style="font-size: 40px;">
                                    <ion-icon name="document-text"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Histori</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        <ion-icon name="camera"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Masuk</h4>
                                        <span>{{ $presensihariini != null ? $presensihariini->jam_masuk : 'Belum absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence">
                                        <ion-icon name="camera"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Pulang</h4>
                                        <span>{{ $presensihariini != null && $presensihariini->jam_keluar != null ?  $presensihariini->jam_keluar: 'Belum absen' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($historibulanini as $item)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="image-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>   {{ date ("d-m-y", strtotime($item->tanggal_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $item -> jam_masuk }}</span>
                                        <span class="badge badge-danger">{{ $presensihariini != null && $item -> jam_keluar != null ? $item ->jam_keluar : 'Belum absen' }}</span>

                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            <li>
                                <div class="item">
                                    <img src="{{ asset('gambar/avatar1.jpg') }}" alt="image" class="image">
                                    <div class="in">
                                        <div>Edward Lindgren</div>
                                        <span class="text-muted">Designer</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="{{ asset('gambar/avatar1.jpg') }}" alt="image" class="image">
                                    <div class="in">
                                        <div>Emelda Scandroot</div>
                                        <span class="badge badge-primary">3</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="{{ asset('gambar/avatar1.jpg') }}" alt="image" class="image">
                                    <div class="in">
                                        <div>Henry Bove</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="{{ asset('gambar/avatar1.jpg') }}" alt="image" class="image">
                                    <div class="in">
                                        <div>Henry Bove</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="item">
                                    <img src="{{ asset('gambar/avatar1.jpg') }}" alt="image" class="image">
                                    <div class="in">
                                        <div>Henry Bove</div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <div class="appBottomMenu">
        <a href="#" class="item">
            <div class="col">
                <ion-icon name="file-tray-full-outline" role="img" class="md hydrated"
                    aria-label="file tray full outline"></ion-icon>
                <strong>Today</strong>
            </div>
        </a>
        <a href="#" class="item active">
            <div class="col">
                <ion-icon name="calendar-outline" role="img" class="md hydrated"
                    aria-label="calendar outline"></ion-icon>
                <strong>Calendar</strong>
            </div>
        </a>
        <a href="#" class="item">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="#" class="item">
            <div class="col">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>Docs</strong>
            </div>
        </a>
        <a href="javascript:;" class="item">
            <div class="col">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->




    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <!-- AmCharts -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <!-- Base Js File -->
    <script src="{{ asset('js/base.js') }}"></script>


    <script>
        am4core.ready(function () {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chartdiv", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.legend = new am4charts.Legend();

            chart.data = [
                {
                    country: "Hadir",
                    litres: 501.9
                },
                {
                    country: "Sakit",
                    litres: 301.9
                },
                {
                    country: "Izin",
                    litres: 201.1
                },
                {
                    country: "Terlambat",
                    litres: 165.8
                },
            ];



            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "litres";
            series.dataFields.category = "country";
            series.alignLabels = false;
            series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
            series.labels.template.radius = am4core.percent(-40);
            series.labels.template.fill = am4core.color("white");
            series.colors.list = [
                am4core.color("#1171ba"),
                am4core.color("#fca903"),
                am4core.color("#37db63"),
                am4core.color("#ba113b"),
            ];
        }); // end am4core.ready()
    </script>

</body>

</html> --}}

    
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karyawan</title>
    <link href="../dist/output.css" rel="stylesheet">
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

    @vite('resources/css/app.css')

  </head>

  <body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white py-4 px-4 sm:px-6 md:px-8 lg:px-20 shadow-md flex-none">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-black text-2xl font-bold">Sistem Manajemen Karyawan</h1>
            </div>
            <div class="header-right flex items-center space-x-2 md:space-x-4"> 
                <div class="profile flex items-center space-x-2 md:space-x-4">
                    <img src="assets/profile1.jpg" alt="Profile" class="w-12 h-12 rounded-full">
                    <span class="text-black">Sariwati</span>
                </div>
                <form action="/sesi/logout" method="get">
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar dan Konten Utama -->
    <div class="flex flex-grow overflow-hidden">

     

        <!-- Konten Utama -->
        <div class="flex-grow overflow-y-auto p-6">

            <!-- Card Profil -->
            <div class="card flex items-center bg-white p-6 rounded-lg shadow-md w-full mb-8">
                <div class="image-section flex-shrink-0 flex items-center justify-center bg-indigo-600 p-1.5 w-40 h-40 rounded-full">
                    <img src="assets/profile1.jpg" alt="Profile picture" class="w-full h-full rounded-full">
                </div>
                <div class="text-section ml-8 flex flex-col justify-center">
                    <h2 class="text-2xl font-bold">I Putu Putri Kumala Sari</h2>
                    <h3 class="text-lg font-bold text-gray-600 mt-2">Business Analyst Strategy Development</h3>
                    <p class="text-black text-lg mt-4 leading-relaxed">
                        "The key to success in business analysis is the ability to accurately interpret data, understand needs, and turn opportunities into solid, sustainable strategies for business growth."
                    </p>
                </div>
            </div>

            <!-- Menu-bar -->
            <div class="card bg-white py-4 px-4 rounded-xl shadow-md mb-8">
                <div class="grid grid-cols-4 gap-8">
                    <div class="item-menu text-center">
                        <a href="#" class="text-indigo-800 text-4xl">
                            <i class="fas fa-user"></i> <!-- Ikon Profil -->
                        </a>
                        <span class="text-sm font-semibold mt-2 block">Profil</span>
                    </div>
            
                    <div class="item-menu text-center">
                        <a href="#" class="text-indigo-800 text-4xl">
                            <i class="fas fa-calendar-alt"></i> <!-- Ikon Cuti -->
                        </a>
                        <span class="text-sm font-semibold mt-2 block">Cuti</span>
                    </div>
            
                    <div class="item-menu text-center">
                        <a href="#" class="text-indigo-800 text-4xl">
                            <i class="fas fa-file-alt"></i> <!-- Ikon Histori -->
                        </a>
                        <span class="text-sm font-semibold mt-2 block">Histori</span>
                    </div>
            
                    <div class="item-menu text-center">
                        <a href="#" class="text-indigo-800 text-4xl">
                            <i class="fas fa-map-marker-alt"></i> <!-- Ikon Lokasi -->
                        </a>
                        <span class="text-sm font-semibold mt-2 block">Lokasi</span>
                    </div>
                </div>
            </div>
            

            <div class="card bg-white p-6 rounded-lg shadow-md mb-8 h-80 flex flex-col"> <!-- Kartu Pembungkus dengan tinggi tetap -->
                <div class="flex-grow grid grid-cols-2 gap-6 mb-8"> 
                    <div class="card bg-green-600 text-white p-4 rounded-lg shadow-lg flex items-center justify-center">
                        <ion-icon name="camera" class="text-4xl mr-4"></ion-icon>
                        <div>
                            <h4 class="font-semibold">Masuk</h4>
                            <span>{{ $presensihariini != null ? $presensihariini->jam_masuk : 'Belum absen' }}</span>                        </div>
                    </div>
                    <div class="card bg-red-600 text-white p-4 rounded-lg shadow-lg flex items-center justify-center">
                        <ion-icon name="camera" class="text-4xl mr-4"></ion-icon>
                        <div>
                            <h4 class="font-semibold">Pulang</h4>
                            <span>{{ $presensihariini != null && $presensihariini->jam_keluar != null ?  $presensihariini->jam_keluar: 'Belum absen' }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex-grow"></div>
    
                

                  <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($historibulanini as $item)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="image-outline" role="img" class="md hydrated"
                                            aria-label="image outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>   {{ date ("d-m-y", strtotime($item->tanggal_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $item -> jam_masuk }}</span>
                                        <span class="badge badge-danger">{{ $presensihariini != null && $item -> jam_keluar != null ? $item ->jam_keluar : 'Belum absen' }}</span>

                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                   

                </div>
            </div>
        </div>
    </div>
            
            <!-- Section Histori Bulanan -->
            <div class="section-histori-bulanan">
                <!-- Card Utama -->
                <div class="card bg-white rounded-lg shadow p-2 cursor-pointer relative" onclick="toggleDropdown()">
                    <h2 class="text-xl font-bold text-center">Bulan Ini</h2>
                    <div id="border" class="border-t border-gray-300 absolute w-full top-full left-0 hidden"></div> 
                </div>
            
                <!-- Konten Dropdown -->
                <div id="dropdown-content" class="hidden bg-white rounded-b-lg shadow-md p-4 transition-all duration-300 ease-in-out">
                    <div class="flex items-center mb-2">
                        <ion-icon name="image-outline" class="text-2xl text-gray-600 mr-2"></ion-icon>
                        <span class="text-lg font-semibold">Foto Anda</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <ion-icon name="image-outline" class="text-2xl text-gray-600 mr-2"></ion-icon>
                        <span class="text-lg font-semibold">Foto Anda</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar bawah -->
    <footer class="fixed bottom-0 w-full bg-white shadow-md flex items-center px-0.5 py-0.5">
        <div class="grid grid-cols-5 gap-2 items-center justify-center w-full">
            <div class="item-menu text-center">
                <a href="#" class="text-gray-700 hover:text-blue-500 h-5 w-5 flex items-center justify-center mx-auto">
                    <ion-icon name="file-tray-full-outline" class="text-4xl"></ion-icon>
                </a>
                <span class="text-xs font-semibold mt-1 block">Today</span>
            </div>
    
            <div class="item-menu text-center">
                <a href="#" class="text-gray-700 hover:text-blue-500 h-5 w-5 flex items-center justify-center mx-auto">
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
                <a href="#" class="text-gray-700 hover:text-blue-500 h-5 w-5 flex items-center justify-center mx-auto">
                    <ion-icon name="document-text-outline" class="text-4xl"></ion-icon>
                </a>
                <span class="text-xs font-semibold mt-1 block">Docs</span>
            </div>
    
            <div class="item-menu text-center">
                <a href="#" class="text-gray-700 hover:text-blue-500 h-5 w-5 flex items-center justify-center mx-auto">
                    <i class="fa-regular fa-user text-4xl"></i>
                </a>
                <span class="text-xs font-semibold mt-1 block">Profile</span>
            </div>
        </div>
    </footer>
    
    
    <script src="js/karyawan.js"></script>
</body>

</html>