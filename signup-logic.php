<?php
require "config/database.php";
session_start();

// Kiểm tra nếu người dùng đã nhấn nút submit từ form đăng ký
if (isset($_POST["submit"])) {
    // Lọc và làm sạch dữ liệu form
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Kiểm tra các trường nhập liệu
    if (!$firstname) {
        $_SESSION['signup'] = 'Please enter your First Name';
    } elseif (!$lastname) {
        $_SESSION['signup'] = 'Please enter your Last Name';
    } elseif (!$username) {
        $_SESSION['signup'] = 'Please enter your Username';
    } elseif (!$email) {
        $_SESSION['signup'] = 'Please enter your Email';
    } elseif (strlen($createpassword) < 8 || strlen($confirmpassword) < 8) {
        $_SESSION['signup'] = 'Password should be 8+ characters';
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = 'Please add Avatar';
    } else {
        if ($createpassword !== $confirmpassword) {
            $_SESSION['signup'] = "Passwords do not match";
        } else {
            // Mã hóa mật khẩu
            $hashed_password = password_hash($createpassword, PASSWORD_DEFAULT);

            try {
                // Kiểm tra xem tên người dùng hoặc email đã tồn tại chưa
                $user_check_query = "SELECT * FROM users WHERE username = :username OR email = :email";
                $stmt = $connection->prepare($user_check_query);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    $_SESSION['signup'] = "Username or Email already exists";
                } else {
                    // Xử lý avatar
                    $time = time(); // Tạo tên ảnh duy nhất
                    $avatar_name = $time . $avatar['name'];
                    $avatar_tmp_name = $avatar['tmp_name'];
                    $avatar_destination_path = 'images/' . $avatar_name;

                    // Kiểm tra định dạng ảnh
                    $allowed_files = ['png', 'jpg', 'jpeg'];
                    $extension = explode('.', $avatar_name);
                    $extension = end($extension);
                    if (in_array($extension, $allowed_files)) {
                        // Kiểm tra kích thước ảnh
                        if ($avatar['size'] < 1000000) {
                            // Upload avatar
                            move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                        } else {
                            $_SESSION['signup'] = "File size too big. Should be less than 1mb";
                        }
                    } else {
                        $_SESSION['signup'] = "File should be png, jpg or jpeg";
                    }
                }
            } catch (PDOException $e) {
                $_SESSION['signup'] = "Database error: " . $e->getMessage();
            }
        }
    }

    // Nếu có lỗi, chuyển hướng về trang đăng ký và giữ lại dữ liệu form
    if (isset($_SESSION['signup'])) {
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // Chèn người dùng mới vào cơ sở dữ liệu
        try {
            $insert_user_query = "INSERT INTO users (firstname, lastname, username, email, password, avatar, is_admin) 
                                  VALUES (:firstname, :lastname, :username, :email, :password, :avatar, 0)";
            $stmt = $connection->prepare($insert_user_query);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':lastname', $lastname);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':avatar', $avatar_name);
            $stmt->execute();

            // Nếu không có lỗi, chuyển hướng về trang đăng nhập
            $_SESSION['signup-success'] = "Registration Successful. Please login";
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        } catch (PDOException $e) {
            $_SESSION['signup'] = "Error: " . $e->getMessage();
            header('location: ' . ROOT_URL . 'signup.php');
            die();
        }
    }
} else {
    // Nếu nút submit chưa được nhấn, chuyển hướng về trang đăng ký
    header('location: ' . ROOT_URL . "signup.php");
    die();
}
