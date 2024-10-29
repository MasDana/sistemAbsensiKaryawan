<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table>
    <thead>
        <th>No</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Email</th>
        <th>No Hp</th>
        <th>Gender</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </thead>

    <tbody>
        @foreach ($karyawan as $item)
            <tr>
                <td>{{ $karyawan -> firstItem()}}</td>
                <td>{{ $item -> id }}</td>
                <td>{{ $item -> nama_jabatan }}</td>
                <td>{{ $item -> email }}</td>
                <td>{{ $item -> no_hp }}</td>
                <td>{{ $item -> gender }}</td>
                <td>{{ $item -> alamat }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $karyawan -> links('vendor.pagination.bootstrap-5') }}
</body>
</html>