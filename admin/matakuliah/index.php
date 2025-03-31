<?php
include '../config.php';

// Ambil data matakuliah dari database
$query = "SELECT * FROM matakuliah";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Data Mata Kuliah</h2>
    <a href="tambah.php">Tambah Mata Kuliah</a>
    <table border="1">
        <tr>
            <th>Kode Matkul</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $row['kode_matkul']; ?></td>
            <td><?= $row['nama_matkul']; ?></td>
            <td><?= $row['sks']; ?></td>
            <td><?= $row['semester']; ?></td>
            <td>
                <a href="edit.php?kode_matkul=<?= $row['kode_matkul']; ?>">Edit</a> |
                <a href="hapus.php?kode_matkul=<?= $row['kode_matkul']; ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <!-- Tombol Back -->
    <br>
    <a href="../login/menu_utama.php">
        <button>Kembali ke Menu Utama</button>
    </a>

</body>
</html>
