<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    
    <title>Daftar Menu</title>
</head>

    <style>
        :root{
            --primary: #2E809C;
            --primary-dark: #266f86;
            --muted: #6c757d;
            --bg: #f6fbfc;
        }

        /* Page background & base text */
        body{
            background-color: var(--bg);
            color: #123238;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        /* Headings and icons using dominant color */
        h2.text-primary, .text-primary{
            color: var(--primary) !important;
        }
        .bi{ color: var(--primary); }

        /* Buttons: prefer primary color instead of default bootstrap green */
        .btn-success{
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
        }
        .btn-success:hover, .btn-success:focus{
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
            box-shadow: 0 0 0 .2rem rgba(46,128,156,0.15);
        }

        /* Outline primary buttons */
        .btn-outline-primary{
            color: var(--primary) !important;
            border-color: var(--primary) !important;
        }
        .btn-outline-primary:hover{
            background-color: var(--primary) !important;
            color: #fff !important;
        }

        /* Table styling */
        .table thead{
            background-color: rgba(46,128,156,0.06);
            border-bottom: 2px solid rgba(46,128,156,0.12);
        }
        .table-hover tbody tr:hover{
            background-color: rgba(46,128,156,0.03);
        }
        .table td, .table th{
            vertical-align: middle;
        }

        /* Image thumbnails in table */
        .table img{
            display: block;
            max-width: 100px;
            height: auto;
            border-radius: 6px;
            object-fit: cover;
        }

        /* Container card look */
        .container.py-4{
            padding-top: 1.5rem !important;
            padding-bottom: 1.5rem !important;
        }

        /* Small utility tweaks */
        .fw-semibold{ font-weight:600; }
        .shadow-sm{ box-shadow: 0 1px 3px rgba(16,24,32,0.06) !important; }

        /* Responsive tweaks */
        @media (max-width: 576px){
            .table img{ max-width: 72px; }
            h2{ font-size: 1.125rem; }
        }
    </style>

</head>

<body>
    <?php
    include '../../backend/querySql/readProduk.php';
    ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary"><i class="bi bi-box-seam"></i> Daftar Menu</h2>
            <a href="index.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah Menu</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm rounded">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Gambar</th>
                        <th scope="col" colspan="2" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    while ($data = mysqli_fetch_assoc($tampil)) {
                        $no++;
                    ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td class="fw-semibold text-dark"><?= htmlspecialchars($data['nama_produk']) ?></td>
                            <td>Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                            <td><?= $data['stok'] ?></td>
                            <td><img src="../../backend/uploads/<?= $data['file_gambar'] ?>"alt="GAMBAR TIDAK DITEMUKAN"  width="100" ></td>
                            <td class="text-center">
                                <a href="formEditProduk.php?id_produk=<?= $data['id_produk'] ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="../../backend/querySql/deleteProduk.php?id_produk=<?= $data['id_produk'] ?>" class="btn btn-sm btn-outline-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>