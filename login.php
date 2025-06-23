<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'includes/koneksi.php';
require 'includes/auth.php';

$login_id = '';
$password = '';
$error = '';

// Cek jika user sudah login (opsional, redirect langsung)
if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_panel.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

// Proses form login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_id = trim($_POST['login_id']);
    $password = trim($_POST['password']);

    if (!empty($login_id) && !empty($password)) {
        if (login($login_id, $password)) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: admin_panel.php');
            } else {
                header('Location: dashboard.php');
            }
            exit;
        } else {
            $error = "Email/Username atau password salah!";
        }
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/login.css">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="login_id">Email atau Username</label>
            <input 
                type="text" 
                id="login_id" 
                name="login_id" 
                placeholder="Masukkan email atau username di sini" 
                required
            >
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                placeholder="Masukkan password Anda di sini" 
                required
            >
        </div>
        <button type="submit" class="btn">Masuk</button>
    </form>
    <div class="link">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</div>

</body>
</html>
