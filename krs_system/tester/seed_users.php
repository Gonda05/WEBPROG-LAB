<?php
require_once '../config/database.php';

try {
    $pdo->beginTransaction(); // Mulai transaksi

    // Hash password sebelum disimpan
    $password_admin = password_hash("adminpass", PASSWORD_DEFAULT);
    $password_dosen = password_hash("dosenpass", PASSWORD_DEFAULT);
    $password_mahasiswa = password_hash("mahasiswa123", PASSWORD_DEFAULT);

    // Query insert ke tabel users
    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?), (?, ?), (?, ?)");
    $stmt->execute([
        'admin@admin', $password_admin,
        'budi@dosen', $password_dosen,
        'rizky@mahasiswa', $password_mahasiswa
    ]);

    $pdo->commit(); // Simpan transaksi
    echo "✅ Data pengguna berhasil ditambahkan!";

} catch (PDOException $e) {
    $pdo->rollBack(); // Batalkan jika gagal
    echo "❌ Gagal menambahkan data: " . $e->getMessage();
}
?>
