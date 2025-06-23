<?php
session_start();
require 'includes/koneksi.php'; // Koneksi ke database
require 'includes/auth.php'; // Fungsi autentikasi

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['id_user'])) {
    header('Location: dashboard.php');
    exit;
}

// Inisialisasi pesan
$error = "";
$success = "";

// Proses form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $konfirmasi_password = trim($_POST['konfirmasi_password']);

    // Validasi input
    if (!empty($nama) && !empty($email) && !empty($username) && !empty($password) && !empty($konfirmasi_password)) {
        
        if (strlen($username) > 12) {
            $error = "Username tidak boleh lebih dari 12 karakter!";
        } elseif ($password !== $konfirmasi_password) {
            $error = "Password dan konfirmasi password tidak cocok!";
        } else {
            $query = "SELECT * FROM users WHERE email = ? OR username = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param('ss', $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $error = "Email atau username sudah terdaftar!";
            } else {
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $insert_query = "INSERT INTO users (nama, email, username, password) VALUES (?, ?, ?, ?)";
                $insert_stmt = $koneksi->prepare($insert_query);
                $insert_stmt->bind_param('ssss', $nama, $email, $username, $hashed_password);

                if ($insert_stmt->execute()) {
                    $success = "Registrasi berhasil! Silakan login.";
                } else {
                    $error = "Terjadi kesalahan saat menyimpan data.";
                }
            }
        }
    } else {
        $error = "Semua kolom wajib diisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrasi</title>
    <link rel="stylesheet" href="assets/styles/register.css" />
    <style>
        /* Container utama */
        .register-container {
            padding: 20px;
            max-width: 500px;
            margin: 40px auto;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #2e7d32;
        }

        /* Error message */
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        /* Form group */
        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
        }

        /* Input & select element */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #2e7d32;
            outline: none;
        }

        /* Tombol submit */
        button.btn {
            width: 100%;
            background-color: #2e7d32;
            color: white;
            padding: 12px 0;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button.btn:hover {
            background-color: #276627;
        }

        /* Link bawah form */
        .link {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .link a {
            color: #2e7d32;
            text-decoration: none;
            font-weight: bold;
        }

        .link a:hover {
            text-decoration: underline;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 30px;
            border-radius: 12px;
            width: 80%;
            max-width: 400px;
            text-align: center;
            animation: slideUp 0.4s;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            position: relative;
        }

        .modal-content h3 {
            margin-top: 0;
            color: #2e7d32;
        }

        .modal-content p {
            margin: 10px 0;
            color: #555;
        }

        .modal-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background-color: #2e7d32;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }

        .close-btn {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 24px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

        .close-btn:hover {
            color: #333;
        }

        @keyframes slideUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registrasi</h2>

        <?php if (!empty($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" required placeholder="Masukkan nama lengkap Anda" />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Masukkan email Anda" />
            </div>
            <div class="form-group">
                <label for="username">Username (maks. 12 karakter)</label>
                <input type="text" id="username" name="username" maxlength="12" required placeholder="Masukkan username Anda" />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password Anda" />
            </div>
            <div class="form-group">
                <label for="konfirmasi_password">Konfirmasi Password</label>
                <input type="password" id="konfirmasi_password" name="konfirmasi_password" required placeholder="Konfirmasi password Anda" />
            </div>
            <button type="submit" class="btn">Daftar</button>
        </form>

        <div class="link">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </div>

        <!-- Modal Sukses -->
        <div id="successModal" class="modal">
            <div class="modal-content">
                <span class="close-btn">&times;</span>
                <h3>✅ Registrasi Berhasil!</h3>
                <p>Akun Anda telah berhasil dibuat. Silakan login.</p>
                <a href="login.php" class="modal-btn">Login Sekarang</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var modal = document.getElementById("successModal");
            var closeBtn = document.querySelector(".close-btn");

            <?php if (!empty($success)): ?>
            // Tampilkan modal jika sukses
            modal.style.display = "block";
            <?php endif; ?>

            closeBtn.onclick = function () {
                modal.style.display = "none";
            }

            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
</body>
</html>
