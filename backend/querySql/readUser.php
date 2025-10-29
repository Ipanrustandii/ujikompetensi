<?php
    include __DIR__ . '/../database.php';
    $sql = 'SELECT * FROM user';
    $tampil = $conn->query($sql);
?>