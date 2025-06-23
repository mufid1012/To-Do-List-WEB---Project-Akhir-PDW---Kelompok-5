<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'includes/koneksi.php';

$notification = '';

// Tambah Jadwal
if (isset($_POST['tambah'])) {
    $hari = $_POST['hari'];
    $matkul = $_POST['mata_kuliah'];
    $waktu = $_POST['waktu'];
    $ruang = $_POST['ruang'];

    $stmt = $koneksi->prepare("INSERT INTO jadwal_kuliah (hari, mata_kuliah, waktu, ruang) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $hari, $matkul, $waktu, $ruang);
    $stmt->execute();
    $notification = "✅ Jadwal berhasil ditambahkan.";
}

// Hapus Jadwal
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM jadwal_kuliah WHERE id = $id");
    $notification = "🗑️ Jadwal berhasil dihapus.";
}

// Edit Jadwal
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $hari = $_POST['hari'];
    $matkul = $_POST['mata_kuliah'];
    $waktu = $_POST['waktu'];
    $ruang = $_POST['ruang'];

    $stmt = $koneksi->prepare("UPDATE jadwal_kuliah SET hari=?, mata_kuliah=?, waktu=?, ruang=? WHERE id=?");
    $stmt->bind_param("ssssi", $hari, $matkul, $waktu, $ruang, $id);
    $stmt->execute();
    $notification = "✏️ Jadwal berhasil diperbarui.";
}

// Ambil semua data
$jadwal = mysqli_query($koneksi, "SELECT * FROM jadwal_kuliah ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')");
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Jadwal Kuliah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 1rem;
        }
        .sidebar .nav-link {
            color: #ddd;
        }
        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <h2>Kelola Jadwal Kuliah</h2>

            <?php if (!empty($notification)) : ?>
                <div class="alert alert-info"><?= htmlspecialchars($notification) ?></div>
            <?php endif; ?>

            <!-- Form Tambah -->
            <form method="POST" class="row g-2 align-items-center mb-4">
                <div class="col-md-2">
                    <select name="hari" class="form-select" required>
                        <option value="" disabled selected>Hari</option>
                        <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat'] as $h) : ?>
                            <option value="<?= $h ?>"><?= $h ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="mata_kuliah" class="form-control" placeholder="Mata Kuliah" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="waktu" class="form-control" placeholder="08.00 - 10.00" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="ruang" class="form-control" placeholder="Ruang" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="tambah" class="btn btn-success w-100">Tambah</button>
                </div>
            </form>

            <!-- Tabel Jadwal -->
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Hari</th>
                        <th>Mata Kuliah</th>
                        <th>Waktu</th>
                        <th>Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($jadwal)) : ?>
                        <tr>
                            <form method="POST" class="d-flex">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <td>
                                    <select name="hari" class="form-select form-select-sm">
                                        <?php foreach (['Senin','Selasa','Rabu','Kamis','Jumat'] as $h) : ?>
                                            <option value="<?= $h ?>" <?= $row['hari'] === $h ? 'selected' : '' ?>><?= $h ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="text" name="mata_kuliah" class="form-control form-control-sm" value="<?= htmlspecialchars($row['mata_kuliah']) ?>"></td>
                                <td><input type="text" name="waktu" class="form-control form-control-sm" value="<?= htmlspecialchars($row['waktu']) ?>"></td>
                                <td><input type="text" name="ruang" class="form-control form-control-sm" value="<?= htmlspecialchars($row['ruang']) ?>"></td>
                                <td class="text-nowrap">
                                    <button type="submit" name="update" class="btn btn-sm btn-primary">Simpan</button>
                                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>
</body>
</html>
