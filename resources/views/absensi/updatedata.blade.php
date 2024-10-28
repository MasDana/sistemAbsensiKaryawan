<form action="/karyawan/{{$karyawan->id}}" method="post">
    @csrf

    <!-- Nama Karyawan -->
    <input type="text" name="nama_karyawan" placeholder="Nama" value="{{ $karyawan->nama_karyawan }}"><br>

    <!-- No HP -->
    <input type="text" name="no_hp" placeholder="No HP" value="{{ $karyawan->no_hp }}"><br>

    <!-- Tanggal Lahir -->
    <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir" value="{{ $karyawan->tanggal_lahir }}"><br>

<!-- Gender (Radio Button) dengan nilai default jika null -->
<label>
    <input type="radio" name="gender" value="Male" {{ $karyawan->gender == 'Male' || is_null($karyawan->gender) ? 'checked' : '' }}> Male
</label>
<label>
    <input type="radio" name="gender" value="Female" {{ $karyawan->gender == 'Female' ? 'checked' : '' }}> Female
</label><br>

    <!-- Alamat -->
    <input type="text" name="alamat" placeholder="Alamat" value="{{ $karyawan->alamat }}"><br>

    <!-- Jabatan (Dropdown) -->
    <select name="jabatan_id">
        @foreach($jabatan as $j)
            <option value="{{ $j->id }}" {{ $karyawan->jabatan_id == $j->id ? 'selected' : '' }}>
                {{ $j->nama_jabatan }}
            </option>
        @endforeach
    </select><br>

    <!-- Email -->
    <input type="text" name="email" placeholder="Email" value="{{ $karyawan->email }}"><br>

    <!-- Password -->
    <input type="password" name="password" placeholder="Password"><br>

    <!-- Tombol Submit -->
    <button type="submit">Submit</button>
</form>
