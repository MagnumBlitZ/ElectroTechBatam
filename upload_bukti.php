<?php
session_start();
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti'])) {
    $id_pesanan = $_POST['id_pesanan'];
    $namaFile = time() . '_' . basename($_FILES['bukti']['name']);
    $tmp = $_FILES['bukti']['tmp_name'];
    $folder = 'uploads/' . $namaFile;

    if (move_uploaded_file($tmp, $folder)) {
        $waktu = date('Y-m-d H:i:s');
        mysqli_query($koneksi, "
            UPDATE pesanan 
            SET bukti_transfer = '$namaFile', waktu_upload = '$waktu' 
            WHERE id = $id_pesanan
        ");

        echo "<script>alert('Bukti transfer berhasil diupload'); window.location.href='status_pesanan.php';</script>";
    } else {
        echo "<script>alert('Gagal mengupload file'); window.location.href='status_pesanan.php';</script>";
    }
}
?>
