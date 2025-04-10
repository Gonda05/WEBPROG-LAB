<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

if (!isset($_GET['nim']) || empty($_GET['nim'])) {
    setFlash("NIM tidak ditemukan!", "error");
    header("Location: /menu/index.php?page=mahasiswa");
    exit;
}

$nim = $_GET['nim'];

// Hapus data mahasiswa
$query_mahasiswa = "DELETE FROM mahasiswa WHERE nim = ?";
$stmt_mhs = $conn->prepare($query_mahasiswa);
if (!$stmt_mhs) {
    die("Prepare failed (Mahasiswa): " . $conn->error);
}
$stmt_mhs->bind_param("s", $nim);

if ($stmt_mhs->execute()) {
    setFlash("Data berhasil dihapus!", "info");
} else {
    setFlash("Data mahasiswa gagal dihapus!", "error");
}

$stmt_mhs->close();
$conn->close();

header("Location: /menu/index.php?page=mahasiswa");
exit;
?>
