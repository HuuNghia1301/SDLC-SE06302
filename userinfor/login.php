<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userinfor";

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $conn->real_escape_string($_POST['email']); // Tránh SQL Injection
    $password = $_POST['password'];

    // Truy vấn người dùng theo email
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    
    // Kiểm tra người dùng có tồn tại
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Lưu thông tin người dùng và vai trò vào session
            $_SESSION['user'] = $user;
            $_SESSION['role'] = $user['role']; // Giả sử 'role' có trong bảng `users`

            // Điều hướng dựa trên vai trò của người dùng
            if ($_SESSION['role'] === 'Student') {
                header("Location: student.php");
                exit();
            } elseif ($_SESSION['role'] === 'admin') {
                header("Location: users.php");
                exit();
            } 
        } else {
            $error = "Mật khẩu không chính xác!";
        }
    } else {
        $error = "Email không tồn tại!";
    }
}

// Đóng kết nối
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Đăng Nhập</h3>

                        <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?= $error_message ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required placeholder="Nhập email">
                            </div>

                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" id="password" required placeholder="Nhập mật khẩu">
                            </div>

                            <button type="submit" name="login" class="btn btn-primary btn-block">Đăng Nhập</button>
                        </form>

                        <p class="text-center mt-3">Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
