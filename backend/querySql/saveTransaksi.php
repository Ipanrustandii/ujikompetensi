<?php
header('Content-Type: application/json');
include '../database.php';

try {
    // Get cart data from POST
    $cartData = json_decode(file_get_contents('php://input'), true);
    if (!$cartData || empty($cartData['items'])) {
        throw new Exception('Tidak ada item dalam keranjang');
    }

    // Start transaction
    $conn->begin_transaction();

    // Insert main transaction record
    $total = 0;
    foreach ($cartData['items'] as $item) {
        $total += floatval($item['harga']) * intval($item['qty']);
    }

    $sql = "INSERT INTO transaksi (total_bayar, status) VALUES (?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("d", $total);
    $stmt->execute();
    $idTransaksi = $conn->insert_id;

    // Insert transaction details
    $sql = "INSERT INTO transaksi_detail (id_transaksi, id_produk, qty, harga, subtotal) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    foreach ($cartData['items'] as $item) {
        $id = intval($item['id']);
        $qty = intval($item['qty']);
        $harga = floatval($item['harga']);
        $subtotal = $harga * $qty;
        
        $stmt->bind_param("iiidd", $idTransaksi, $id, $qty, $harga, $subtotal);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Transaksi berhasil disimpan',
        'id_transaksi' => $idTransaksi
    ]);

} catch (Exception $e) {
    // Rollback on error
    if ($conn) $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

// Close connection
$conn->close();