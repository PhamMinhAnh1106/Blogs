<?php
require "config/database.php";

// Kiểm tra xem người dùng có phải là admin không, nếu không thì đăng xuất
if (!isset($_SESSION['user_is_admin'])) {
    header("location: " . ROOT_URL . "logout.php");
    // Huỷ tất cả session và chuyển hướng người dùng về trang đăng nhập
    session_destroy();
}

if (isset($_POST['submit'])) {
    // Lấy dữ liệu form đã được cập nhật
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // Kiểm tra dữ liệu đầu vào hợp lệ
    if (!$firstname || !$lastname) {
        $_SESSION['edit-user'] = "Invalid form input on edit page";
    } else {
        // Cập nhật thông tin người dùng
        $query = "UPDATE users SET firstname = :firstname, lastname = :lastname, is_admin = :is_admin WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $result = $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':is_admin' => $is_admin,
            ':id' => $id
        ]);

        if (!$result) {
            $_SESSION['edit-user'] = 'Failed to update user';
        } else {
            $_SESSION['edit-user-success'] = "User $firstname $lastname updated successfully";
        }
    }
}

// Chuyển hướng lại trang quản lý người dùng sau khi thực hiện xong
header("location: " . ROOT_URL . "admin/manage-users.php");
die();
?>
