<?php
$host = 'electrotechbatam-septiandi2209.c.aivencloud.com';
$port = 17293;
$user = 'avnadmin';
$pass = 'AVNS_64n3yPW_Ar4_otkz6FU';
$db   = 'toko';

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>