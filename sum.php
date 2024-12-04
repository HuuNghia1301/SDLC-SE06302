<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $n = 10;
    $sum = 0;
    for($i = 1; $i < $n; $i++){
        $sum += $i;
    }
    echo "<br> sum = $sum";

    $x = 5;
    $giaiThua = 1;
    for($i = 2;$i <= $x;$i++){
        $giaiThua *= $i;
    }
    echo "<br> Giai Thua: $giaiThua";
    echo "<br>";
    $paper[0] = "Copier";
    $paper[1] = "Inkjet";
    $paper[2] = "Laser";
    $paper[3] = "Photo";
    for($i = 0 ; $i < count($paper); $i++){
        echo "$i: $paper[$i] <br/>"; 
    }
    ?>
</body>
</html>