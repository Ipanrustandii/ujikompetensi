<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../../theme.css" />
    <title>Edit User</title>
    <style>
        /* Local page styles that rely on theme variables (primary: var(--primary-blue)) */
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--light-bg) 0%, #f7fbfd 100%);
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
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 70%;
            transform: translateY(-50%);
            color: var(--primary-blue);
            font-size: 1.05rem;
            pointer-events: none;
        }

        .form-control, .form-select {
            border: 2px solid var(--primary-blue);
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
            background: linear-gradient(90deg, var(--primary-blue), #2aa0d1);
            border: none;
            color: #fff;
            padding: 0.55rem 1.8rem;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(46,128,156,0.16);
        }

        .btn-update:hover { transform: translateY(-3px); }

        @media (max-width: 576px) {
            .input-icon { left: 10px; }
            .form-control { padding-left: 2.2rem; }
        }
    </style>
</head>

<body>
    <?php
    include __DIR__ . '/../../backend/database.php';
    $id = isset($_GET['id_user']) ? intval($_GET['id_user']) : 0;
    $sql = "SELECT * FROM user WHERE id_user=$id";
    $tampil = $conn->query($sql);
    $data = mysqli_fetch_assoc($tampil);
    ?>

    <div class="container">
        <h2 class="page-title">Edit Pengguna</h2>
        <p class="text-center text-muted mb-4">Perbarui informasi akun Admin/Kasir</p>

        <div class="card form-card">
            <form action="../../backend/querySql/updateUser.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($data['id_user']) ?>">

                <div class="mb-3 position-relative">
                    <label for="nama" class="form-label">Nama</label>
                    <i class="bi bi-person-circle input-icon"></i>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required />
                </div>

                <div class="mb-3 position-relative">
                    <label for="username" class="form-label">Username</label>
                    <i class="bi bi-person-badge input-icon"></i>
                    <input type="text" class="form-control" id="username" name="username" value="<?= isset($data['username']) ? htmlspecialchars($data['username']) : '' ?>" required />
                </div>

                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password Baru (opsional)</label>
                    <i class="bi bi-key-fill input-icon"></i>
                    <input type="password" class="form-control" id="password" name="password_baru" placeholder="Kosongkan jika tidak ingin merubah" />
                </div>

                <div class="mb-3 position-relative">
                    <label for="status" class="form-label">Status</label>
                    <i class="bi bi-person-gear input-icon"></i>
                    <select class="form-select" id="status" name="status" required>
                        <option value="Admin" <?= ($data['status']==='Admin')? 'selected' : '' ?>>Admin</option>
                        <option value="Kasir" <?= ($data['status']==='Kasir')? 'selected' : '' ?>>Kasir</option>
                    </select>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-update" name="update"><i class="bi bi-pencil-square me-2"></i>Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>