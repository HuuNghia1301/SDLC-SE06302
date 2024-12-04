<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        Username: <input type="text" name="username" id="username"><br><br>
        Password: <input type="password" name="password" id="password"><br><br>
        Re-type password: <input type="password" name="repassword" id="repassword"><br><br>
        Email: <input type="email" name="email" id="email"><br><br>
        Gender: <input type="radio" name="gender" value="Male"> Male
        <input type="radio" name="gender" value="Female"> Female<br><br>
        
        <label for="option">University:</label>
        <select id="option" name="option">
            <option value="btec">Btec</option>
            <option value="mit">MIT</option>
            <option value="stanford">Stanford</option>
            <option value="harvard">Harvard</option>
        </select><br><br>

        Course: <input type="checkbox" name="course[]" value="PHP"> PHP
        <input type="checkbox" name="course[]" value="JS"> JS
        <input type="checkbox" name="course[]" value="CSS"> CSS
        <input type="checkbox" name="course[]" value="MYSQL"> MYSQL
        <br><br>
        <input type="submit" value="Login">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $re_type_password = isset($_POST['repassword']) ? $_POST['repassword'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
        $option = isset($_POST['option']) ? $_POST['option'] : '';
        $course = isset($_POST['course']) ? $_POST['course'] : [];

        echo "<h2 style='color:red;'>Chúc mừng bạn đã đăng ký thành công</h2>";
        echo "<table border='1'>
                <tr><td>Username:</td><td>$username</td></tr>
                <tr><td>Password:</td><td>$password</td></tr>
                <tr><td>Email:</td><td>$email</td></tr>
                <tr><td>Gender:</td><td>$gender</td></tr>
                <tr><td>University:</td><td>$option</td></tr>
                <tr><td>Course:</td><td>" . implode(", ", $course) . "</td></tr>
              </table>";
    }
    ?>
</body>

</html>
