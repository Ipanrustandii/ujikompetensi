<?php
// mengaktifkan session
session_start();
include __DIR__ . '/../database.php';

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username === '' || $password === '') {
    echo "<script>alert('Username dan password harus diisi!');window.location='login.php';</script>";
    exit;
}

// prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM user WHERE username = ? LIMIT 1");
if (!$stmt) {
    echo "<script>alert('Terjadi kesalahan pada server');window.location='login.php';</script>";
    exit;
}
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // normal case: hashed password matches
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['status'] = $user['status'];
        $_SESSION['user_id'] = $user['id_user'];

        if ($user['status'] == 'admin') {
            header("Location: ../../sidebarMenu.php");
            exit;
        } else {
            header("Location: ../../sidebarKasir.php");
            exit;
        }
    } else {
        // Fallback for legacy accounts where password might be stored in plaintext
        if (isset($user['password']) && $user['password'] === $password) {
            // Re-hash the plaintext password and update the database for security
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            if (isset($user['id_user'])) {
                $upd = $conn->prepare("UPDATE user SET password = ? WHERE id_user = ?");
                if ($upd) {
                    $upd->bind_param('si', $newHash, $user['id_user']);
                    $upd->execute();
                    $upd->close();
                }
            }

            // Proceed to log the user in
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['user_id'] = $user['id_user'];
            if ($user['status'] == 'admin') {
                header("Location: ../../sidebarMenu.php");
                exit;
            } else {
                header("Location: ../../sidebarKasir.php");
                exit;
            }
        }

        echo "<script>alert('Password salah!');window.location='../../index.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Username tidak ditemukan!');window.location='../../index.php';</script>";
    exit;
}