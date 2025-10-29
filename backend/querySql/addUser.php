<?php
include __DIR__ . "/../database.php";

// Simple helper to go back to the add form
$backToForm = '../../konten/tambahKasir/index.php';

$nama     = isset($_POST['nama']) ? trim($_POST['nama']) : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$role     = isset($_POST['status']) ? trim($_POST['status']) : '';

// Validasi data (email not used)
if ($nama === '' || $username === '' || $password === '' || $role === '') {
    echo "<script>alert('Semua kolom wajib diisi!');window.location='" . $backToForm . "';</script>";
    exit;
}

// Cek apakah username sudah terdaftar (prepared)
$stmt = $conn->prepare("SELECT id_user FROM user WHERE username = ? LIMIT 1");
if (!$stmt) {
    echo "<script>alert('Kesalahan server: gagal mempersiapkan query.');window.location='" . $backToForm . "';</script>";
    exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();
if ($res && $res->num_rows > 0) {
    echo "<script>alert('Username sudah digunakan!');window.location='" . $backToForm . "';</script>";
    exit;
}
$stmt->close();

// Enkripsi password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user using prepared statement
// Note: remove 'email' column from INSERT because DB may not have it
$ins = $conn->prepare("INSERT INTO user (nama, username, password, status) VALUES (?, ?, ?, ?)");
if (!$ins) {
    echo "<script>alert('Kesalahan server: gagal mempersiapkan insert. " . addslashes($conn->error) . "');window.location='" . $backToForm . "';</script>";
    exit;
}
$ins->bind_param('ssss', $nama, $username, $hashedPassword, $role);
if ($ins->execute()) {
    echo "<script>alert('User baru berhasil ditambahkan!');window.location='../../konten/tambahKasir/dataUser.php';</script>";
    $ins->close();
    exit;
} else {
    $err = addslashes($ins->error);
    echo "<script>alert('Gagal menambah user: " . $err . "');window.location='" . $backToForm . "';</script>";
    $ins->close();
    exit;
}
