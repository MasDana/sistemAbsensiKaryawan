<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

@php
function selisih($jam_masuk, $jam_keluar)
{
    list($h, $m, $s) = explode(":", $jam_masuk);
    $dtAwal = mktime($h, $m, $s, "1", "1", "1");
    list($h, $m, $s) = explode(":", $jam_keluar);
    $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
    $dtSelisih = $dtAkhir - $dtAwal;
    $totalmenit = $dtSelisih / 60;
    $jam = explode(".", $totalmenit / 60);
    $sisamenit = ($totalmenit / 60) - $jam[0];
    $sisamenit2 = $sisamenit * 60;
    $jml_jam = $jam[0];
    return $jml_jam . ":" . round($sisamenit2);
}
@endphp

<div class="container mt-4">
    <table class="table table-bordered table-striped">
    <table class="min-w-full border-collapse border border-gray-300 rounded-lg shadow-lg overflow-hidden">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="border border-gray-300 px-4 py-2 text-center">No.</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Nama</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Jam Masuk</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Jam Keluar</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Foto</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Keterangan</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Lokasi</th>
                        </tr>
                    </thead>
                   
        <tbody>
            @foreach ($presensi as $item)
                @php
                    $foto_masuk = Storage::url('upload/absensi/' . $item->foto_masuk);
                    $foto_keluar = Storage::url('upload/absensi/' . $item->foto_keluar);
                @endphp
               
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->karyawan_id }}</td>
                    <td>{{ $item->nama_karyawan }}</td>
                    <td>{{ $item->jam_masuk != null ? $item->jam_masuk : 'Belum absen' }}</td>
                    <td><img src="{{ url($foto_masuk) }}" alt="" class="avatar"></td>
                    <td>{{ $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}</td>
                    <td><img src="{{ url($foto_keluar) }}" alt="" class="avatar"></td>
                    <td>
                        @if (strtotime($item->jam_masuk) >= strtotime('06:00:00'))
                            @php
                                $jamterlambat = selisih('06:00:00', $item->jam_masuk);
                            @endphp
                            <span>Terlambat {{ $jamterlambat }}</span>
                        @else
                            <span>Tepat waktu</span>
                        @endif
                    </td>
                    <td>
                        <!-- Button to trigger modal and AJAX request -->
                        <button type="button" class="btn btn-primary tampilkanpeta" data-id="{{ $item->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                <path d="M9 4v13" />
                                <path d="M15 7v5.5" />
                                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                <path d="M19 18v.01" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Structure -->
<div class="modal fade" id="modal-tampilkanpeta" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Lokasi Presensi User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px;">
                    <!-- Content for the map will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(function() {
        $(".tampilkanpeta").click(function(e) {
            e.preventDefault(); 
            var id = $(this).data("id");
            $.ajax({
                type: 'POST', 
                url: '/tampilkanpeta',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false, 
                success: function(respond) {
                    $("#map").html(respond); // Insert the response into the map div
                    $("#modal-tampilkanpeta").modal("show"); // Show the modal
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + error); // Log the error
                    alert("Error occurred: " + xhr.responseText); // Show error message
                }
            });
        });
    });
</script>

<style>
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>
