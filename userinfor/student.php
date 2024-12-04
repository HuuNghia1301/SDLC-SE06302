<?php
session_start();

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userinfor";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách lớp học sinh viên đã đăng ký theo email
$query = "SELECT classes.ClassName, courses.CourseName, users.first_name, users.last_name
          FROM classes
          JOIN courses ON classes.CourseID = courses.CourseID
          JOIN users ON classes.UserID = users.UserID
          WHERE users.email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);  // 's' cho kiểu string
$stmt->execute();
$result = $stmt->get_result();

// Lấy thông tin sinh viên theo email
$query_student = "SELECT * FROM users WHERE email = ?";
$stmt_student = $conn->prepare($query_student);
$stmt_student->bind_param("s", $email);
$stmt_student->execute();
$student_result = $stmt_student->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang Sinh Viên</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="student.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Chào mừng đến với Trang Sinh Viên</h2>
        
        <!-- Thông báo -->
        <div class="alert alert-success mt-4">
            Bạn đã đăng nhập thành công với vai trò: <strong>Student</strong>
        </div>

        <!-- Xem thông tin sinh viên -->
        <h4>Thông Tin Sinh Viên</h4>
        <p><strong>Họ và tên:</strong> <?= htmlspecialchars($student_info['first_name'] . ' ' . $student_info['last_name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($student_info['email']) ?></p>
        <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($student_info['phone_number']) ?></p>

        <!-- Xem các lớp học đã đăng ký -->
        <h4>Lịch Học Của Bạn</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên Lớp</th>
                    <th>Khóa Học</th>
                    <th>Giảng Viên</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ClassName']) ?></td>
                        <td><?= htmlspecialchars($row['CourseName']) ?></td>
                        <td><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Đăng ký khóa học mới -->
        <h4>Đăng Ký Khóa Học Mới</h4>
        <form method="POST" action="register_course.php">
            <div class="form-group">
                <label for="course_select">Chọn Khóa Học</label>
                <select id="course_select" name="course_id" class="form-control">
                    <!-- Các khóa học có thể đăng ký -->
                    <?php
                    $course_query = "SELECT * FROM courses";
                    $course_result = $conn->query($course_query);
                    while ($course = $course_result->fetch_assoc()):
                    ?>
                        <option value="<?= htmlspecialchars($course['CourseID']) ?>"><?= htmlspecialchars($course['CourseName']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Đăng Ký</button>
        </form>

        <hr>

        <a href="logout.php" class="btn btn-danger mt-3">Đăng Xuất</a>
    </div>
</body>
</html>
