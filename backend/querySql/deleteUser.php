<?php
    include __DIR__ . '/../database.php';

    $id = $_GET['id_user'];
    $sqlHapusUser = "DELETE FROM user WHERE id_user = $id";
    $hasil = $conn->query($sqlHapusUser);

    if ($hasil) {
        header("location: ../../konten/tambahKasir/dataUser.php");
    }

?>