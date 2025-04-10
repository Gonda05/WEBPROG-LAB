<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

if (isset($_GET['kode_matkul'])) {
    $kode_matkul = $_GET['kode_matkul'];

    // Setelah data di krs dihapus, baru hapus mata kuliah
    $query_matkul = "DELETE FROM matakuliah WHERE kode_matkul = ?";
    $stmt_matkul = $conn->prepare($query_matkul);
    $stmt_matkul->bind_param("s", $kode_matkul);

    if ($stmt_matkul->execute()) {
        setFlash("Data mata kuliah berhasil dihapus!", "info");
        header("Location: /menu/index.php?page=matakuliah");
        exit();
    } else {
        $msg= "Error: " . $stmt_matkul->error;
        setFlash($msg, "info");
    }

    $stmt_matkul->close();
    $conn->close();
} else {
    echo "Kode Matkul tidak ditemukan.";
}
?>
