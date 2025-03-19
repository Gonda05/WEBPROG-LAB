<?php
$host = "localhost";
$dbname = "krs_system";
$username = "root";
$password = "";

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    // Buat tabel users jika belum ada
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'dosen', 'mahasiswa') NOT NULL
    )");

    // Cek apakah tabel sudah berisi data
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Masukkan data dummy
        $password_admin = password_hash('admin123', PASSWORD_DEFAULT);
        $password_dosen = password_hash('dosen123', PASSWORD_DEFAULT);
        $password_mhs = password_hash('mhs123', PASSWORD_DEFAULT);

        $pdo->exec("INSERT INTO users (username, password, role) VALUES
            ('admin', '$password_admin', 'admin'),
            ('dosen1', '$password_dosen', 'dosen'),
            ('mahasiswa1', '$password_mhs', 'mahasiswa')
        ");
    }
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
