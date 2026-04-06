<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['tambah'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga  = $_POST['harga'];
    $rating = $_POST['rating'];
    
    // Logika Upload Gambar
    $filename = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder   = "../uploads/" . $filename;

    if (move_uploaded_file($tmp_name, $folder)) {
        $query = "INSERT INTO products (nama_produk, harga, rating, image) VALUES ('$nama', '$harga', '$rating', '$filename')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Produk berhasil ditambah!'); window.location='dashboard.php';</script>";
        }
    } else {
        echo "Gagal upload gambar!";
    }
}
?>

<h2>Tambah Produk Baru</h2>
<form method="POST" enctype="multipart/form-data">
    Nama Produk: <input type="text" name="nama" required><br><br>
    Harga: <input type="number" name="harga" required><br><br>
    Rating (1-5): <input type="number" name="rating" min="1" max="5" required><br><br>
    Gambar: <input type="file" name="image" required><br><br>
    <button type="submit" name="tambah">Simpan Produk</button>
    <a href="dashboard.php">Kembali</a>
</form>