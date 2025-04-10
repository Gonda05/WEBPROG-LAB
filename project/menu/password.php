<?php
session_start();
require '../config.php'; // Database connection

// Check if admin is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = "Access denied!";
    header("Location: /menu");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === 'change_password') {
        $targetUser = $_POST['username'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (empty($targetUser) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = "All fields are required!";
        } elseif ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match!";
        } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $hashedPassword, $targetUser);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Password updated successfully for user: $targetUser";
            } else {
                $_SESSION['error'] = "Failed to update password.";
            }
            $stmt->close();
        }

    } elseif ($action === 'add_admin') {
        $newUsername = $_POST['new_admin_username'] ?? '';
        $newPassword = $_POST['new_admin_password'] ?? '';
        $confirmPassword = $_POST['new_admin_confirm'] ?? '';

        if (empty($newUsername) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = "All fields are required to create an admin!";
        } elseif ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match!";
        } else {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'admin')");
            $stmt->bind_param("ss", $newUsername, $hashedPassword);
            if ($stmt->execute()) {
                $_SESSION['success'] = "New admin '$newUsername' added successfully.";
            } else {
                $_SESSION['error'] = "Failed to add admin. Maybe username already exists.";
            }
            $stmt->close();
        }
    }

    header("Location: /menu/password.php");
    exit();
}


// Fetch users for dropdown
$users = [];
$result = $conn->query("SELECT username FROM users ORDER BY username ASC");
while ($row = $result->fetch_assoc()) {
    $users[] = $row['username'];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change User Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-gray-100 flex items-center justify-center bg-[url('/asset/bg.png')]">
    <div class="absolute top-6 left-6">
    <a href="/menu" class="inline-flex items-center px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-gray-800 rounded-lg font-medium transition">
        ← Back to Menu
    </a>
    </div>

  <div class="flex gap-6 w-full max-w-6xl px-4">
    <!-- Change Password Panel -->
    <div class="bg-white shadow-md rounded-xl p-8 w-1/2">
      <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Change User Password</h2>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm text-center">
          <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm text-center">
          <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" class="space-y-4">
        <input type="hidden" name="action" value="change_password" />
        <div>
          <label for="username" class="block text-sm font-medium text-gray-700">Select User</label>
          <select name="username" id="username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            <option value="" disabled selected>Select a user</option>
            <?php foreach ($users as $user): ?>
              <option value="<?= htmlspecialchars($user) ?>"><?= htmlspecialchars($user) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div>
          <label for="new_password" class="block text-sm font-medium text-gray-700">New Password</label>
          <input type="password" name="new_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>
        <div>
          <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input type="password" name="confirm_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg">
          Change Password
        </button>
      </form>
    </div>

    <!-- Add New Admin Panel -->
    <div class="bg-white shadow-md rounded-xl p-8 w-1/2">
      <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Add New Admin</h2>

      <form method="POST" class="space-y-4">
        <input type="hidden" name="action" value="add_admin" />
        <div>
          <label for="new_admin_username" class="block text-sm font-medium text-gray-700">Username</label>
          <input type="text" name="new_admin_username" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>
        <div>
          <label for="new_admin_password" class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="new_admin_password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>
        <div>
          <label for="new_admin_confirm" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input type="password" name="new_admin_confirm" required class="w-full px-4 py-2 border border-gray-300 rounded-lg" />
        </div>
        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg">
          Add Admin
        </button>
      </form>
    </div>
  </div>
</body>

</html>
