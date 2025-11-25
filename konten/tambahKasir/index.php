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
    
    <title>Tambah Admin/Kasir</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f7fbfd 0%, #f7fbfd 100%);
            padding: 2rem 0;
        }

        .page-title {
            color: #2E809C;
            font-size: 2.5rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 4px rgba(46, 128, 156, 0.1);
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            border: none;
            box-shadow: 0 8px 30px rgba(46, 128, 156, 0.15);
            backdrop-filter: blur(10px);
            padding: 2rem;
        }

        .card-title h3 {
            color: #2E809C;
            font-weight: bold;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control, .form-select {
            border: 2px solid #2E809C;
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(46, 128, 156, 0.25);
            transform: translateY(-2px);
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #2E809C;
            font-size: 1.2rem;
            pointer-events: none;
        }

        .btn-primary {
            background: linear-gradient(45deg, #2E809C, #3498db);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(46, 128, 156, 0.3);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 128, 156, 0.4);
        }

        .btn-primary:active {
            transform: translateY(1px);
        }

        hr {
            border-color: #2E809C;
            opacity: 0.1;
            margin: 2rem 0;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card {
            animation: fadeIn 0.6s ease-out;
        }
    </style>
</head>

    <body>
        <div class="container">
            <h1 class="page-title">Sistem Administrasi</h1>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card">
                        <div class="card-title text-center">
                            <h3>Tambah Admin / Kasir</h3>
                        </div>
                        <hr>
                        <form action="../../backend/querySql/addUser.php" method="POST">
                            <div class="form-group">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <div class="position-relative">
                                    <i class="bi bi-person-circle input-icon"></i>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="nama"
                                        name="nama"
                                        required
                                        placeholder="Masukkan nama lengkap" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="username" class="form-label">Username</label>
                                <div class="position-relative">
                                    <i class="bi bi-person-badge input-icon"></i>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="username" 
                                        name="username" 
                                        required 
                                        placeholder="Masukkan username" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="position-relative">
                                    <i class="bi bi-key-fill input-icon"></i>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="password"
                                        name="password" 
                                        required
                                        placeholder="Masukkan password" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status" class="form-label">Status</label>
                                <div class="position-relative">
                                    <i class="bi bi-person-gear input-icon"></i>
                                    <select
                                        class="form-select"
                                        id="status"
                                        name="status" 
                                        required>
                                        <option value="" disabled selected>Pilih Status Pengguna</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Kasir">Kasir</option>
                                    </select>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary" name="simpan">
                                    <i class="bi bi-save me-2"></i>Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>