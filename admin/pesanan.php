    <?php
    session_start();
    include '../config/koneksi.php';

    // Hanya admin yang boleh akses
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../login.php");
        exit;
    }

    // Ambil semua pesanan
    $pemesanan = mysqli_query($koneksi, "SELECT * FROM pesanan ORDER BY tanggal DESC");
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <title>Kelola Pesanan</title>
            <link rel="stylesheet" href="../css/admin.css?v=<?= time(); ?>">
        </head>
        <body>
            <div class="container">
                <h2>Daftar Semua Pesanan</h2>
                
                <ul>
                    <li><a href="dashboard.php">Kembali ke Dashboard</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>

                <?php while ($p = mysqli_fetch_assoc($pemesanan)): ?>
                    <?php
                        // Ambil nama user berdasarkan user_id
                        $id_user = $p['user_id'];
                        $ambil_user = mysqli_query($koneksi, "SELECT nama FROM users WHERE id = $id_user");
                        $nama_user = mysqli_fetch_assoc($ambil_user)['nama'];
                    ?>
                    <h3>Pemesanan #<?= $p['id'] ?> - <?= $p['tanggal'] ?></h3>
                    <p>Nama Pemesan: <?= $nama_user ?> (ID: <?= $p['user_id'] ?>)</p>
                    <p>Total: Rp <?= number_format($p['total']) ?></p>

                    <?php if ($p['metode_pembayaran'] === 'qris' && $p['status'] === 'menunggu'): ?>
                        <?php if (!empty($p['bukti_transfer']) && file_exists('../uploads/' . $p['bukti_transfer'])): ?>
                            <p><strong>Bukti Transfer:</strong></p>
                            <a href="../uploads/<?= $p['bukti_transfer'] ?>" target="_blank">
                                <button style="margin:10px 0;padding:8px 12px;background:#007bff;color:white;border:none;border-radius:5px;cursor:pointer;">
                                    Lihat Bukti Transfer
                                </button>
                            </a>
                        <?php else: ?>
                            <p style="color:red;"><em>Belum ada bukti transfer yang diunggah.</em></p>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form method="POST" action="../proses/update_status.php">
                        <input type="hidden" name="id" value="<?= $p['id'] ?>">
                        <label>Status:</label>
                        <select name="status" onchange="this.form.submit()">
                            <option <?= $p['status'] === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                            <option <?= $p['status'] === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                            <option <?= $p['status'] === 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                            <option <?= $p['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </form>


                    <table border="1" cellpadding="6" cellspacing="0">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>

                        <?php
                        $id_pemesanan = $p['id'];
                        $detail = mysqli_query($koneksi, "
                            SELECT dp.jumlah, dp.sub_total, p.nama, p.harga 
                            FROM detail_pemesanan dp
                            JOIN produk p ON dp.id_produk = p.id
                            WHERE dp.id_pemesanan = $id_pemesanan
                        ");

                        while ($d = mysqli_fetch_assoc($detail)): ?>
                            <tr>
                                <td><?= $d['nama'] ?></td>
                                <td><?= $d['jumlah'] ?></td>
                                <td>Rp <?= number_format($d['harga']) ?></td>
                                <td>Rp <?= number_format($d['sub_total']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                    <hr>
                <?php endwhile; ?>
            </div>
            <footer>
                &copy; <?= date("Y") ?> ElectroTech Batam. All rights reserved.
            </footer>
        </body>
    </html>