<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit("Akses Ditolak");
}

$id = $_GET['id'];

// Keamanan: Mencegah admin menghapus dirinya sendiri lewat URL manual
if ($id == $_SESSION['user_id']) {
    echo "<script>alert('Anda tidak bisa menghapus akun sendiri!'); window.location='kelola_user.php';</script>";
    exit();
}

$query = "DELETE FROM users WHERE id='$id'";
if (mysqli_query($conn, $query)) {
    header("Location: kelola_user.php");
}
?>