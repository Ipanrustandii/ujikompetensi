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
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            padding: 32px;
        }

        h1,
        h2 {
            color: #333;
            margin-bottom: 24px;
        }

        .table-produk {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .table-produk th,
        .table-produk td {
            border: 1px solid #e2e2e2;
            padding: 12px 16px;
            text-align: left;
        }

        .table-produk th {
            background: #e9ecef;
            color: #222;
        }

        .table-produk tr:nth-child(even) {
            background: #f4f6f8;
        }

        .btn {
            background: #266f86;
            color: #fff;
            border: none;
            padding: 8px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            transition: background 0.2s;
        }

        .btn:hover {
            background: #2E809C;
        }
    </style>
</head>

<body>
    <?php
    include '../../backend/querySql/readUser.php';
    ?>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary"><i class="bi bi-box-seam"></i> Data User</h2>
            <a href="index.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Tambah User</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm rounded">
                <thead class="table-light">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Status</th>
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
                            <td><?= $data['nama'] ?></td>
                            <td><?= htmlspecialchars(isset($data['username']) ? $data['username'] : '') ?></td>
                            <td>—</td>
                            <td><?= $data['status'] ?></td>
                            <td><a href="formEditUser.php?id_user=<?= $data['id_user'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                            <td><a href="../../backend/querySql/deleteUser.php?id_user=<?= $data['id_user'] ?>"><i class="bi bi-trash text-danger"></i></a></td>
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