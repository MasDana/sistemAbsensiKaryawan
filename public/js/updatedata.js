const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function () {
        // Toggle password visibility
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Toggle icon
        eyeIcon.classList.toggle('fa-eye-slash'); // Ganti ikon mata tutup
        eyeIcon.classList.toggle('fa-eye'); // Ganti ikon mata buka
    });


    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Mencegah pengiriman form secara default
            
            // Menampilkan SweetAlert
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data telah diperbarui.',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Mengirim form setelah menutup SweetAlert
                }
            });
        });
    });