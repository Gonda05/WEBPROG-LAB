<?php
include '../config.php';

if (isset($_GET['nim'])) {
    $nim = $_GET['nim'];

    // Hapus data yang terkait di tabel krs terlebih dahulu
    $query_krs = "DELETE FROM krs WHERE nim_mahasiswa = ?";
    $stmt_krs = $conn->prepare($query_krs);
    $stmt_krs->bind_param("s", $nim);
    $stmt_krs->execute();
    $stmt_krs->close();

    // Setelah data di krs dihapus, baru hapus mahasiswa
    $query_mahasiswa = "DELETE FROM mahasiswa WHERE nim = ?";
    $stmt_mhs = $conn->prepare($query_mahasiswa);
    $stmt_mhs->bind_param("s", $nim);

    if ($stmt_mhs->execute()) {
        echo "Data mahasiswa berhasil dihapus.";
    } else {
        echo "Gagal menghapus mahasiswa.";
    }

    $stmt_mhs->close();
    $conn->close();
    header("Location: index.php");
} else {
    echo "NIM tidak ditemukan.";
}
?>
