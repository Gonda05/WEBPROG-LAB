<?php
session_start();

// Jika belum login atau bukan admin, arahkan ke halaman login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php?error=Silakan login terlebih dahulu");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Dashboard Admin</h2>
    
    <h3>Menu Navigasi</h3>
    <ul>
        <li><a href="manage_users.php">Manajemen Pengguna</a></li>
        <ul>
            <li><a href="manage_students.php">Manajemen Mahasiswa</a></li>
            <li><a href="manage_lecturers.php">Manajemen Dosen</a></li>
            <li><a href="manage_admins.php">Manajemen Admin Lainnya</a></li>
        </ul>
        <li><a href="manage_academics.php">Manajemen Akademik</a></li>
        <ul>
            <li><a href="manage_courses.php">Pengelolaan Mata Kuliah</a></li>
            <li><a href="schedule_management.php">Pengelolaan Jadwal Kuliah</a></li>
            <li><a href="krs_khs_management.php">Manajemen KRS dan KHS</a></li>
            <li><a href="exam_management.php">Pengelolaan Ujian dan Nilai</a></li>
        </ul>
        <li><a href="manage_website.php">Manajemen Website Kampus</a></li>
        <ul>
            <li><a href="news_management.php">Berita dan Pengumuman</a></li>
            <li><a href="content_management.php">Pengelolaan Konten Website</a></li>
            <li><a href="gallery_management.php">Galeri dan Media</a></li>
        </ul>
        <li><a href="admin_campus.php">Manajemen Administrasi Kampus</a></li>
        <ul>
            <li><a href="letters_documents.php">Surat Menyurat dan Dokumen Akademik</a></li>
            <li><a href="finance_management.php">Keuangan dan Pembayaran</a></li>
        </ul>
        <li><a href="facilities_management.php">Manajemen Fasilitas Kampus</a></li>
        <ul>
            <li><a href="room_booking.php">Peminjaman Ruang dan Sarana</a></li>
            <li><a href="security_system.php">Keamanan dan Akses Sistem</a></li>
        </ul>
        <li><a href="reports_analytics.php">Laporan dan Analitik</a></li>
        <ul>
            <li><a href="academic_statistics.php">Statistik Akademik</a></li>
            <li><a href="lecturer_performance.php">Laporan Kinerja Dosen</a></li>
        </ul>
    </ul>
    
    <li><a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?');">Logout</a></li>
</body>
</html>