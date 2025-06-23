<?php
session_start();
require 'includes/koneksi.php';
require 'includes/auth.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user'];
$nama_user = $_SESSION['nama'];

$query = "SELECT * FROM tugas WHERE id_user = ? ORDER BY tanggal_deadline ASC";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();
$tugas = $result->fetch_all(MYSQLI_ASSOC);

$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 5 CDN -->
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

<!-- Konten Utama -->
<div class="container mt-4">
    <h1 class="mb-3">Selamat Datang, <?= htmlspecialchars($nama_user); ?></h1>
    <p>Kelola tugas Anda di bawah ini:</p>

    <!-- Notifikasi -->
    <?php if (isset($_GET['status'])): ?>
        <div class="alert 
            <?php 
                if ($_GET['status'] === 'tambah_berhasil' || $_GET['status'] === 'edit_berhasil') {
                    echo 'alert-success';
                } else {
                    echo 'alert-danger';
                }
            ?> alert-dismissible fade show" role="alert">
            <?php 
                switch ($_GET['status']) {
                    case 'tambah_berhasil': echo '✅ Tugas berhasil ditambahkan.'; break;
                    case 'tambah_gagal': echo '❌ Gagal menambahkan tugas.'; break;
                    case 'deadline_lampau': echo '❌ Tanggal deadline tidak boleh di masa lalu!'; break;
                    case 'edit_berhasil': echo '✅ Tugas berhasil diperbarui.'; break;
                    case 'edit_gagal': echo '❌ Gagal memperbarui tugas.'; break;
                    case 'deleted': echo '🗑️ Tugas berhasil dihapus.'; break;
                }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form Tambah Tugas -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="add_tugas.php">
                <div class="mb-3">
                    <label for="nama_tugas" class="form-label">Nama Tugas</label>
                    <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="tanggal_deadline" class="form-label">Tanggal Deadline</label>
                    <input type="date" class="form-control" id="tanggal_deadline" name="tanggal_deadline" required>
                </div>
                <button type="submit" name="tambah_tugas" class="btn btn-primary">Tambah Tugas</button>
            </form>
        </div>
    </div>

    <!-- Daftar Tugas -->
    <h2>Daftar Tugas</h2>
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Tugas</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Deadline</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tugas)): ?>
                    <?php foreach ($tugas as $t): ?>
                        <tr>
                            <td><?= htmlspecialchars($t['nama_tugas']) ?></td>
                            <td><?= htmlspecialchars($t['deskripsi']) ?></td>
                            <td><?= htmlspecialchars(date('d-m-Y', strtotime($t['tanggal_deadline']))) ?></td>
                            <td><?= htmlspecialchars($t['status_tugas']) ?></td>
                            <td>
                                <a href="edit_tugas.php?id_tugas=<?= $t['id_tugas'] ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form method="POST" action="delete_tugas.php" class="d-inline">
                                    <input type="hidden" name="hapus_id" value="<?= $t['id_tugas'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus tugas ini?');">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada tugas</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS (opsional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>
