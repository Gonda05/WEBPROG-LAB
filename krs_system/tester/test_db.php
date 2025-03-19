<?php
require_once __DIR__ . '/../config/database.php';



try {
    $stmt = $pdo->query("SELECT 'Koneksi sukses!' AS message");
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $row['message'];
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
