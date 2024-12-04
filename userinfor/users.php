<?php
// Kết nối cơ sở dữ liệu
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userinfor";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy danh sách người dùng
$users_result = $conn->query("SELECT * FROM users");

// Lấy danh sách lớp học
$classes_result = $conn->query("SELECT classes.*, courses.CourseName
                                FROM classes
                                INNER JOIN courses ON classes.CourseID = courses.CourseID");

// Lấy danh sách khóa học
$courses_result = $conn->query("SELECT * FROM courses");

// Xử lý thêm dữ liệu từ biểu mẫu
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_user'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $role = $_POST['role'];
        $sql = "INSERT INTO users (first_name, last_name, email, phone_number, role) 
                VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$role')";
        $conn->query($sql);
        header("Location: " . $_SERVER['PHP_SELF']);
    } elseif (isset($_POST['add_class'])) {
        $ClassName = isset($_POST['ClassName']) ? $_POST['ClassName'] : null;
        $CourseID = isset($_POST['CourseID']) ? $_POST['CourseID'] : null;
        $UserID = isset($_POST['UserID']) ? $_POST['UserID'] : null;
        $semester = isset($_POST['semester']) ? $_POST['semester'] : null;
        $school_year = isset($_POST['school_year']) ? $_POST['school_year'] : null;

        if ($CourseID && $UserID && $semester && $school_year) {
            // Chuẩn bị truy vấn
            $stmt = $conn->prepare("
    INSERT INTO classes (ClassName, CourseID, UserID, semester, school_year)
    SELECT 
        CONCAT(u.first_name, ' ', u.last_name) AS ClassName,
        c.CourseID,
        u.UserID,
        ? AS semester,
        ? AS school_year
    FROM 
        users u
    JOIN 
        courses c ON c.CourseID = ?
    WHERE 
        u.UserID = ?
");


            if ($stmt) {
                // Bind các tham số
                $stmt->bind_param("ssis", $semester, $school_year, $CourseID, $UserID);

                // Thực thi câu truy vấn
                if ($stmt->execute()) {
                    echo "<script>alert('Thêm lớp thành công!');</script>";
                } else {
                    echo "<script>alert('Lỗi khi thêm lớp: " . $stmt->error . "');</script>";
                }
                $stmt->close();
            } else {
                echo "<script>alert('Lỗi chuẩn bị câu truy vấn: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Vui lòng nhập đầy đủ thông tin.');</script>";
        }

        // Chuyển hướng sau khi xử lý
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
} elseif (isset($_POST['add_course'])) {
    $course_name = $_POST['CourseName'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $sql = "INSERT INTO courses (CourseName, start_date, end_date) 
                VALUES ('$course_name', '$start_date', '$end_date')";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý Hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .navbar {
            background-color: #343a40;
        }

        .navbar .navbar-brand,
        .navbar .nav-link {
            color: #fff;
        }

        .navbar .nav-link:hover {
            color: #00d4ff;
        }

        .container {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fas fa-user-cog"></i> Quản lý Hệ thống</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="login.php"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Tabs -->
    <div class="container mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#users"><i class="fas fa-users"></i> Quản lý Người Dùng</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#classes"><i class="fas fa-chalkboard"></i> Lớp Học</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#courses"><i class="fas fa-book"></i> Khóa Học</button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3">
            <!-- Người Dùng -->
            <div class="tab-pane fade show active" id="users">
                <h3>Quản lý Người Dùng</h3>
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-user-plus"></i> Thêm Người Dùng</button>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Họ</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $users_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['first_name'] ?></td>
                                <td><?= $row['last_name'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['phone_number'] ?></td>
                                <td><?= $row['role'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Lớp Học -->
            <div class="tab-pane fade" id="classes">
                <h3>Quản lý Lớp Học</h3>
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addClassModal"><i class="fas fa-plus"></i> Thêm Lớp Học</button>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên Lớp</th>
                            <th>Khóa Học</th>
                            <th>Giảng viên</th>
                            <th>Học kỳ</th>
                            <th>Năm học</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $classes_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['ClassName'] ?></td>
                                <td><?= $row['CourseName'] ?></td>
                                <td><?= $row['UserID'] ?></td>
                                <td><?= $row['semester'] ?></td>
                                <td><?= $row['school_year'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Khóa Học -->
            <div class="tab-pane fade" id="courses">
                <h3>Quản lý Khóa Học</h3>
                <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCourseModal"><i class="fas fa-plus"></i> Thêm Khóa Học</button>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên Khóa Học</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $courses_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['CourseName'] ?></td>
                                <td><?= $row['start_date'] . ' - ' . $row['end_date'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal">
        <div class="modal-dialog">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Thêm Người Dùng</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">Họ</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Tên</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Số điện thoại</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Vai trò</label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_user" class="btn btn-success">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Class Modal -->
    <div class="modal fade" id="addClassModal">
        <div class="modal-dialog">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Thêm Lớp Học</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ClassName" class="form-label">Tên Lớp</label>
                            <input type="text" id="ClassName" name="ClassName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="CourseID" class="form-label">Khóa Học</label>
                            <select id="CourseID" name="CourseID" class="form-select" required>
                                <option value="" disabled selected>-- Chọn khóa học --</option>
                                <?php
                                // Truy vấn danh sách khóa học
                                $courses_result = $conn->query("SELECT CourseID, CourseName FROM courses");
                                while ($course = $courses_result->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($course['CourseID']) ?>">
                                        <?= htmlspecialchars($course['CourseName']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="UserID" class="form-label">Giảng viên</label>
                            <select id="UserID" name="UserID" class="form-select" required>
                                <option value="" disabled selected>-- Chọn giảng viên --</option>
                                <?php
                                // Truy vấn danh sách người dùng có vai trò giảng viên
                                $users_result = $conn->query("SELECT UserID, CONCAT(first_name, ' ', last_name) AS full_name FROM users WHERE role = 'Teacher'");
                                while ($user = $users_result->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($user['UserID']) ?>">
                                        <?= htmlspecialchars($user['full_name']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="semester" class="form-label">Học kỳ</label>
                            <input type="text" id="semester" name="semester" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="school_year" class="form-label">Năm học</label>
                            <input type="text" id="school_year" name="school_year" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_class" class="btn btn-success">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Add Course Modal -->
    <div class="modal fade" id="addCourseModal">
        <div class="modal-dialog">
            <form method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Thêm Khóa Học</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="CourseName" class="form-label">Tên Khóa Học</label>
                            <input type="text" id="CourseName" name="CourseName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Ngày bắt đầu</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Ngày kết thúc</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="add_course" class="btn btn-success">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>