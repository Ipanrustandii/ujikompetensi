<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../backend/database.php';

// Ambil filter tanggal
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

// Hitung total pendapatan untuk kasir ini
$sqlTotal = "SELECT COALESCE(SUM(total), 0) AS total_pendapatan FROM transaksi WHERE id_user = ?";
$params = [$_SESSION['user_id']];
if ($from && $to) {
    $sqlTotal .= " AND DATE(tanggal) BETWEEN ? AND ?";
    $params[] = $from;
    $params[] = $to;
}
$stmt = $conn->prepare($sqlTotal);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total_pendapatan'];

// Ambil daftar transaksi untuk kasir ini
$sql = "SELECT t.*, u.username
        FROM transaksi t
        LEFT JOIN user u ON t.id_user = u.id_user
        WHERE t.id_user = ?";
$params = [$_SESSION['user_id']];
if ($from && $to) {
    $sql .= " AND DATE(t.tanggal) BETWEEN ? AND ?";
    $params[] = $from;
    $params[] = $to;
}
$sql .= " ORDER BY t.tanggal DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$res = $stmt->get_result();
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Transaksi Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2E809C;
            --primary-hover: #266f86;
            --grey-primary: #2c3338;
            --grey-secondary: #3f474e;
            --grey-light: #e9ecef;
            --grey-hover: #4a545c;
        }

        body {
            background-color: var(--grey-light);
            color: #123238;
        }

        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card-header {
            border-bottom: none;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-success {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-success:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-warning {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-warning:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .alert-success {
            background-color: rgba(46, 128, 156, 0.1);
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .table {
            color: var(--grey-primary);
        }

        .table thead {
            background-color: rgba(46, 128, 156, 0.06);
            border-bottom: 2px solid rgba(46, 128, 156, 0.12);
        }

        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Icons */
        .bi {
            color: var(--primary-color);
        }

        /* Text colors */
        .text-primary {
            color: var(--primary-color) !important;
        }

        @media print {

            button,
            form,
            .sidebar,
            .aksi {
                display: none !important;
            }

            body {
                background: #fff;
            }

            table {
                font-size: 13px;
            }
        }
    </style>
</head>

<body class="bg-light">
    <div style="margin-left:20px; padding:20px">
        <h4 class="mb-3">📊 Laporan Transaksi Saya</h4>

        <!-- Filter tanggal -->
        <form class="row g-2 mb-4" method="GET">
            <div class="col-md-3">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="<?= htmlspecialchars($from) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="<?= htmlspecialchars($to) ?>">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary w-100">Tampilkan</button>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="button" class="btn btn-success w-100" onclick="window.print()">🖨️ Cetak Laporan</button>
            </div>
        </form>

        <!-- Total pendapatan -->
        <div class="alert alert-success">
            <strong>Total Pendapatan:</strong> Rp <?= number_format($total, 0, ',', '.') ?>
        </div>

        <!-- Tabel daftar transaksi -->
        <div class="card p-3 shadow-sm">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Bayar</th>
                            <th>Kembalian</th>
                            <th class="aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($r = $res->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td>#<?= str_pad($r['id_transaksi'], 6, '0', STR_PAD_LEFT) ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($r['tanggal'])) ?></td>
                                <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($r['bayar'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($r['bayar'] - $r['total'], 0, ',', '.') ?></td>
                                <td class="aksi text-center">
                                    <a href="../Struk/struk.php?id=<?= $r['id_transaksi'] ?>"
                                        class="btn btn-sm btn-warning" target="_blank">🧾 Cetak Nota</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
