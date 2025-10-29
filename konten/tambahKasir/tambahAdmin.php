

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
    <link rel="stylesheet" href="../../theme.css" />
    <title>Document</title>
</head>

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
        <title>Document</title>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-8 d-flex justify-content-center">
                    <div class="card shadow-sm col-12">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h3>TAMBAH ADMIN</h3>
                            </div>
                            <hr>
                            <div class="w-100">
                                <form action="backend/querySql/prosesAddAdmin.php" method="POST">
                                    <div class="mb-2 mt-5 row align-items-center">
                                        <label for="namaAdmin" class="col-4 col-form-label"><i class="bi bi-person-circle"></i> Nama</label>
                                        <div class="col-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="namaAdmin"
                                                name="namaAdmin" />
                                        </div>
                                    </div>
                                    <div class="mb-2 row align-items-4center">
                                        <label for="username" class="col-4 col-form-label"><i class="bi bi-person-badge"></i> Username</label>
                                        <div class="col-sm-8">
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="username"
                                                name="username" />
                                        </div>
                                    </div>
                                    <div class="mb-2 row align-items-center">
                                        <label for="password" class="col-4 col-form-label"><i class="bi bi-key-fill"></i> Password</label>
                                        <div class="col-sm-8">
                                            <input
                                                type="password"
                                                class="form-control"
                                                id="password"
                                                name="password" />
                                        </div>
                                    </div>
                                    

                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary alig" name="simpan">
                                            SIMPAN
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