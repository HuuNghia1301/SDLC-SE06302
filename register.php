<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Register Form</title>
  <style>
    body {
      background: linear-gradient(135deg, #a8edea, #fed6e3);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #333;
      font-family: Arial, sans-serif;
      margin: 0;
    }

    .card {
      border-radius: 20px;
      backdrop-filter: blur(12px);
      background: rgba(255, 255, 255, 0.3);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      padding: 25px;
      max-width: 420px;
      width: 100%;
      border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .form-control {
      border-radius: 25px;
      padding-left: 3rem;
      border: none;
      background: rgba(255, 255, 255, 0.25);
      color: #333;
    }

    .form-control::placeholder {
      color: #666;
    }

    .form-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: #333;
      font-size: 1.2em;
    }

    .card-header {
      background: none;
      border-bottom: none;
      text-align: center;
    }

    .card-header h3 {
      color: #444;
      font-weight: bold;
      font-size: 1.6rem;
    }

    .btn-primary {
      background: linear-gradient(to right, #4facfe, #00f2fe);
      border: none;
      border-radius: 25px;
      font-weight: bold;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background: linear-gradient(to right, #00f2fe, #4facfe);
      transform: scale(1.02);
    }
  </style>
</head>

<body>
  <div class="card shadow-lg">
    <div class="card-header">
      <h3>Register</h3>
    </div>
    <div class="card-body p-4">
      <form action="" method="post">
        <div class="mb-4 position-relative">
          <span class="form-icon"><i class="bi bi-person-fill"></i></span>
          <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
        </div>
        <div class="mb-4 position-relative">
          <span class="form-icon"><i class="bi bi-lock-fill"></i></span>
          <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
        </div>
        <div class="mb-4 position-relative">
          <span class="form-icon"><i class="bi bi-envelope-fill"></i></span>
          <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
        </div>
        <div class="d-grid">
          <button type="submit" class="btn btn-primary btn-lg">Register</button>
        </div>
      </form>
    </div>
  </div>

  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "se06302_sdlc";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];

    $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkUserResult = mysqli_query($conn, $checkUserQuery);

    if (mysqli_num_rows($checkUserResult) > 0) {
      echo "<script>alert('Tên người dùng đã tồn tại. Vui lòng chọn tên khác!')</script>";
    } else {
      $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
      $result = mysqli_query($conn, $sql);

      if ($result) {
        echo "<script>alert('Đăng ký thành công!')</script>";
      } else {
        echo "<script>alert('Đăng ký thất bại!')</script>";
      }
    }
  }

  mysqli_close($conn);
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
</body>

</html>
