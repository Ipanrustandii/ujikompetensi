
<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

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
   
    <title>Tambah Produk</title>
  
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f7fbfd 0%, #f7fbfd 100%);
            padding: 2rem 0;
        }

        .form-card {
            max-width: 820px;
            margin: 0 auto;
            border-radius: 14px;
            padding: 1.25rem;
            box-shadow: 0 8px 30px rgba(46,128,156,0.06);
            background: rgba(255,255,255,0.98);
        }

        .page-title {
            color: #2E809C;
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 70%;
            transform: translateY(-50%);
            color: #2E809C;
            font-size: 1.05rem;
            pointer-events: none;
        }
        .input-icon2 {
            position: absolute;
            left: 12px;
            top: 55%;
            transform: translateY(-50%);
            color: #2E809C;
            font-size: 1.05rem;
            pointer-events: none;
        }

        .form-control, .form-select {
            border: 2px solid #2E809C;
            border-radius: 10px;
            padding-left: 2.6rem;
            height: calc(1.5em + 1rem);
            transition: box-shadow 0.25s ease, transform 0.12s ease;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 6px 18px rgba(46,128,156,0.12);
            transform: translateY(-2px);
            outline: none;
        }

        .btn-update {
            background: linear-gradient(90deg, #2E809C, #2aa0d1);
            border: none;
            color: #fff;
            padding: 0.55rem 1.8rem;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(46,128,156,0.16);
        }

        .btn-update:hover { transform: translateY(-3px); }

        .btn-kembali {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 0.55rem 1.8rem;
            border-radius: 10px;
            text-decoration: none;
            display: inline-block;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(220,53,69,0.16);
            transition: transform 0.12s ease;
        }

        .btn-kembali:hover {
            background-color: #bb2d3b;
            color: white;
            text-decoration: none;
            transform: translateY(-3px);
        }

        @media (max-width: 576px) {
            .input-icon { left: 10px; }
            .form-control { padding-left: 2.2rem; }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="page-title">Tambah Produk</h2>
        <p class="text-center text-muted mb-4">Tambahkan produk baru ke dalam sistem</p>

        <div class="card form-card">
            <form action="../../backend/querySql/addProduk.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3 position-relative">
                    <label for="namaProduk" class="form-label">Nama Produk</label>
                    <i class="bi bi-tag-fill input-icon"></i>
                    <input type="text" class="form-control" id="namaProduk" name="nama_produk" placeholder="Masukkan nama produk" required />
                </div>

                <div class="mb-3 position-relative">
                    <label for="harga" class="form-label">Harga</label>
                    <i class="bi bi-cash-stack input-icon"></i>
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Masukkan harga" min="1" required />
                </div>

                <div class="mb-3 position-relative">
                    <label for="stok" class="form-label">Stok</label>
                    <i class="bi bi-box-seam input-icon"></i>
                    <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan jumlah stok" min="1" required />
                </div>

                <div class="mb-3 position-relative">
                    <label for="gambar" class="form-label">Gambar Produk</label>
                    <i class="bi bi-image input-icon2"></i>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" />
                    <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                </div>

                <div class="text-center mt-4">
                    <a href="dataProduk.php" class="btn btn-kembali me-3"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
                    <button type="submit" class="btn btn-update" name="simpan" onclick="return confirm('Apakah Anda yakin ingin menyimpan data ini?')">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>