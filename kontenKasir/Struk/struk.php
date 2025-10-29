<?php
include __DIR__ . '/../../backend/database.php';

if (!isset($_GET['id'])) {
    die('ID transaksi tidak ditemukan');
}

$id_transaksi = (int)$_GET['id'];

// Ambil data transaksi
$sql_transaksi = "SELECT t.*, u.username FROM transaksi t LEFT JOIN user u ON t.id_user = u.id_user WHERE t.id_transaksi = ?";
$stmt = $conn->prepare($sql_transaksi);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$transaksi = $stmt->get_result()->fetch_assoc();

if (!$transaksi) {
    die('Transaksi tidak ditemukan');
}

// Ambil detail transaksi
$sql_detail = "SELECT tp.*, p.nama_produk, p.harga FROM transaksi_produk tp JOIN produk p ON tp.id_produk = p.id_produk WHERE tp.id_transaksi = ?";
$stmt = $conn->prepare($sql_detail);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$detail = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 10px;
            max-width: 300px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
        }

        .info {
            margin-bottom: 10px;
        }

        .info div {
            margin-bottom: 3px;
        }

        .items {
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .item-name {
            flex: 1;
            margin-right: 10px;
        }

        .item-qty {
            width: 30px;
            text-align: center;
        }

        .item-price {
            width: 60px;
            text-align: right;
        }

        .total {
            border-top: 1px solid #000;
            padding-top: 5px;
            margin-bottom: 10px;
        }

        .total div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .footer {
            text-align: center;
            border-top: 1px dashed #000;
            padding-top: 10px;
            font-size: 10px;
        }

        @media print {
            body {
                max-width: none;
                margin: 0;
                padding: 5px;
            }

            .no-print {
                display: none;
            }
        }

        .no-print {
            text-align: center;
            margin-top: 20px;
        }

        .no-print button {
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .no-print button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>TOKO MAKANAN</h2>
        <p>Jl. Contoh No. 123<br>Kota, Provinsi 12345</p>
        <p>Telp: (021) 12345678</p>
    </div>

    <div class="info">
        <div><strong>No. Transaksi:</strong> #<?= str_pad($transaksi['id_transaksi'], 6, '0', STR_PAD_LEFT) ?></div>
        <div><strong>Tanggal:</strong> <?= date('d/m/Y H:i', strtotime($transaksi['tanggal'])) ?></div>
        <div><strong>Kasir:</strong> <?= htmlspecialchars($transaksi['username'] ?? 'kasir') ?></div>
    </div>

    <div class="items">
        <?php foreach ($detail as $item): ?>
        <div class="item">
            <div class="item-name"><?= htmlspecialchars($item['nama_produk']) ?></div>
            <div class="item-qty"><?= $item['jumlah'] ?>x</div>
            <div class="item-price">Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="total">
        <div>
            <strong>Total:</strong>
            <strong>Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></strong>
        </div>
        <div>
            <span>Bayar:</span>
            <span>Rp <?= number_format($transaksi['bayar'], 0, ',', '.') ?></span>
        </div>
        <div>
            <span>Kembalian:</span>
            <span>Rp <?= number_format($transaksi['bayar'] - $transaksi['total'], 0, ',', '.') ?></span>
        </div>
    </div>

    <div class="footer">
        <p>Terima Kasih Atas Kunjungan Anda</p>
        <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
    </div>

    <div class="no-print">
        <button onclick="window.print()">Cetak Struk</button>
        <button onclick="window.close()">Tutup</button>
    </div>

    <script>
        // Auto print jika dibuka dari popup
        if (window.opener) {
            window.print();
        }
    </script>
</body>
</html>
