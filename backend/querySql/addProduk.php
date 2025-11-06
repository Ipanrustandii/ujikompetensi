<?php
    include __DIR__ . "/../database.php";

    if (isset($_POST['simpan'])) {
        $nama_produk = $_POST['nama_produk'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        $nama_file = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['name']) {
            $nama_file = $_FILES['gambar']['name'];
            $temp_file = $_FILES['gambar']['tmp_name'];
            $upload_dir = '../../image/';
            if (move_uploaded_file($temp_file, $upload_dir . $nama_file)) {
                // Gambar berhasil diupload
            } else {
                echo 'GAGAL MENGUPLOAD GAMBAR!';
            }
        }

        $sqlAddProduk = "INSERT INTO produk (nama_produk, harga, stok, file_gambar) VALUES ('$nama_produk', '$harga', '$stok', '$nama_file')";
        $hasil = $conn->query($sqlAddProduk);

        if ($hasil) {
            header("Location: ../../konten/DaftarMenu/dataProduk.php");
        } else {
            echo 'data gagal disimpan';
        }
    }

    