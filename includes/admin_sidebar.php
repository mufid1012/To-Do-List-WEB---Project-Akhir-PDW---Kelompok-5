<nav class="col-md-2 d-md-block sidebar text-white bg-dark">
    <div class="position-sticky">
        <h5 class="text-center text-white mb-3">Admin Panel</h5>
        <p class="text-center">👤 <?= $_SESSION['nama'] ?? 'Admin' ?></p>
        <ul class="nav flex-column px-3">
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'admin_panel.php' ? 'active' : '' ?>" href="admin_panel.php">
                    📋 Daftar Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'admin_jadwal.php' ? 'active' : '' ?>" href="admin_jadwal.php">
                    📅 Jadwal Kuliah
                </a>
            </li>
            <!-- Tambahkan di bawah ini -->
            <li class="nav-item">
                <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === 'admin_informasi.php' ? 'active' : '' ?>" href="admin_informasi.php">
                    ℹ️ Informasi Kuliah
                </a>
            </li>
            <!-- End Penambahan -->
            <li class="nav-item mt-3">
                <a href="logout.php" class="btn btn-outline-light w-100">Logout</a>
            </li>
        </ul>
    </div>
</nav>
