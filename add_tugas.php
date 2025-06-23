<?php
session_start();
require 'includes/koneksi.php'; // Koneksi ke database
require 'includes/auth.php'; // Cek login

// Pastikan user login
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

$id_user = $_SESSION['id_user'];

// Proses saat form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_tugas = trim($_POST['nama_tugas']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_deadline = trim($_POST['tanggal_deadline']);

    // Validasi input
    if (!empty($nama_tugas) && !empty($tanggal_deadline)) {
        // Cek apakah deadline di masa depan
        $deadline = strtotime($tanggal_deadline);
        $today = strtotime(date('Y-m-d'));

        if ($deadline >= $today) {
            // Insert tugas ke database
            $insert_query = "INSERT INTO tugas (id_user, nama_tugas, deskripsi, tanggal_deadline, tanggal_dibuat, status_tugas) 
                            VALUES (?, ?, ?, ?, NOW(), 'belum')";
            $insert_stmt = $koneksi->prepare($insert_query);
            $insert_stmt->bind_param('isss', $id_user, $nama_tugas, $deskripsi, $tanggal_deadline);

            if ($insert_stmt->execute()) {
                header('Location: dashboard.php?status=tambah_berhasil');
                exit;
            } else {
                header('Location: dashboard.php?status=tambah_gagal');
                exit;
            }
        } else {
            // Deadline di masa lalu
            header('Location: dashboard.php?status=deadline_lampau');
            exit;
        }
    } else {
        // Form tidak lengkap
        header('Location: dashboard.php?status=tambah_gagal');
        exit;
    }
} else {
    header('Location: dashboard.php');
    exit;
}
?>
