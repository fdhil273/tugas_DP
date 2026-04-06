<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];
$query = "DELETE FROM cart WHERE id='$id'";

if (mysqli_query($conn, $query)) {
    header("Location: keranjang.php");
}
?>