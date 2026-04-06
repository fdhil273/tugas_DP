<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
// Join tabel cart dan products untuk mengambil detail nama & harga produk
$query = "SELECT cart.id as cart_id, products.nama_produk, products.harga, products.image, cart.jumlah 
          FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $query);
?>

<h2>Keranjang Belanja Anda</h2>
<a href="dashboard.php">Kembali Belanja</a>
<hr>

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <tr>
        <th>Gambar</th>
        <th>Produk</th>
        <th>Harga Satuan</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
        <th>Aksi</th>
    </tr>
    <?php 
    $total_bayar = 0;
    while($row = mysqli_fetch_assoc($result)): 
        $subtotal = $row['harga'] * $row['jumlah'];
        $total_bayar += $subtotal;
    ?>
    <tr>
        <td><img src="../uploads/<?= $row['image']; ?>" width="50"></td>
        <td><?= htmlspecialchars($row['nama_produk']); ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
        <td><?= $row['jumlah']; ?></td>
        <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
        <td>
            <a href="hapus_keranjang.php?id=<?= $row['cart_id']; ?>" onclick="return confirm('Hapus dari keranjang?')">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
    <tr>
        <td colspan="4" align="right"><strong>Total yang harus dibayar:</strong></td>
        <td colspan="2"><strong>Rp <?= number_format($total_bayar, 0, ',', '.'); ?></strong></td>
    </tr>
</table>

<?php if ($total_bayar > 0): ?>
    <br>
    <a href="checkout.php" style="background: orange; padding: 10px; color: white; text-decoration: none;">Proses Checkout</a>
<?php endif; ?>