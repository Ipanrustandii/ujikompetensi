


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
  <link rel="stylesheet" href="theme.css" />
  <title>Document</title>
  <style>
    /* Layout only — colors are provided by theme.css (primary: var(--primary-blue)) */
    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      /* background handled by theme.css */
    }

    .sidebar a {
      display: flex;
      align-items: center;
      text-decoration: none;
      padding: 10px 20px;
      color: var(--text-light);
      font-size: 15px;
    }

    .sidebar a:hover {
      background-color: rgba(46, 128, 156, 0.12);
      color: var(--text-dark);
      transform: translateX(5px);
    }

    .sidebar i {
      margin-right: 10px;
      font-size: 18px;
      color: var(--text-light);
    }

    .content {
      padding-top: 20px;
      padding: 30px;
      margin-left: 250px;
    }

    .content iframe {
      width: 100%;
      height: 100vh;
      border: none;
      overflow: hidden;
      background: transparent;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <h4 class="text-center text-white py-3">Kasir</h4>
    
    <a href="kontenKasir/produk.php" target="kontenFrame">
      <i class="bi bi-house"></i> Daftar Menu
    </a>
   
  

   
    <a href="kontenKasir/Laporan/laporan.php" target="kontenFrame">
      <i class="bi bi-person-badge"></i> Laporan
    </a>
    <a href="backend/querySql/logout.php">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>

  </div>

  <div class="content">
    <iframe src="KontenKasir/produk.php" name="kontenFrame"></iframe>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>