<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit("Akses Ditolak");
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id'"));

if (isset($_POST['update_role'])) {
    $new_role = $_POST['role'];
    $query = "UPDATE users SET role='$new_role' WHERE id='$id'";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Role berhasil diperbarui!'); window.location='kelola_user.php';</script>";
    }
}
?>

<h2>Ubah Role User: <?= htmlspecialchars($data['username']); ?></h2>
<form method="POST">
    <label>Pilih Role:</label>
    <select name="role">
        <option value="user" <?= ($data['role'] == 'user') ? 'selected' : ''; ?>>User</option>
        <option value="admin" <?= ($data['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
    </select>
    <br><br>
    <button type="submit" name="update_role">Update Role</button>
    <a href="kelola_user.php">Batal</a>
</form>