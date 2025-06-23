<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'includes/koneksi.php';

$notification = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = $_POST['role'];

    if ($nama && $username && $email && $password && in_array($role, ['admin', 'user'])) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $koneksi->prepare("INSERT INTO users (nama, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $username, $email, $hashed, $role);
        if ($stmt->execute()) {
            $_SESSION['msg'] = "Pengguna baru berhasil ditambahkan.";
            header("Location: admin_panel.php");
            exit();
        } else {
            $notification = "Terjadi kesalahan saat menyimpan ke database.";
        }
    } else {
        $notification = "Semua field harus diisi dengan benar.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Tambah Pengguna Baru</h2>

    <?php if (!empty($notification)) : ?>
        <div class="alert alert-danger"><?= htmlspecialchars($notification) ?></div>
    <?php endif; ?>

    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="4">
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <a href="admin_panel.php" class="btn btn-secondary">🔙 Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
        </div>
    </form>
</div>
</body>
</html>
