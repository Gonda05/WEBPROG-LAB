<?php
include '../config.php';

if (isset($_GET['kode_matkul'])) {
    $kode_matkul = $_GET['kode_matkul'];

    // Hapus data yang terkait di tabel krs terlebih dahulu
    $query_krs = "DELETE FROM krs WHERE kode_matkul = ?";
    $stmt_krs = $conn->prepare($query_krs);
    $stmt_krs->bind_param("s", $kode_matkul);
    $stmt_krs->execute();
    $stmt_krs->close();

    // Setelah data di krs dihapus, baru hapus mata kuliah
    $query_matkul = "DELETE FROM matakuliah WHERE kode_matkul = ?";
    $stmt_matkul = $conn->prepare($query_matkul);
    $stmt_matkul->bind_param("s", $kode_matkul);

    if ($stmt_matkul->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt_matkul->error;
    }

    $stmt_matkul->close();
    $conn->close();
} else {
    echo "Kode Matkul tidak ditemukan.";
}
?>
