<body>
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
        
        <title>Edit Produk</title>
        <style>
            body {
                background-color: #f5f5f5;
                font-family: Arial, sans-serif;
            }
            
            .container {
                padding: 20px;
            }
            
            .card {
                background-color: #2E809C !important;
                border: none !important;
                border-radius: 8px !important;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            
            .card-body {
                padding: 2rem !important;
            }
            
            h3 {
                color: white;
                text-align: center;
                font-size: 24px;
                margin-top: 0;
                margin-bottom: 30px;
            }
            
            .col-form-label {
                color: white !important;
                font-weight: normal;
                padding-bottom: 5px;
            }
            
            .form-control {
                background-color: white !important;
                border: none !important;
                padding: 10px !important;
                height: auto !important;
                margin-bottom: 15px;
            }
            
            .form-control:focus {
                box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.25) !important;
            }
            
            .d-flex.justify-content-center {
                display: flex !important;
                justify-content: space-between !important;
                margin-top: 30px;
            }
            
            .btn-primary {
                background-color: white !important;
                color: #2E809C !important;
                border: none !important;
                padding: 8px 25px !important;
                font-weight: normal !important;
            }
            
            .btn-primary:hover {
                background-color: #f0f0f0 !important;
            }
            
            .btn-kembali {
                background-color: #ff0000;
                color: white;
                border: none;
                padding: 8px 25px;
                border-radius: 4px;
                text-decoration: none;
                display: inline-block;
            }
            
            .btn-kembali:hover {
                background-color: #cc0000;
                color: white;
                text-decoration: none;
            }
            
            .row.align-items-center {
                margin-bottom: 15px;
            }
            
            .col-sm-8 {
                padding-left: 0;
            }
        </style>
    </head>

    <body>
        <?php
        include __DIR__ . '/../../backend/database.php';
        $id = $_GET['id_produk'];
        $sql = "SELECT * FROM produk WHERE id_produk=$id";
        $tampil = $conn->query($sql);
        $data = mysqli_fetch_assoc($tampil);
        ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8 d-flex justify-content-center">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3>Edit Menu</h3>
                            <div class="w-100">
                                <form action="../../backend/querySql/updateProduk.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= $data['id_produk'] ?>">
                                    <div class="mb-3 row align-items-center">
                                        <label for="namaProduk" class="col-sm-3 col-form-label">Nama Produk</label>
                                        <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="namaProduk"
                                                name="nama_produk"
                                                value="<?= $data['nama_produk'] ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row align-items-center">
                                        <label for="harga" class="col-sm-3 col-form-label">Harga</label>
                                        <div class="col-sm-8">
                                            <input type="decimal" class="form-control" id="harga" name="harga" value="<?= $data['harga'] ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row align-items-center">
                                        <label for="stok" class="col-sm-3 col-form-label">Stok</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="stok" name="stok" value="<?= $data['stok'] ?>" />
                                        </div>
                                    </div>
                                    <div class="mb-3 row align-items-center">
                                        <label for="gambar" class="col-sm-3 col-form-label">Gambar</label>
                                        <div class="col-sm-8">
                                            <input type="file" class="form-control" id="gambar" name="gambar" />
                            
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-center">
                                        <a href="dataProduk.php" class="btn-kembali">Kembali</a>
                                        <button type="submit" class="btn btn-primary" name="update">
                                            Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
</body>

</html>