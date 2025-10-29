<?php
include __DIR__ . '/../database.php';

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$password_baru = isset($_POST['password_baru']) ? trim($_POST['password_baru']) : '';

if (!$id || $nama === '' || $username === '' || $status === '') {
    echo "<script>alert('Lengkapi data!');window.location='../../konten/tambahKasir/dataUser.php';</script>";
    exit;
}

// Cek apakah username digunakan oleh user lain
$cek = $conn->prepare("SELECT id_user FROM user WHERE username = ? AND id_user != ? LIMIT 1");
$cek->bind_param('si', $username, $id);
$cek->execute();
$res = $cek->get_result();
if ($res && $res->num_rows > 0) {
    echo "<script>alert('Username sudah digunakan oleh user lain');window.location='../../konten/tambahKasir/dataUser.php';</script>";
    exit;
}

// Update nama, username, status
$upd = $conn->prepare("UPDATE user SET nama = ?, username = ?, status = ? WHERE id_user = ?");
$upd->bind_param('sssi', $nama, $username, $status, $id);
$ok = $upd->execute();

// Jika ada password baru, update juga
if ($ok && $password_baru !== '') {
    $hash = password_hash($password_baru, PASSWORD_DEFAULT);
    $upd2 = $conn->prepare("UPDATE user SET password = ? WHERE id_user = ?");
    $upd2->bind_param('si', $hash, $id);
    $upd2->execute();
}

if ($ok) {
    echo "<script>alert('User berhasil diupdate!');window.location='../../konten/tambahKasir/dataUser.php';</script>";
} else {
    echo "<script>alert('Gagal update user: " . $conn->error . "');window.location='../../konten/tambahKasir/dataUser.php';</script>";
}