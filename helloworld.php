<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    echo "Hello World!<br/>";
    $name = "Mr.A";
    $age = 20;
    $course = array("Java","C","PHP");
    echo "Name: " . $name . ", age: " . $age . "<br/>3rd course is: " . $course[2] ."<br/>";
    echo "true && true: ". (true && true) . "<br/>";
    
    $num = 123 * 456;
    var_dump($num); // in ra kieu du lieu
    echo "<br/>";
    print_r($num); // in ra bien nguoi doc
    echo "<br/>";
    
    echo substr((string)$num, 3, 2); // cat chuoi
    echo "<br/>";
    
    function displayDate(){
        return date("l, F d, Y");
    }
    echo displayDate();
    echo "<br/>";
    if($age > 18){
        echo "<br> du tuoi di bau cu";
    }
    else{
        echo "Chua du tuoi di bau cu";
    }
    ?>
</body>
</html>
