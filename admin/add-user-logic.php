<?php
require "config/database.php";

// Kiểm tra quyền admin
if (!isset($_SESSION['user_is_admin'])) {
    header("location: " . ROOT_URL . "logout.php");
    // Hủy tất cả session và chuyển người dùng về trang đăng nhập
    session_destroy();
}

// Xử lý dữ liệu từ form khi nút submit được nhấn
if (isset($_POST["submit"])) {
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];

    // Kiểm tra tính hợp lệ của dữ liệu đầu vào
    if (!$firstname) {
        $_SESSION['add-user'] = 'Please enter your First Name';
    } elseif (!$lastname) {
        $_SESSION['add-user'] = 'Please enter your Last Name';
    } elseif (!$username) {
        $_SESSION['add-user'] = 'Please enter your Username';
    } elseif (!$email) {
        $_SESSION['add-user'] = 'Please enter your Email';
    } elseif (!($is_admin == 1 || $is_admin == 0)) {
        $_SESSION['add-user'] = 'Please select user role';
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['add-user'] = 'Password should be 8+ characters';
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = 'Please add Avatar';
    } else {
        if ($createpassword !== $confirmpassword) {
            $_SESSION['add-user'] = "Passwords do not match";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            // Kiểm tra xem tên đăng nhập hoặc email đã tồn tại chưa
            $user_check_query = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $connection->prepare($user_check_query);
            $stmt->execute([':username' => $username, ':email' => $email]);

            if ($stmt->rowCount() > 0) {
                $_SESSION['add-user'] = "Username or Email already exists";
            } else {
                // Xử lý ảnh đại diện
                $time = time(); // Sử dụng thời gian hiện tại để tạo tên file duy nhất
                $avatar_name = $time . $avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = '../images/' . $avatar_name;

                // Kiểm tra định dạng ảnh
                $allowed_files = ['png', 'jpg', 'jpeg'];
                $extension = pathinfo($avatar_name, PATHINFO_EXTENSION);

                if (in_array($extension, $allowed_files)) {
                    // Kiểm tra kích thước ảnh (dưới 1MB)
                    if ($avatar['size'] < 1000000) {
                        // Tải ảnh lên
                        move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                    } else {
                        $_SESSION['add-user'] = "Avatar file size should be less than 1MB";
                    }
                } else {
                    $_SESSION['add-user'] = "Avatar file should be png, jpg, or jpeg";
                }
            }
        }
    }

    // Nếu có lỗi, chuyển dữ liệu trở lại trang add-user
    if (isset($_SESSION['add-user'])) {
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-user.php');
        die();
    } else {
        // Chèn người dùng mới vào cơ sở dữ liệu
        $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin)
                              VALUES (:firstname, :lastname, :username, :email, :password, :avatar, :is_admin)";
        $stmt = $connection->prepare($insert_user_query);
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':username' => $username,
            ':email' => $email,
            ':password' => $hashed_password,
            ':avatar' => $avatar_name,
            ':is_admin' => $is_admin
        ]);

        if ($stmt) {
            $_SESSION['add-user-success'] = "Registration Successful";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        } else {
            $_SESSION['add-user'] = "Failed to register user. Please try again.";
        }
    }
} else {
    // Nếu không nhấn nút submit
    header('location: ' . ROOT_URL . "admin/add-user.php");
    die();
}
