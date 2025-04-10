<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

$id = $_GET['id_trx_matkul'] ?? null;

if (!$id) {
    setFlash('ID tidak ditemukan.', 'error');
    echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
    exit;
}

// Cek apakah data kelas masih ada
$check = mysqli_query($conn, "SELECT * FROM trx_matkul WHERE id_trx_matkul = '$id'");
if (mysqli_num_rows($check) === 0) {
    setFlash('Kelas tidak ditemukan.', 'error');
    echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
    exit;
}

// Hapus kelas
$delete = mysqli_query($conn, "DELETE FROM trx_matkul WHERE id_trx_matkul = '$id'");

if ($delete) {
    setFlash('Kelas berhasil dihapus.', 'success');
} else {
    setFlash('Gagal menghapus kelas.', 'error');
}

echo "<script>window.location.href = '/menu/index.php?page=krs';</script>";
exit;
