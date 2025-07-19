<?php
session_start();
include '../config/koneksi.php';

// Hanya admin yang boleh akses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$dari_tanggal = $_POST['dari_tanggal'] ?? null;
$sampai_tanggal = $_POST['sampai_tanggal'] ?? null;
$pemesanan = null;

if ($dari_tanggal && $sampai_tanggal) {
    $pemesanan = mysqli_query($koneksi, "
        SELECT * FROM pesanan 
        WHERE DATE(tanggal) BETWEEN '$dari_tanggal' AND '$sampai_tanggal'
        ORDER BY tanggal DESC
    ");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="../css/admin.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <h2>Laporan Penjualan</h2>
        <ul>
            <li><a href="dashboard.php">Kembali ke Dashboard</a></li>
            <li><a href="../logout.php">Logout</a></li>
        </ul>

        <form method="POST" action="">
            <label for="dari_tanggal">Dari Tanggal:</label>
            <input type="date" name="dari_tanggal" value="<?= $dari_tanggal ?>" required>

            <label for="sampai_tanggal">Sampai Tanggal:</label>
            <input type="date" name="sampai_tanggal" value="<?= $sampai_tanggal ?>" required>

            <button type="submit">Tampilkan</button>
        </form>

        <?php if ($pemesanan): ?>
            <h3>Periode: <?= $dari_tanggal ?> s/d <?= $sampai_tanggal ?></h3>
            <table border="1" cellpadding="6" cellspacing="0">
                <tr>
                    <th>ID Pesanan</th>
                    <th>Tanggal</th>
                    <th>Nama Pemesan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>

                <?php while ($p = mysqli_fetch_assoc($pemesanan)): ?>
                    <?php
                        $id_user = $p['user_id'];
                        $ambil_user = mysqli_query($koneksi, "SELECT nama FROM users WHERE id = $id_user");
                        $nama_user = mysqli_fetch_assoc($ambil_user)['nama'];
                    ?>
                    <tr>
                        <td><?= $p['id'] ?></td>
                        <td><?= $p['tanggal'] ?></td>
                        <td><?= $nama_user ?></td>
                        <td>Rp <?= number_format($p['total']) ?></td>
                        <td><?= ucfirst($p['status']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p><strong>Tidak ada data pesanan pada rentang tanggal tersebut.</strong></p>
        <?php endif; ?>
    </div>
    <footer>
        &copy; <?= date("Y") ?> ElectroTech Batam. All rights reserved.
    </footer>
</body>
</html>
