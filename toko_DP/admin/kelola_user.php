<?php
session_start();
include '../config/koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY role ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola User - Admin</title>
</head>
<body>
    <h2>Daftar Pengguna Sistem</h2>
    <nav>
        <a href="dashboard.php">Kembali ke Produk</a> | 
        <a href="../logout.php">Logout</a>
    </nav>
    <hr>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($users)): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['username']); ?></td>
            <td><?= htmlspecialchars($row['email']); ?></td>
            <td><strong><?= strtoupper($row['role']); ?></strong></td>
            <td>
                <?php if($row['id'] != $_SESSION['user_id']): ?>
                    <a href="edit_user.php?id=<?= $row['id']; ?>">Ubah Role</a> | 
                    <a href="hapus_user.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus user ini?')">Hapus</a>
                <?php else: ?>
                    <em>Akun Anda</em>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>