<?php
include __DIR__ . '/../database.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    // Cek apakah ada file gambar diupload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['name']) {
        $nama_file = $_FILES['gambar']['name'];
        $temp_file = $_FILES['gambar']['tmp_name'];
        $upload_dir = '../../image/';
        move_uploaded_file($temp_file, $upload_dir . $nama_file);
    $sqlUpdateProduk = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok', file_gambar='$nama_file' WHERE id_produk=$id";
    } else {
        $sqlUpdateProduk = "UPDATE produk SET nama_produk='$nama_produk', harga='$harga', stok='$stok' WHERE id_produk=$id";
    }

    $hasil = $conn->query($sqlUpdateProduk);

    if ($hasil) {
        header("location: ../../konten/DaftarMenu/dataProduk.php");
    } else {
        echo 'Gagal Update Data Siswa';
    }
}
