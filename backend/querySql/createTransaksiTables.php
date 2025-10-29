<?php
// Create tables if not exists
$sql_create_tables = "
CREATE TABLE IF NOT EXISTS transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    total DECIMAL(10,2),
    bayar DECIMAL(10,2),
    tanggal DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS transaksi_produk (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_produk INT,
    jumlah INT,
    subtotal DECIMAL(10,2),
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi),
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
);
";

// Connect using the existing connection from database.php
include '../database.php';

// Execute the CREATE TABLE statements
if ($conn->multi_query($sql_create_tables)) {
    do {
        // Consume results to allow next query
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}