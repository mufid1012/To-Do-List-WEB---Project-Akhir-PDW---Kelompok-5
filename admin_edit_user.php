<?php
session_start();

// Cek apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'includes/koneksi.php';

$user = null; // Untuk form render

// Proses POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Menampilkan form edit
    if (isset($_POST['edit_id'])) {
        $id_user = intval($_POST['edit_id']);
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE id_user = ?");
        $stmt->bind_param("i", $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $_SESSION['msg'] = "User tidak ditemukan.";
            header("Location: admin_panel.php");
            exit;
        }

    // Menyimpan update data user
    } elseif (isset($_POST['update_user'])) {
        $id_user = intval($_POST['id_user']);
        $nama = trim($_POST['nama']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $koneksi->prepare("UPDATE users SET nama=?, username=?, email=?, password=? WHERE id_user=?");
            $stmt->bind_param("ssssi", $nama, $username, $email, $hashed, $id_user);
        } else {
            $stmt = $koneksi->prepare("UPDATE users SET nama=?, username=?, email=? WHERE id_user=?");
            $stmt->bind_param("sssi", $nama, $username, $email, $id_user);
        }

        $stmt->execute();
        $_SESSION['msg'] = "User berhasil diperbarui.";
        header("Location: admin_panel.php");
        exit;
    } else {
        // Tidak ada data yang dikirim
        $_SESSION['msg'] = "Permintaan tidak valid.";
        header("Location: admin_panel.php");
        exit;
    }
} else {
    // Akses langsung via GET tidak diizinkan
    header("Location: admin_panel.php");
    exit;
}
?>

<!-- HTML Form untuk Edit -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background: #eef1f5;
        margin: 0;
        padding: 20px;
    }

    .container {
        width: 100%;
        max-width: 500px;
        background: #fff;
        margin: 50px auto;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 25px;
    }

    label {
        font-weight: bold;
        display: block;
        margin-top: 10px;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    button {
        width: 100%;
        max-width: 100%;
        padding: 10px 12px;
        margin-top: 6px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #fdfdfd;
    }

    button {
        margin-top: 20px;
        background: #007bff;
        border: none;
        color: white;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #0056b3;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #007bff;
        text-decoration: none;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    @media (max-width: 600px) {
        .container {
            margin: 20px 10px;
            padding: 20px;
        }
    }
</style>

</head>
<body>
<?php if ($user): ?>
    <div class="container">
        <h2>Edit Pengguna</h2>
        <form method="POST" action="admin_edit_user.php">
            <input type="hidden" name="id_user" value="<?= $user['id_user'] ?>">
            
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label for="password">Password Baru (kosongkan jika tidak diubah):</label>
            <input type="password" id="password" name="password" placeholder="********">

            <button type="submit" name="update_user">Simpan Perubahan</button>
        </form>
        <a class="back-link" href="admin_panel.php">← Kembali ke Admin Panel</a>
    </div>
<?php endif; ?>
</body>
</html>
