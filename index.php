<?php
session_start();
// Redirect ke dashboard jika sudah login
if (isset($_SESSION['id_user'])) {
    if ($_SESSION['role'] === 'admin') {
        header('Location: admin_panel.php');
    } else {
        header('Location: dashboard.php');
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Selamat Datang</title>
    <link rel="stylesheet" href="assets/styles/index.css" />
    <style>
        /* Tambahan gaya jika belum punya index.css */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            max-width: 600px;
            width: 90%;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 15px;
            color: #333;
        }

        p {
            color: #666;
            margin-bottom: 30px;
        }

        .buttons {
            margin-bottom: 10px;
        }

        .btn-masuk,
        .btn-daftar {
            display: inline-block;
            padding: 12px 25px;
            margin: 5px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-masuk {
            background-color: #007bff;
        }

        .btn-masuk:hover {
            background-color: #0056b3;
        }

        .btn-daftar {
            background-color: #28a745;
        }

        .btn-daftar:hover {
            background-color: #218838;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang di Aplikasi To-Do List</h1>
        <p>Organisasikan tugas Anda dengan mudah dan nikmati pengalaman manajemen waktu yang lebih baik.<br>Masuk atau daftar untuk memulai!</p>
        
        <div class="buttons">
            <a href="login.php" class="btn-masuk">Masuk</a>
            <a href="register.php" class="btn-daftar">Daftar</a>
        </div>

        <div class="footer">
            <p>&copy; 2024 To-Do List App</p>
        </div>
    </div>
</body>
</html>
