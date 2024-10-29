<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/konfigurasi/updatelok" method="post">
        @csrf
    <input type="text" name="lokasi_kantor" value="{{ $lok_kantor->lokasi_kantor }}" id="lokasi_kantor" placeholder="Lokasi Kantor">
    <input type="text" name="radius" value="{{ $lok_kantor->radius }}" id="radius" placeholder="Radius">
    <button type="submit">Update</button>
        </form>
</body>
</html>