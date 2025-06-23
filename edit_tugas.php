<?php
session_start();
require 'includes/koneksi.php';
require 'includes/auth.php';

if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['id_tugas'])) {
    header('Location: dashboard.php');
    exit;
}

$id_tugas = $_GET['id_tugas'];

$query = "SELECT * FROM tugas WHERE id_tugas = ? AND id_user = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('ii', $id_tugas, $id_user);
$stmt->execute();
$result = $stmt->get_result();
$tugas = $result->fetch_assoc();

if (!$tugas) {
    header('Location: dashboard.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_tugas'])) {
    $nama_tugas = trim($_POST['nama_tugas']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_deadline = trim($_POST['tanggal_deadline']);
    $status = trim($_POST['status_tugas']);

    if (!empty($nama_tugas) && !empty($tanggal_deadline)) {
        $today = date('Y-m-d');
        if ($tanggal_deadline < $today) {
            $error = "Tanggal deadline tidak boleh di masa lalu.";
        } else {
            $update_query = "UPDATE tugas SET nama_tugas = ?, deskripsi = ?, tanggal_deadline = ?, status_tugas = ? WHERE id_tugas = ? AND id_user = ?";
            $update_stmt = $koneksi->prepare($update_query);
            $update_stmt->bind_param('ssssii', $nama_tugas, $deskripsi, $tanggal_deadline, $status, $id_tugas, $id_user);

            if ($update_stmt->execute()) {
                header('Location: dashboard.php?status=edit_berhasil');
                exit;
            } else {
                $error = "Gagal memperbarui tugas.";
            }
        }
    } else {
        $error = "Nama tugas dan tanggal deadline wajib diisi.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php include 'includes/header.php'; ?>

<!-- Garis pembatas -->
<hr class="m-0" style="border-top: 3px solid #ddd;">

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Tugas</h4>
        </div>
        <div class="card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label for="nama_tugas" class="form-label">Nama Tugas</label>
                    <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" value="<?= htmlspecialchars($tugas['nama_tugas']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?= htmlspecialchars($tugas['deskripsi']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="tanggal_deadline" class="form-label">Tanggal Deadline</label>
                    <input 
                        type="date" 
                        class="form-control" 
                        id="tanggal_deadline" 
                        name="tanggal_deadline" 
                        value="<?= htmlspecialchars(date('Y-m-d', strtotime($tugas['tanggal_deadline']))); ?>" 
                        min="<?= date('Y-m-d'); ?>" 
                        required
                    >
                </div>
                <div class="mb-3">
                    <label for="status_tugas" class="form-label">Status</label>
                    <select class="form-select" id="status_tugas" name="status_tugas" required>
                        <option value="belum" <?= $tugas['status_tugas'] === 'belum' ? 'selected' : ''; ?>>Belum</option>
                        <option value="selesai" <?= $tugas['status_tugas'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" name="update_tugas" class="btn btn-success">Simpan Perubahan</button>
                    <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>
