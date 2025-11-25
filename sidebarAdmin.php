


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

  <title>Admin Dashboard</title>
  <style>
    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      background-color: #2E809C;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      text-decoration: none;
      padding: 10px 20px;
      color: white;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .sidebar a:hover {
      background-color: rgba(31, 33, 34, 0.3);
      color: white;
      transform: translateX(1px);
    }

    .sidebar i {
      margin-right: 10px;
      font-size: 18px;
      color: white;
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
    <h4 class="text-center text-white py-3">Admin</h4>
   
    <a href="konten/DaftarMenu/dataProduk.php" target="kontenFrame">
      <i class="bi bi-card-list"></i> Daftar Menu
    </a>
   
  

   
    <a href="konten/tambahKasir/dataUser.php" target="kontenFrame">
      <i class="bi bi-person-badge"></i> Data User
    </a>
    <a href="konten/Laporan/laporan.php" target="kontenFrame">
     <i class="bi bi-journals"></i> Laporan
    </a>
     <a href="backend/querySql/logout.php" onclick="return confirm('Apakah Anda yakin ingin logout?');">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>

  </div>

  <div class="content">
    <iframe src="konten/DaftarMenu/dataProduk.php" name="kontenFrame"></iframe>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>