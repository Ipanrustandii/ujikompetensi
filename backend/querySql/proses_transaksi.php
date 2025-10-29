<?php
include __DIR__ . '/../database.php';
session_start();

header('Content-Type: application/json');

try {
    // Start transaction
    $conn->begin_transaction();

    $total = str_replace(['Rp', '.', ' '], '', $_POST['total']);
    $bayar = $_POST['bayar'];
    $id_user = $_SESSION['user_id'] ?? 1; // Sesuaikan dengan session user
    $items = json_decode($_POST['items'], true);

    // Insert transaksi
    $sql = "INSERT INTO transaksi (id_user, total, bayar, tanggal) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idd", $id_user, $total, $bayar);
    $stmt->execute();
    
    $id_transaksi = $conn->insert_id;

    // Insert items transaksi
    foreach ($items as $item) {
        // Insert ke transaksi_produk
        $sql = "INSERT INTO transaksi_produk (id_transaksi, id_produk, jumlah, subtotal) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $subtotal = $item['harga'] * $item['qty'];
        $stmt->bind_param("iiid", $id_transaksi, $item['id'], $item['qty'], $subtotal);
        $stmt->execute();

        // Update stok
        $sql = "UPDATE produk SET stok = stok - ? WHERE id_produk = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $item['qty'], $item['id']);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'transaction_id' => $id_transaksi,
        'message' => 'Transaksi berhasil'
    ]);

} catch (Exception $e) {
    // Rollback jika terjadi error
    $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => 'Transaksi gagal: ' . $e->getMessage()
    ]);
}