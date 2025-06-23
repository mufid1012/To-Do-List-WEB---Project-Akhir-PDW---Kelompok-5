<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id_user = intval($_POST['delete_id']);
    $stmt = $koneksi->prepare("DELETE FROM users WHERE id_user = ?");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $_SESSION['msg'] = "User dengan ID $id_user berhasil dihapus.";
    header("Location: admin_panel.php");
    exit();
}

// Ambil data user
$sql = "SELECT id_user, nama, username, email, role FROM users";
$result = mysqli_query($koneksi, $sql);
$total_users = mysqli_num_rows($result);

// Statistik admin vs user
$count_admin = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_user FROM users WHERE role = 'admin'"));
$count_user  = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_user FROM users WHERE role = 'user'"));

$notification = '';
if (isset($_SESSION['msg'])) {
    $notification = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
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
       <!-- Sidebar -->
<?php include 'includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <h2>Daftar Pengguna</h2>

            <?php if (!empty($notification)) : ?>
                <div class="alert alert-success"><?= htmlspecialchars($notification) ?></div>
            <?php endif; ?>

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" id="searchInput" class="form-control w-50" placeholder="Cari pengguna...">
                <a href="admin_tambah_user.php" class="btn btn-success ms-3">➕ Tambah Pengguna</a>
            </div>

            <p class="fw-bold">Total User Terdaftar: <?= $total_users ?></p>
            <p>Admin: <?= $count_admin ?> | User: <?= $count_user ?></p>

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_user']) ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td>
                                <form method="POST" action="admin_edit_user.php" style="display:inline;">
                                    <input type="hidden" name="edit_id" value="<?= $row['id_user'] ?>">
                                    <button class="btn btn-sm btn-primary">Edit</button>
                                </form>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                    <input type="hidden" name="delete_id" value="<?= $row['id_user'] ?>">
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function () {
        const filter = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
</body>
</html>
