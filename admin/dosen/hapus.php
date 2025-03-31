<?php
include '../config.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $query = "DELETE FROM dosen WHERE nik='$nik'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
