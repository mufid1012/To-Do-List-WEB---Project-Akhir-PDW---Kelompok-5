<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'includes/koneksi.php';

$notification = "";

// Tambah informasi
if (isset($_POST['tambah'])) {
    $teks = $_POST['teks'];
    $warna = $_POST['warna'];

    $stmt = $koneksi->prepare("INSERT INTO informasi_kuliah (teks, warna) VALUES (?, ?)");
    $stmt->bind_param("ss", $teks, $warna);
    $stmt->execute();
    $notification = "✅ Informasi berhasil ditambahkan.";
}

// Hapus informasi
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    mysqli_query($koneksi, "DELETE FROM informasi_kuliah WHERE id = $id");
    $notification = "🗑️ Informasi berhasil dihapus.";
}

// Update informasi
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $teks = $_POST['teks'];
    $warna = $_POST['warna'];

    $stmt = $koneksi->prepare("UPDATE informasi_kuliah SET teks=?, warna=? WHERE id=?");
    $stmt->bind_param("ssi", $teks, $warna, $id);
    $stmt->execute();
    $notification = "✏️ Informasi berhasil diperbarui.";
}

// Update urutan
if (isset($_POST['save_order'])) {
    $ids = explode(',', $_POST['order']);
    foreach ($ids as $index => $id) {
        $id = intval($id);
        mysqli_query($koneksi, "UPDATE informasi_kuliah SET urutan = $index WHERE id = $id");
    }
    $notification = "🔃 Urutan informasi diperbarui.";
}

$informasi = mysqli_query($koneksi, "SELECT * FROM informasi_kuliah ORDER BY urutan ASC");
$current = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Informasi Kuliah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

    /* Tambahan yang sudah ada */
    .sortable-item {
        cursor: move;
        background-color: #f9f9f9;
    }
    .sortable-item.dragging {
        opacity: 0.5;
    }
</style>


    <!-- Quill Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .sortable-item {
            cursor: move;
            background-color: #f9f9f9;
        }
        .sortable-item.dragging {
            opacity: 0.5;
        }
    </style>
</head>
<body class="bg-light">
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/admin_sidebar.php'; ?>

        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            <h2>Kelola Informasi Kuliah</h2>

            <?php if (!empty($notification)) : ?>
                <div class="alert alert-info"><?= htmlspecialchars($notification) ?></div>
            <?php endif; ?>

            <!-- Form Tambah -->
            <form method="POST" class="mb-4">
                <div class="mb-2">
                    <label for="editor" class="form-label">Tulis Informasi:</label>
                    <div id="editor" style="height: 150px;"></div>
                    <input type="hidden" name="teks" id="teksInput">
                </div>
                <div class="mb-3 d-flex gap-2 align-items-center">
                    <label for="warna">Warna:</label>
                    <input type="color" name="warna" class="form-control form-control-color" value="#0d6efd">
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
                <div>
                    <label class="form-label">Live Preview:</label>
                    <div id="preview" class="border p-3 bg-white" style="min-height: 50px;"></div>
                </div>
            </form>

            <!-- Daftar Informasi -->
            <form method="POST" id="urutanForm">
                <ul class="list-group mb-4" id="sortableList">
                    <?php while ($row = mysqli_fetch_assoc($informasi)) : ?>
                        <li class="list-group-item sortable-item" data-id="<?= $row['id'] ?>">
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <div class="d-flex justify-content-between">
                                    <div style="flex:1;">
                                        <div class="mb-2">
                                            <textarea name="teks" class="form-control"><?= htmlspecialchars($row['teks']) ?></textarea>
                                        </div>
                                        <div class="d-flex gap-2 align-items-center">
                                            <input type="color" name="warna" value="<?= htmlspecialchars($row['warna']) ?>" class="form-control form-control-color">
                                            <button type="submit" name="update" class="btn btn-sm btn-primary">Simpan</button>
                                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus?')" class="btn btn-sm btn-danger">Hapus</a>
                                        </div>
                                    </div>
                                    <div class="text-muted ms-3 small mt-2"><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></div>
                                </div>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>
                <input type="hidden" name="order" id="orderInput">
                <button type="submit" name="save_order" class="btn btn-outline-primary">💾 Simpan Urutan</button>
            </form>
        </main>
    </div>
</div>

<!-- Bootstrap + Quill -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis informasi... (emoji, list, dll)',
        modules: {
            toolbar: [['bold', 'italic', 'underline'], [{ list: 'ordered' }, { list: 'bullet' }], ['link', 'clean']]
        }
    });

    const form = document.querySelector('form');
    const teksInput = document.getElementById('teksInput');
    const preview = document.getElementById('preview');

    quill.on('text-change', function () {
        teksInput.value = quill.root.innerHTML;
        preview.innerHTML = quill.root.innerHTML;
    });

    form.addEventListener('submit', function () {
        teksInput.value = quill.root.innerHTML;
    });

    // Drag & drop sorting
    const list = document.getElementById('sortableList');
    let dragging;

    list.querySelectorAll('.sortable-item').forEach(item => item.setAttribute('draggable', true));

    list.addEventListener('dragstart', e => {
        dragging = e.target;
        dragging.classList.add('dragging');
    });

    list.addEventListener('dragend', () => {
        dragging.classList.remove('dragging');
        updateOrderInput();
    });

    list.addEventListener('dragover', e => {
        e.preventDefault();
        const after = getAfterElement(list, e.clientY);
        if (after == null) {
            list.appendChild(dragging);
        } else {
            list.insertBefore(dragging, after);
        }
    });

    function getAfterElement(container, y) {
        const items = [...container.querySelectorAll('.sortable-item:not(.dragging)')];
        return items.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            return offset < 0 && offset > closest.offset ? { offset, element: child } : closest;
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }

    function updateOrderInput() {
        const ids = [...list.querySelectorAll('.sortable-item')].map(item => item.dataset.id);
        document.getElementById('orderInput').value = ids.join(',');
    }
</script>
</body>
</html>
