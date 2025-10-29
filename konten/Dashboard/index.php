
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
  <?php
  include __DIR__ . '/../../backend/querySql/readProduk.php'
  ?>
  <h4>Selamat datang, ini adalah halaman dashboard!</h4>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-4">
        <div class="card shadow-sm m-3">
          <div class="card-body">
            <h3 class="text-muted">Daftar Menu</h3>
            <h4><i class="bi bi-people-fill"></i> 50</h4>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card shadow-sm m-3">
          <div class="card-body">
            <h3 class="text-muted">Siswa</h3>
            <h4><i class="bi bi-people-fill"></i><?= $jumlahSiswa ?></h4>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card shadow-sm m-3">
          <div class="card-body">
            <h3 class="text-muted">Admin</h3>
            <h4><i class="bi bi-people-fill"></i><?= $jumlahAdmin ?></h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>