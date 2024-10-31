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


@foreach ($presensi as $item)
@php
    $foto_masuk=Storage::url('upload/absensi/'.$item->foto_masuk);
    $foto_keluar=Storage::url('upload/absensi/'.$item->foto_keluar);

@endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->karyawan_id }}</td>
        <td>{{ $item->nama_karyawan }}</td>
        <td>{{ $item->jam_masuk != null ? $item->jam_masuk : 'Belum absen' }}</td>
        {{-- <td>{{ $item->foto_masuk }}</td> --}}
        <td><img src="{{ url($foto_masuk) }}" alt="" class="avatar"></td>
        <td>{{ $item->jam_keluar != null ? $item->jam_keluar : 'Belum absen' }}</td>
        {{-- <td>{{ $item->foto_keluar }}</td> --}}
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
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
        
        <td>
            <a href="#" class="btn btn-primary tampilkanpeta" id="{{ $item->id }}">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"  
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"  
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                  <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                  <path d="M9 4v13" />
                  <path d="M15 7v5.5" />
                  <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                  <path d="M19 18v.01" />
               </svg>
            </a>
         </td> 
         
         </tr>
         @endforeach
         
         <script>
            $(function(){
                $(".tampilkanpeta").click(function(e){
                    e.preventDefault(); 
                    var id = $(this).attr("id");
                    $.ajax({
                        type: 'POST', 
                        url: '/tampilkanpeta',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        cache: false, 
                        success: function(respond){
                            $("#loadmap").html(respond);
                            $("#modal-tampilkanpeta").modal("show"); // Tampilkan modal setelah data dimuat
                        }
                    });
                });
            });
            </script>            
         
<style>
   
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 8px 12px;
        text-align: center;
    }
    th {
        background-color: #6C63FF;
        color: white;
    }
    td {
        vertical-align: middle;
    }
   
    .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }
  
    .icon-map-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .icon-map {
        width: 24px;
        height: 24px;
    }
</style>