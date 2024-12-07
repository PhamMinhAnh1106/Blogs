<?php
require "config/database.php";

// Kiểm tra nếu người dùng gửi form đăng nhập
if (isset($_POST['submit'])) {
    // Lấy dữ liệu từ form và sanitize
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (!$username_email) {
        $_SESSION['signin'] = 'Username or Email is Incorrect';
    } elseif (!$password) {
        $_SESSION['signin'] = 'Password required';
    } else {
        try {
            // Truy vấn tìm người dùng trong cơ sở dữ liệu
            $query = "SELECT * FROM users WHERE username = :username_email OR email = :username_email";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':username_email', $username_email, PDO::PARAM_STR);
            $stmt->execute();
            $user_record = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user_record) {
                $db_password = $user_record['password'];

                // So sánh mật khẩu từ form với mật khẩu trong cơ sở dữ liệu
                if (password_verify($password, $db_password)) {
                    // Thiết lập session để kiểm soát quyền truy cập
                    $_SESSION['user-id'] = $user_record['id'];
                    $_SESSION['signin-success'] = "User successfully logged in";

                    // Nếu người dùng là admin, thiết lập session admin
                    if ($user_record['is_admin'] == 1) {
                        $_SESSION['user_is_admin'] = true;
                    }

                    // Chuyển hướng người dùng đến trang admin
                    header('location: ' . ROOT_URL . 'admin/index.php');
                    exit(); // Dừng script sau khi chuyển hướng
                } else {
                    $_SESSION['signin'] = "Please check your input";
                }
            } else {
                $_SESSION['signin'] = "User Not found";
            }
        } catch (PDOException $e) {
            $_SESSION['signin'] = "Database error: " . $e->getMessage();
        }
    }

    // Nếu có lỗi, lưu lại dữ liệu vào session và chuyển hướng về trang đăng nhập
    if (isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }
} else {
    header('location: ' . ROOT_URL . "signin.php");
    die();
}
?>
