<?php
$host = "localhost";
$user = "root";
$pass = "";  // Kosongkan jika tidak ada password
$db   = "krs_system";  // Harus sesuai dengan nama database yang dibuat

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>
