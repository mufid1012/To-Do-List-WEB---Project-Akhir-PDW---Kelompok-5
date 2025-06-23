<?php
session_start();
require 'includes/koneksi.php';
require 'includes/auth.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

$nama_user = $_SESSION['nama'];
$current = basename($_SERVER['PHP_SELF']);

// Ambil data dari database
$query = "SELECT * FROM informasi_kuliah ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Informasi Kuliah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .info-box {
            border-left: 5px solid #0d6efd;
            background: #f0f8ff;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: .5rem;
        }
    </style>
</head>
<body class="bg-light">
<?php include 'includes/header.php'; ?>

<hr class="m-0" style="border-top: 3px solid #ddd;">

<nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, #74ebd5, #acb6e5); border-bottom: 2px solid #ddd;">
    <div class="container justify-content-center">
        <ul class="navbar-nav">
            <li class="nav-item mx-3">
                <a class="nav-link <?= $current == 'dashboard.php' ? 'text-white fw-bold' : 'text-dark' ?>" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-link <?= $current == 'jadwal_kuliah.php' ? 'text-white fw-bold' : 'text-dark' ?>" href="jadwal_kuliah.php">Jadwal Kuliah</a>
            </li>
            <li class="nav-item mx-3">
                <a class="nav-link <?= $current == 'informasi.php' ? 'text-white fw-bold' : 'text-dark' ?>" href="informasi.php">Informasi</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4">📰 Informasi Kuliah</h2>

    <?php if (mysqli_num_rows($result) > 0) : ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <div class="info-box" style="border-left-color: <?= htmlspecialchars($row['warna']) ?>">
                <div style="color: <?= htmlspecialchars($row['warna']) ?>;">
                    <?= $row['teks'] ?>
                </div>
                <small class="text-muted">🕒 <?= date('d M Y H:i', strtotime($row['tanggal'])) ?></small>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <div class="alert alert-warning">Belum ada informasi yang ditampilkan.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>
