<?php
$kehadiran = $conn->query("SELECT * FROM kehadiran WHERE mahasiswa_id='{$_SESSION['user_id']}'");

echo "<h3>Rekap Kehadiran</h3>";
while ($row = $kehadiran->fetch_assoc()) {
    echo "<p>{$row['mata_kuliah']} - {$row['status']}</p>";
}
?>
