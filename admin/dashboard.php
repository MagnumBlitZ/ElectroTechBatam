<?php
session_start();

// Cek apakah yang login adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/admin.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Selamat datang, <?= $_SESSION['nama'] ?> (Admin)</h2>
        <ul>
            <li><a href="produk.php">Kelola Produk</a></li>
            <li><a href="pesanan.php">Kelola Pesanan</a></li>
            <li><a href="laporan.php">Laporan Penghasilan</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>

        <?php
        include '../config/koneksi.php';

        // Ambil data statistik
        $jumlah_produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM produk"))['total'];
        $jumlah_pesanan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pesanan"))['total'];
        $total_penghasilan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(total) AS total FROM pesanan WHERE status='selesai'"))['total'];
        ?>
        <div class="stats-container">
            <div class="stat-card bg-blue">
                <div class="stat-icon">📦</div>
                <div class="stat-content">
                    <h3>Total Produk</h3>
                    <p><?= $jumlah_produk ?></p>
                </div>
            </div>
            <div class="stat-card bg-green">
                <div class="stat-icon">🧾</div>
                <div class="stat-content">
                    <h3>Total Pesanan</h3>
                    <p><?= $jumlah_pesanan ?></p>
                </div>
            </div>
            <div class="stat-card bg-yellow">
                <div class="stat-icon">💰</div>
                <div class="stat-content">
                    <h3>Total Penghasilan</h3>
                    <p>Rp <?= number_format($total_penghasilan, 0, ',', '.') ?></p>
                </div>
            </div>
        </div>
    </div>
    <footer>
        &copy; <?= date("Y") ?> ElectroTech Batam. All rights reserved.
    </footer>
</body>
</html>