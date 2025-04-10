<?php
include '../../config.php';
include '../../components/alert.php';
include_once("../../auth.php");

// Generate NIK
$query_last_nik = "SELECT nik FROM dosen ORDER BY nik DESC LIMIT 1";
$result = mysqli_query($conn, $query_last_nik);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $last_nik = $row['nik'];
    $number = (int) filter_var($last_nik, FILTER_SANITIZE_NUMBER_INT);
    $new_nik = "D" . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
} else {
    $new_nik = "D001";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $gelar = $_POST['gelar'];
    $lulusan = $_POST['lulusan'];
    $telp = $_POST['telp'];
    $user_input = $_SESSION['username'];

    $query = "INSERT INTO dosen (nik, nama, gelar, lulusan, telp, user_input) VALUES ('$new_nik', '$nama', '$gelar', '$lulusan', '$telp', '$user_input')";
    
    if (mysqli_query($conn, $query)) {
        // After inserting dosen, update password in user table
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
    
        setFlash("Data berhasil dimasukkan!", "success");
        header("Location: /menu/index.php?page=dosen");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
    
}

$modal_id = 'tambahDosenModal';
$modal_title = 'Tambah Dosen';
ob_start();
?>

<!-- Modal form content only -->

<form method="POST" action="/menu/dosen/tambah.php" class="space-y-4">
    <input type="hidden" name="nik" value="<?= $new_nik; ?>">
    <div>
        <label class="block">NIK:</label>
        <input type="text" value="<?= $new_nik; ?>" readonly class="border rounded p-2 w-full bg-gray-100">
    </div>
    <div>
        <label class="block">Nama:</label>
        <input type="text" name="nama" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Gelar:</label>
        <input type="text" name="gelar" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Lulusan:</label>
        <input type="text" name="lulusan" required class="border rounded p-2 w-full">
    </div>
    <div>
        <label class="block">Telepon:</label>
        <input type="text" name="telp" required class="border rounded p-2 w-full">
    </div>
    <div class="text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
    </div>
</form>
