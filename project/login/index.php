<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-dvh w-dvh flex items-center justify-center bg-[url('/asset/bg.png')] bg-cover bg-center font-sans">

  <div class="bg-white bg-opacity-90 backdrop-blur-md shadow-xl rounded-2xl p-8 w-full max-w-md">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login to Your Account</h2>

    <?php if (isset($_SESSION['error'])) { ?>
      <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm text-center">
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php } ?>

    <form action="./process.php" method="POST" class="space-y-4">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
        <input type="text" name="username" id="username" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
        <input type="password" name="password" id="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"/>
      </div>

      <button type="submit"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition duration-200">
        Login
      </button>
    </form>
  </div>

</body>
</html>
