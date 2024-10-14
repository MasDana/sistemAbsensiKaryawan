var a = 1; // Inisialisasi dengan nilai awal

function pass1() {
    if (a == 1) {
        document.getElementById('confirm_password').type = 'text'; // Ubah menjadi 'text' untuk menampilkan password
        document.getElementById('pass-icon1').src = '/gambar/buka.png'; // Ganti ikon untuk menampilkan password
        a = 0; // Ubah nilai a
    } else { 
        document.getElementById('confirm_password').type = 'password'; // Ubah kembali menjadi 'password'
        document.getElementById('pass-icon1').src = '/gambar/tutup.png'; // Ganti ikon untuk menyembunyikan password
        a = 1; // Ubah nilai a
    }
}


function pass2() {
    if (a == 1) {
        document.getElementById('password').type = 'text'; // Ubah menjadi 'text' untuk menampilkan password
        document.getElementById('pass-icon2').src = '/gambar/buka.png'; // Ganti ikon untuk menampilkan password
        a = 0; // Ubah nilai a
    } else { 
        document.getElementById('password').type = 'password'; // Ubah kembali menjadi 'password'
        document.getElementById('pass-icon2').src = '/gambar/tutup.png'; // Ganti ikon untuk menyembunyikan password
        a = 1; // Ubah nilai a
    }
}

