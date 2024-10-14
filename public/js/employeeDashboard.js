const sidebar = document.querySelector('.sidebar');
const toggleButton = document.getElementById('toggleButton');

toggleButton.addEventListener('click', () => {
    sidebar.classList.toggle('hidden'); // Menambah/menghapus kelas 'hidden'
    mainDashboard.classList.toggle('expanded'); // Mengubah ukuran dashboard
});