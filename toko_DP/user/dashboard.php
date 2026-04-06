<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman: Cek apakah user sudah login dan rolenya 'user'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

// Ambil data produk untuk ditampilkan ke user
$produk = mysqli_query($conn, "SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User - Toko DP</title>
    <style>
        .container { width: 80%; margin: auto; font-family: sans-serif; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 20px; margin-top: 20px; }
        .card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; text-align: center; }
        .card img { max-width: 100%; height: 150px; object-fit: cover; border-radius: 5px; }
        .btn-beli { background: #28a745; color: white; padding: 10px; text-decoration: none; border-radius: 5px; display: block; margin-top: 10px; }
        nav { background: #f4f4f4; padding: 10px; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Selamat Datang, User!</h2>
    <nav>
        <a href="dashboard.php">Home</a> | 
        <a href="keranjang.php">Keranjang</a> | 
        <a href="riwayat.php">Riwayat Pesanan</a> | 
        <a href="../logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </nav>
    <hr>

    <h3>Produk Tersedia</h3>
    <div class="product-grid">
        <?php if (mysqli_num_rows($produk) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($produk)): ?>
            <div class="card">
                <img src="../uploads/<?= $row['image']; ?>" alt="<?= htmlspecialchars($row['nama_produk']); ?>">
                <h4><?= htmlspecialchars($row['nama_produk']); ?></h4>
                <p>Harga: <strong>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></strong></p>
                <p>Rating: <?= $row['rating']; ?>/5</p>
                <a href="tambah_keranjang.php?id=<?= $row['id']; ?>" class="btn-beli">Tambah ke Keranjang</a>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Belum ada produk yang tersedia.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>