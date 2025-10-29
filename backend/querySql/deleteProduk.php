<?php
    include __DIR__ . '/../database.php';

    $id = $_GET['id_produk'];
    $sqlHapusProduk = "DELETE FROM produk WHERE id_produk = $id";
    $hasil = $conn->query($sqlHapusProduk);

    if ($hasil) {
        header("location: ../../konten/DaftarMenu/dataProduk.php");
    }

?>