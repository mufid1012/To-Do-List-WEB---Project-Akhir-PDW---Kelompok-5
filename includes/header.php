<?php
// Mulai sesi
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    include 'includes/auth.php';
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    exit;
}

// Ambil data pengguna dari session
$nama_user = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Pengguna';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .header {
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header .brand {
            font-size: 1.5em;
            font-weight: bold;
        }

        .header .user-info {
            font-size: 1em;
        }

        .header .user-info span {
            font-weight: bold;
        }

        .header .logout {
            margin: auto;
        }

        .header .logout a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #f44336;
            border-radius: 5px;
            transition: background-color 0.5s ease;
        }

        .header .logout a:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">To-Do List App</div>
        <div class="user-info">
            <!-- <span><?php echo htmlspecialchars($nama_user); ?></span> -->
            <div class="logout" id="logout">
                <a href="logout.php">Logout</a>
                <script>
                    //js untuk konfirmasi logout
                    document.getElementById("logout").addEventListener("click", function(event){
                        const konfirmasi = confirm("Apakah anda yakin ingin logout?");

                        if (!konfirmasi) {
                            event.preventDefault();
                            console.log("User membatalkan logout");
                        } else {
                            console.log("User mengkonfirmasi logout");
                        }
                    });
                </script>
            </div>
        </div>
    </div>
