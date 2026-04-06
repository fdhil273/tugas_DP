<?php
session_start();
include '../config/koneksi.php';

$user_id = $_SESSION['user_id'];
$pesanan = mysqli_query($conn, "SELECT * FROM orders WHERE user_id = '$user_id' ORDER BY tanggal_pesan DESC");
?>

<h2>Riwayat Pesanan Anda</h2>
<table border="1" cellpadding="10" width="100%">
    <tr>
        <th>Tanggal</th>
        <th>Total Bayar</th>
        <th>Status</th>
    </tr>
    <?php while($row = mysqli_fetch_assoc($pesanan)): ?>
    <tr>
        <td><?= $row['tanggal_pesan']; ?></td>
        <td>Rp <?= number_format($row['total_bayar'], 0, ',', '.'); ?></td>
        <td><?= ucfirst($row['status']); ?></td>
    </tr>
    <?php endwhile; ?>
</table>
<br>
<a href="dashboard.php">Kembali ke Beranda</a>