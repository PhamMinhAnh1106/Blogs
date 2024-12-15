<?php

require 'config/database.php';

// Kiểm tra xem người dùng có phải là admin không, nếu không thì đăng xuất
if (!isset($_SESSION['user_is_admin'])) {
    header("location:" . ROOT_URL . "logout.php");
    exit();
} elseif (isset($_GET["id"])) {
    // Lọc và làm sạch ID người dùng từ URL
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Kiểm tra nếu admin hiện tại đang cố gắng xóa admin khác
    $current_user_id = $_SESSION['user_id']; // ID của admin hiện tại
    $check_target_admin_query = "SELECT is_admin FROM users WHERE id = :id";
    $check_target_admin_stmt = $connection->prepare($check_target_admin_query);
    $check_target_admin_stmt->execute([':id' => $id]);
    $target_is_admin = $check_target_admin_stmt->fetchColumn();

    if ($target_is_admin == 1 && $current_user_id != $id) {
        $_SESSION['delete-user'] = "Bạn không thể xóa admin khác!";
    } else {
        // Truy vấn lấy thông tin người dùng từ cơ sở dữ liệu
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $connection->prepare($query);
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);  // Lấy thông tin người dùng về dạng mảng

        // Kiểm tra nếu có kết quả trả về (chỉ có một người dùng)
        if ($stmt->rowCount() == 1) {
            $avatar_name = $user['avatar'];
            $avatar_path = '../images/' . $avatar_name;

            // Kiểm tra nếu tệp ảnh tồn tại thì xóa
            if ($avatar_path && file_exists($avatar_path)) {
                unlink($avatar_path);
            }
        }

        // Truy vấn lấy tất cả thumbnail từ các bài viết của người dùng và xóa chúng
        $thumbnails_query = "SELECT thumbnail FROM posts WHERE author_id = :id";
        $thumbnails_stmt = $connection->prepare($thumbnails_query);
        $thumbnails_stmt->execute([':id' => $id]);

        // Kiểm tra và xóa tất cả các thumbnail liên quan đến người dùng này
        if ($thumbnails_stmt->rowCount() > 0) {
            while ($thumbnail = $thumbnails_stmt->fetch(PDO::FETCH_ASSOC)) {
                $thumbnail_path = "../images/" . $thumbnail['thumbnail'];
                if ($thumbnail_path && file_exists($thumbnail_path)) {
                    unlink($thumbnail_path);
                }
            }
        }

        // Truy vấn để xóa người dùng khỏi cơ sở dữ liệu
        $delete_user_query = "DELETE FROM users WHERE id = :id";
        $delete_user_stmt = $connection->prepare($delete_user_query);
        $delete_user_stmt->execute([':id' => $id]);

        // Kiểm tra xem người dùng đã được xóa thành công chưa
        if ($delete_user_stmt->rowCount() > 0) {
            $_SESSION['delete-user-success'] = "'{$user['firstname']} {$user['lastname']}' đã được xóa thành công";
        } else {
            $_SESSION['delete-user'] = "Không thể xóa '{$user['firstname']}' '{$user['lastname']}'";
        }
    }
}

// Chuyển hướng về trang quản lý người dùng
header("location: " . ROOT_URL . "admin/manage-users.php");
exit();
