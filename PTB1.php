<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giải Phương Trình Bậc Nhất</title>
</head>
<body>
    <form method="POST">
        <input type="number" name="sothunhat" id="sothunhat" placeholder="Số thứ nhất" required>
        <input type="number" name="sothuhai" id="sothuhai" placeholder="Số thứ hai" required>
        <button type="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sothunhat = $_POST['sothunhat'];
        $sothuhai = $_POST['sothuhai'];

        if ($sothunhat == 0 && $sothuhai == 0) {
            echo "<p>Phương trình vô số nghiệm!</p>";
        } elseif ($sothunhat == 0 && $sothuhai != 0) {
            echo "<p>Phương trình vô nghiệm!</p>";
        } else {
            $x = -$sothuhai / $sothunhat;
            echo "<p>Nghiệm của phương trình là: x = $x</p>";
        }
    }
    ?>
</body>
</html>
