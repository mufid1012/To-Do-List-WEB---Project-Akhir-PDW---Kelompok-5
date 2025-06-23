<?php
$host = "localhost";
$user = "mgr12t_mgr12";
$password = "Uur456789gfx_";
$database = "mgr12t_data";

$koneksi = mysqli_connect($host, $user, $password, $database);

// Buat juga alias global agar dapat diakses di file lain dengan global $koneksi
if (!$koneksi) {
    $koneksi = null; // Jangan pakai die(), agar bisa ditest
} else {
    $GLOBALS['koneksi'] = $koneksi;
}
