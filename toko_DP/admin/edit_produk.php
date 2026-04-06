<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id='$id'"));

if (isset($_POST['update'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga  = $_POST['harga'];
    $rating = $_POST['rating'];
    
    if ($_FILES['image']['name'] != "") {
        // Jika ganti gambar
        $filename = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $filename);
    } else {
        // Jika tidak ganti gambar
        $filename = $_POST['old_image'];
    }

    $query = "UPDATE products SET nama_produk='$nama', harga='$harga', rating='$rating', image='$filename' WHERE id='$id'";
    if (mysqli_query($conn, $query)) {
        header("Location: dashboard.php");
    }
}
?>

<h2>Edit Produk</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="old_image" value="<?= $data['image']; ?>">
    Nama: <input type="text" name="nama" value="<?= $data['nama_produk']; ?>"><br>
    Harga: <input type="number" name="harga" value="<?= $data['harga']; ?>"><br>
    Rating: <input type="number" name="rating" value="<?= $data['rating']; ?>"><br>
    Gambar Saat Ini: <br><img src="../uploads/<?= $data['image']; ?>" width="100"><br>
    Ganti Gambar: <input type="file" name="image"><br><br>
    <button type="submit" name="update">Update</button>
</form>