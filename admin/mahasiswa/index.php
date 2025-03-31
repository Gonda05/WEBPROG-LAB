<?php
include '../config.php';

// Ambil data mahasiswa dari database
$query = "SELECT * FROM mahasiswa";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil dieksekusi
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Data Mahasiswa</h2>
    <a href="tambah.php">Tambah Mahasiswa</a>
    <table border="1">
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Tahun Masuk</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['nim']); ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['tahun_masuk']); ?></td>
            <td><?= htmlspecialchars($row['alamat']); ?></td>
            <td><?= htmlspecialchars($row['telp']); ?></td>
            <td>
                <a href="edit.php?nim=<?= urlencode($row['nim']); ?>">Edit</a> |
                <a href="hapus.php?nim=<?= urlencode($row['nim']); ?>" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>
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
