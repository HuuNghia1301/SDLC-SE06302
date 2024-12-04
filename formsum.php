<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="number" name="number" id="number">
        <button type="submit">Submit</button>
    </form>

    <?php
    if(isset($_POST['number'])){
        $n = $_POST['number'];
    
    $sum = 0;
    for ($i = 0 ; $i <= $n ;$i++){
        $sum += $i;
    }
    echo "sum: $sum <br>";

    $a = 1;
    for ($i = 1 ; $i <= $n ;$i++){
        $a *= $i;
    }
    echo "Giai thua: $a <br>";
}
    ?>
</body>
</html>