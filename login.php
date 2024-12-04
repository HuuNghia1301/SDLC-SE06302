<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login Form</title>
    <style>
        body {
            background: linear-gradient(135deg, #3a7bd5, #3a6073);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .card {
            border-radius: 15px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-control {
            border-radius: 30px;
            padding-left: 3rem;
            border: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .form-control::placeholder {
            color: #d1d1d1;
        }

        .form-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
        }

        .card-header {
            background: none;
            border-bottom: none;
            text-align: center;
        }

        .card-header h3 {
            color: #fff;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .btn-primary {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            border: none;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #2575fc, #6a11cb);
        }
    </style>
</head>
    <div class="card shadow-lg">
        <div class="card-header">
            <h3>Login</h3>
        </div>
        <div class="card-body p-4">
            <form action="" method="post">
                <div class="mb-4 position-relative">
                    <span class="form-icon"><i class="bi bi-person-fill"></i></span>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-4 position-relative">
                    <span class="form-icon"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">Login</button>
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

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Lựa từ bảng user cột username = username nhập từ form và cột password có giá trị bằng giá trị nhập từ form
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    // Thực thi truy vấn từ database
    $result = mysqli_query($conn, $sql); 
    // Xử lý kết quả truy vấn: đếm số lượng hàng trong kết quả truy vấn
    $check_login = mysqli_num_rows($result);
    if ($check_login == 0) {
        echo "<script>alert('Password or username is incorrect, please try again!')</script>";
        exit();
    }
    if ($check_login > 0) {
        echo "<script>alert('You have logged in successfully !')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
}

mysqli_close($conn);
?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.js"></script>
    </body>

</html>