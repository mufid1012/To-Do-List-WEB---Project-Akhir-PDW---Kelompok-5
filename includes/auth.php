<?php
// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'koneksi.php'; // Pastikan koneksi DB benar

// =====================
// FUNGSI LOGIN
// =====================
function login($identifier, $password) {
    global $koneksi;

    $query = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['id_user']  = $user['id_user'];
            $_SESSION['nama']     = $user['nama'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'] ?? 'user'; // Pastikan ada fallback

            return true;
        }
    }

    return false;
}

// =====================
// FUNGSI REGISTRASI
// =====================
function register($nama, $email, $username, $password) {
    global $koneksi;

    // Escape input (optional karena akan gunakan bind_param kalau ingin lebih aman)
    $nama     = mysqli_real_escape_string($koneksi, $nama);
    $email    = mysqli_real_escape_string($koneksi, $email);
    $username = mysqli_real_escape_string($koneksi, $username);
    $password = mysqli_real_escape_string($koneksi, $password);

    // Cek duplikat email / username
    $query = "SELECT * FROM users WHERE email = '$email' OR username = '$username'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result) > 0) {
        return false;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Simpan user baru dengan default role = 'user'
    $query = "INSERT INTO users (nama, email, username, password, role) VALUES ('$nama', '$email', '$username', '$hashed_password', 'user')";
    $result = mysqli_query($koneksi, $query);

    return $result;
}

// =====================
// TAMBAH TUGAS
// =====================
function tambahTugas($id_user, $nama_tugas, $deskripsi, $tanggal_deadline) {
    global $koneksi;

    if (empty($nama_tugas) || empty($tanggal_deadline)) {
        return false;
    }

    $deadline = strtotime($tanggal_deadline);
    $today = strtotime(date('Y-m-d'));

    if ($deadline < $today) {
        return false;
    }

    $query = "INSERT INTO tugas (id_user, nama_tugas, deskripsi, tanggal_deadline, tanggal_dibuat, status_tugas)
              VALUES (?, ?, ?, ?, NOW(), 'belum')";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('isss', $id_user, $nama_tugas, $deskripsi, $tanggal_deadline);

    return $stmt->execute();
}

// =====================
// HAPUS TUGAS
// =====================
function hapusTugas($id_tugas, $id_user) {
    global $koneksi;

    $query = "DELETE FROM tugas WHERE id_tugas = ? AND id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ii", $id_tugas, $id_user);

    return $stmt->execute();
}

// =====================
// EDIT TUGAS
// =====================
function editTugas($id_tugas, $id_user, $nama_baru, $deskripsi_baru, $deadline_baru) {
    global $koneksi;

    if (empty($nama_baru) || empty($deadline_baru)) {
        return false;
    }

    $deadline = strtotime($deadline_baru);
    $today = strtotime(date('Y-m-d'));
    if ($deadline < $today) {
        return false;
    }

    $query = "UPDATE tugas SET nama_tugas = ?, deskripsi = ?, tanggal_deadline = ? 
              WHERE id_tugas = ? AND id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssii", $nama_baru, $deskripsi_baru, $deadline_baru, $id_tugas, $id_user);

    return $stmt->execute();
}
