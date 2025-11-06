<?php
include '../../backend/database.php';

// Ambil filter tanggal
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

// Hitung total pendapatan semua transaksi
$sqlTotal = "SELECT COALESCE(SUM(total), 0) AS total_pendapatan FROM transaksi";
$params = [];
if ($from && $to) {
    $sqlTotal .= " WHERE DATE(tanggal) BETWEEN ? AND ?";
    $params = [$from, $to];
}
$stmt = $conn->prepare($sqlTotal);
if ($params) {
    $stmt->bind_param('ss', ...$params);
}
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total_pendapatan'];

// Ambil daftar semua transaksi
$sql = "SELECT t.*, u.username
        FROM transaksi t
        LEFT JOIN user u ON t.id_user = u.id_user";
$params = [];
if ($from && $to) {
    $sql .= " WHERE DATE(t.tanggal) BETWEEN ? AND ?";
    $params = [$from, $to];
}
$sql .= " ORDER BY t.tanggal DESC";
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param('ss', ...$params);
}
$stmt->execute();
$res = $stmt->get_result();
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Transaksi Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{
            --primary: #2E809C;
            --primary-dark: #266f86;
            --bg: #f6fbfc;
            --muted: #6c757d;
        }

        /* Base layout */
        body.bg-light{
            background-color: var(--bg) !important;
            color: #123238;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        h4 { color: var(--primary); }

        /* Buttons */
        .btn-primary{
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
        }
        .btn-primary:hover, .btn-primary:focus{
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }
        .btn-success{
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
        }

        /* Alerts */
        .alert-success{
            background-color: rgba(46,128,156,0.12);
            border-color: rgba(46,128,156,0.18);
            color: #0b3740;
        }

        /* Card and table */
        .card{ border-radius:8px; }
        .table thead{
            background-color: rgba(46,128,156,0.08);
        }
        .table-striped > tbody > tr:nth-of-type(odd){
            background-color: rgba(46,128,156,0.02);
        }
        .aksi .btn-warning{
            background-color: #f6c84c; /* keep contrast for print/cetak nota */
            border-color: #f6c84c;
            color: #1b1b1b;
        }

        /* Responsive tweaks */
        @media (max-width: 768px){
            div[style*="margin-left:260px"]{ margin-left:0 !important; padding:12px !important; }
            .table thead th{ font-size: 13px; }
        }

        /* Print-specific rules (kept) */
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
    <div style="margin-left:30px; padding:20px">
        <h4 class="mb-3">📊 Laporan Transaksi Semua Kasir</h4>

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
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Kode Transaksi</th>
                            <th>Kasir</th>
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
                                <td><?= htmlspecialchars($r['username']) ?></td>
                                <td><?= date('d-m-Y H:i', strtotime($r['tanggal'])) ?></td>
                                <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($r['bayar'], 0, ',', '.') ?></td>
                                <td>Rp <?= number_format($r['bayar'] - $r['total'], 0, ',', '.') ?></td>
                                <td class="aksi text-center">
                                    <a href="../../kontenKasir/Struk/struk.php?id=<?= $r['id_transaksi'] ?>"
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
