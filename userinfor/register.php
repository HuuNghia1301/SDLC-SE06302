<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userinfor";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = 'Student';  

    $sql = "INSERT INTO users (first_name, last_name, email, phone_number, password, role) 
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php?message=Đăng ký thành công! Vui lòng đăng nhập.");
        exit;
    } else {
        $error = "Lỗi khi đăng ký: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="register.css">
</head>
<body>
<div class="container mt-5">
    <h2>Đăng ký</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Họ</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tên</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="phone_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>

    <div class="mt-3">
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
    </div>
</div>
<script>
window.onload = function () {
    const form = document.querySelector('form');
    form.style.opacity = 0;
    form.style.transition = 'opacity 1s ease-in';
    setTimeout(function() {
        form.style.opacity = 1;
    }, 200);
};
</script>
</body>
</html>
