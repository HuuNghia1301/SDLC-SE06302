<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $x = 10;
    function change(&$x){
        $x = 11;
        echo "x inside the change method: " .$x."<br/>";
    }
    echo "x before calling to change: " .$x. "<br/>";
    change($x);

    echo "x after callin gto change: " .$x. "<br/>";
    ?>
</body>
</html> 