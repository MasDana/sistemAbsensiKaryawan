@extends('layouts.admin')
@section('content')

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">

                <h2 class="page-tittle">
                    Konfigurasi Lokasi
                </h2>
            </div>

        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <form action="/konfigurasi/updatelokasi" method="POST">
                            @csrf
                            <div class="row">
                            </div>

                        </form>
                    </div>
                </div>
                
            </div>

        </div>
    </div>
</div>

@endsection