<?php
$tugas = $conn->query("SELECT * FROM tugas WHERE mahasiswa_id='{$_SESSION['user_id']}'");

echo "<h3>Daftar Tugas</h3>";
while ($row = $tugas->fetch_assoc()) {
    echo "<p>{$row['judul']} - Deadline: {$row['deadline']}</p>";
}
?>
