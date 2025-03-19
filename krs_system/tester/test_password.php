<?php
$password_input = 'admin123';
$hashed_password_from_db = '$2y$10$e0NR.V8Cn7zS/X/yvM0bKuZc9rS5MROo1Jp3tp7Cfu7OTty5JrMfq';

if (password_verify($password_input, $hashed_password_from_db)) {
    echo "✅ Password benar!";
} else {
    echo "❌ Password salah!";
}
?>
