<?php
$host = "localhost";  // Ganti jika database ada di server lain
$user = "root";       // Sesuaikan dengan username MySQL
$pass = "";           // Sesuaikan dengan password MySQL
$db   = "krs_system";  // Ganti dengan nama database yang digunakan

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
