<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. Hitung total dari keranjang
$query = mysqli_query($conn, "SELECT SUM(products.harga * cart.jumlah) as total 
                              FROM cart 
                              JOIN products ON cart.product_id = products.id 
                              WHERE cart.user_id = '$user_id'");
$data = mysqli_fetch_assoc($query);
$total = $data['total'];

if ($total > 0) {
    // 2. Simpan ke tabel orders
    mysqli_query($conn, "INSERT INTO orders (user_id, total_bayar) VALUES ('$user_id', '$total')");
    
    // 3. Kosongkan keranjang setelah checkout berhasil
    mysqli_query($conn, "DELETE FROM cart WHERE user_id = '$user_id'");
    
    echo "<script>alert('Checkout Berhasil! Pesanan sedang diproses.'); window.location='riwayat.php';</script>";
} else {
    echo "<script>alert('Keranjang kosong!'); window.location='keranjang.php';</script>";
}
?>