<?php
session_start();
include '../config/koneksi.php';

// Proteksi halaman: Cek apakah user sudah login dan rolenya admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$produk = mysqli_query($conn, "SELECT * FROM products");
?>

<h2>Dashboard Admin</h2>
<nav>
    <a href="dashboard.php">Produk</a> | 
    <a href="kelola_user.php">User</a> | 
    <a href="pesanan.php">Pesanan</a> | 
    <a href="../logout.php">Logout</a>
</nav>
<hr>

<h3>Daftar Produk</h3>
<a href="tambah_produk.php">[+] Tambah Produk</a>
<table border="1" cellpadding="8">
    <tr>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Rating</th>
        <th>Aksi</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($produk)): ?>
    <tr>
        <td><img src="../uploads/<?= $row['image']; ?>" width="50"></td>
        <td><?= htmlspecialchars($row['nama_produk']); ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= $row['rating']; ?>/5</td>
        <td>
            <a href="edit_produk.php?id=<?= $row['id']; ?>">Edit</a> | 
            <a href="hapus_produk.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus produk?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>