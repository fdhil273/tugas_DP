<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'];

// Cek apakah produk sudah ada di keranjang user tersebut
$cek = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");

if (mysqli_num_rows($cek) > 0) {
    // Jika sudah ada, tambah jumlahnya saja
    mysqli_query($conn, "UPDATE cart SET jumlah = jumlah + 1 WHERE user_id='$user_id' AND product_id='$product_id'");
} else {
    // Jika belum ada, masukkan data baru
    mysqli_query($conn, "INSERT INTO cart (user_id, product_id, jumlah) VALUES ('$user_id', '$product_id', 1)");
}

echo "<script>alert('Produk ditambahkan ke keranjang!'); window.location='dashboard.php';</script>";
?>