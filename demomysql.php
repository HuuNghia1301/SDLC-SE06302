<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "se06302_sdlc";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    if(!$conn){
        die("Ket noi that bai: ". mysqli_connect_error());
    }
    echo "Ket noi thanh cong!"
    ?>
</body>
</html>