<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $query = "DELETE FROM dosen WHERE nik='$nik'";
    
    if (mysqli_query($conn, $query)) {
        setFlash("Data berhasil dihapus!", "info");
        header("Location: /menu/index.php?page=dosen");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
