@extends('layout/layoutadmin')

@section('konten')
    <div>
        <form action="/presensi/laporanpribadi" method="POST" target="_blank">
            @csrf
            <div>
                <select name="bulan" id="bulan" placeholder="bulan">
                    <option value="">Pilih Bulan</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $namabulan[$i] }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <select name="tahun" id="tahun">
                    <option value="">Pilih Tahun</option>
                    @php
                        $tahunmulai = 2023;
                        $tahunsekarang = date('Y');
                    @endphp
                    @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <select name="karyawan" id="karyawan">
                    <option value="">Pilih Karyawan</option>
                    @foreach ($karyawan as $d)
                        <option value="{{ $d->id }}">{{ $d->nama_karyawan }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <!-- Tambahkan atribut name untuk tombol print -->
                <button type="submit" name="action" value="print">Print</button>
            </div>
            <div>
                <!-- Tambahkan atribut name untuk tombol excel -->
                <button type="submit" name="action" value="excel">Excel</button>
            </div>
        </form>

    </div>
@endsection
