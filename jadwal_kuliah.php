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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include 'includes/header.php'; ?>

<!-- Garis pembatas -->
<hr class="m-0" style="border-top: 3px solid #ddd;">

<!-- Navbar -->
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
    <h2>📅 Jadwal Kuliah</h2>

    <?php
    // Ambil data jadwal dari database
    $query = "SELECT * FROM jadwal_kuliah ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')";
    $result = mysqli_query($koneksi, $query);
    ?>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Hari</th>
                <th>Mata Kuliah</th>
                <th>Waktu</th>
                <th>Ruang</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['hari']) ?></td>
                    <td><?= htmlspecialchars($row['mata_kuliah']) ?></td>
                    <td><?= htmlspecialchars($row['waktu']) ?></td>
                    <td><?= htmlspecialchars($row['ruang']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>
