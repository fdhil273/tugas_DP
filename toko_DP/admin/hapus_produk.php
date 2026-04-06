<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    exit("Akses ditolak");
}

$id = $_GET['id'];

// (Opsional) Hapus file gambar fisik dari folder uploads
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM products WHERE id='$id'"));
unlink("../uploads/" . $data['image']);

$query = "DELETE FROM products WHERE id='$id'";
if (mysqli_query($conn, $query)) {
    header("Location: dashboard.php");
}
?>