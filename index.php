<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #2E809C 0%, #5A9CAF 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(46, 128, 156, 0.3);
      background: rgba(255, 255, 255, 0.95);
    }
    .card-body {
      padding: 2rem;
    }
    .form-label {
      color: #2E809C;
      font-weight: 600;
    }
    .form-control {
      border: 2px solid #2E809C;
      border-radius: 8px;
      padding: 0.75rem;
    }
    .form-control:focus {
      border-color: #2E809C;
      box-shadow: 0 0 0 0.2rem rgba(46, 128, 156, 0.25);
    }
    .btn-primary {
      background-color: #2E809C;
      border-color: #2E809C;
      border-radius: 8px;
      padding: 0.75rem 2rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #245a6b;
      border-color: #245a6b;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(46, 128, 156, 0.4);
    }
    .form-check-input:checked {
      background-color: #2E809C;
      border-color: #2E809C;
    }
  </style>
</head>

<body>
  <div class="container col-3 mt-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <form action="backend/querySql/proses_login.php" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input
              type="text"
              class="form-control"
              id="username"
              name="username" />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              name="password" />
          </div>


          <div class="mb-3 form-check">
            <input
              type="checkbox"
              class="form-check-input"
              id="exampleCheck1" />

          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
