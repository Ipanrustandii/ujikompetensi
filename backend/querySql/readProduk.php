<?php
    include __DIR__ . '/../database.php';
    $sql = 'SELECT * FROM produk';
    $tampil = $conn->query($sql);

     // jumlah siswa
    // $sqlJumlahSiswa = "SELECT COUNT(*) AS jumlah_siswa FROM siswa";
    // $hasil=$conn->query($sqlJumlahSiswa);
    // $baris= $hasil->fetch_assoc();
    // $jumlahSiswa = $baris['jumlah_siswa'];

    //  $sqlJumlahAdmin = "SELECT COUNT(*) AS jumlah_admin FROM pengguna";
    // $hasil=$conn->query($sqlJumlahAdmin);
    // $baris= $hasil->fetch_assoc();
    // $jumlahAdmin = $baris['jumlah_admin'];

    
?>
