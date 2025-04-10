<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

$query_last_nim = "SELECT nim FROM mahasiswa ORDER BY nim DESC LIMIT 1";
$result = mysqli_query($conn, $query_last_nim);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $last_nim = (int)substr($row['nim'], 1); // M010 → 10
    $new_nim = "M" . str_pad($last_nim + 1, 3, "0", STR_PAD_LEFT);
} else {
    $new_nim = "M001";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $tahun_masuk = $_POST['tahun_masuk'];
    $alamat = $_POST['alamat'];
    $telp = $_POST['telp'];
    $user_input = $_SESSION['username'];

    $query = "INSERT INTO mahasiswa (nim, nama, jurusan, tahun_masuk, alamat, telp, user_input) 
              VALUES ('$new_nim', '$nama', '$jurusan', '$tahun_masuk', '$alamat', '$telp', '$user_input')";

    if (mysqli_query($conn, $query)) {
        // After inserting mahasiswa, update password in users table
        $username = strtolower(str_replace(' ', '', $nama));
        $password_raw = substr($telp, -4); // last 4 digits of phone number
        $password_hashed = password_hash($password_raw, PASSWORD_DEFAULT);

        $update_query = "UPDATE users SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($update_query);
        
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $password_hashed, $username);
        $stmt->execute();
        $stmt->close();

        setFlash("Data mahasiswa berhasil dimasukkan!", "success");
        header("Location: /menu/index.php?page=mahasiswa");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

ob_start();
?>

<form method="POST" action="/menu/mahasiswa/tambah.php" class="space-y-4">
    <div>
        <label class="block">NIM:</label>
        <input type="text" value="<?= $new_nim; ?>" readonly class="border rounded p-2 w-full bg-gray-100">
    </div>
    <div>
        <label class="block">Nama:</label>
        <input type="text" name="nama" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Jurusan:</label>
        <input type="text" name="jurusan" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Tahun Masuk:</label>
        <input type="number" name="tahun_masuk" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Alamat:</label>
        <textarea name="alamat" required class="border rounded p-2 w-full"></textarea>
    </div>
    <div>
        <label class="block">Telepon:</label>
        <input type="text" name="telp" required class="border rounded p-2 w-full">
    </div>
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>
</form>
