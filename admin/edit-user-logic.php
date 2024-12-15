<?php
require "config/database.php";

// Kiểm tra xem người dùng có phải là admin không, nếu không thì đăng xuất
if (!isset($_SESSION['user_is_admin'])) {
    header("location: " . ROOT_URL . "logout.php");
    session_destroy();
    die();
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
        // Kiểm tra nếu admin hiện tại đang cố gắng sửa admin khác
        $current_user_id = $_SESSION['user_id']; // ID của admin hiện tại
        $check_target_admin_query = "SELECT is_admin FROM users WHERE id = :id";
        $check_target_admin_stmt = $connection->prepare($check_target_admin_query);
        $check_target_admin_stmt->execute([':id' => $id]);
        $target_is_admin = $check_target_admin_stmt->fetchColumn();

        if ($target_is_admin == 1 && $current_user_id != $id) {
            $_SESSION['edit-user'] = "Bạn không thể chỉnh sửa thông tin admin khác!";
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
                $_SESSION['edit-user'] = 'Cập nhật thông tin thất bại!';
            } else {
                $_SESSION['edit-user-success'] = "Người dùng $firstname $lastname Cập nhật thông tin thành công";
            }
        }
    }
}

// Chuyển hướng lại trang quản lý người dùng sau khi thực hiện xong
header("location: " . ROOT_URL . "admin/manage-users.php");
die();
?>
