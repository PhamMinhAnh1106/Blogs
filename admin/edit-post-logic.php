<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    // Lọc và xác nhận các giá trị từ form
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = htmlspecialchars($_POST['is_featured'], ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8');
    $previous_thumbnail_name = htmlspecialchars($_POST['previous_thumbnail_name'], ENT_QUOTES, 'UTF-8');
    $category_id = filter_var($_POST['category_id'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // Nếu không chọn "Featured", set giá trị là 0
    $is_featured = $is_featured == 1 ?: 0;

    // Kiểm tra và xác nhận các giá trị đầu vào
    if (!$title) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit page.";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit page.";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form data on edit page.";
    } else {
        // Nếu có thumbnail mới, xử lý thumbnail
        if ($thumbnail['name']) {
            // Xóa ảnh thumbnail cũ
            $previous_thumbnail_destination = '../images/' . $previous_thumbnail_name;
            if (file_exists($previous_thumbnail_destination)) {
                unlink($previous_thumbnail_destination);  // Xóa ảnh cũ
            }

            // Tạo tên ảnh mới
            $time = time();  // Đảm bảo tên ảnh là duy nhất
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = "../images/" . $thumbnail_name;

            // Kiểm tra nếu file là ảnh hợp lệ
            $allowed_files = ['jpg', 'png', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);
            if (in_array($extension, $allowed_files)) {
                // Kiểm tra kích thước ảnh
                if ($thumbnail['size'] < 2000000) {  // Kiểm tra ảnh không quá 2MB
                    // Upload ảnh
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "File size too big. Should be less than 2mb";
                }
            } else {
                $_SESSION['edit-post'] = "File should be png, jpg, or jpeg";
            }
        }
    }

    // Nếu có lỗi, chuyển hướng về trang quản lý bài viết
    if (isset($_SESSION['edit-post'])) {
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // Nếu bài viết được đánh dấu "Featured", set tất cả các bài viết khác về "Not Featured"
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $connection->exec($zero_all_is_featured_query);  // Dùng PDO exec() để thực hiện câu lệnh SQL
        }

        // Xác định thumbnail cần lưu vào cơ sở dữ liệu
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        // Cập nhật bài viết trong cơ sở dữ liệu
        $query = "UPDATE posts SET title = :title, body = :body, thumbnail = :thumbnail, category_id = :category_id, is_featured = :is_featured WHERE id = :id LIMIT 1";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':body', $body, PDO::PARAM_STR);
        $stmt->bindParam(':thumbnail', $thumbnail_to_insert, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Thực thi câu lệnh và kiểm tra kết quả
        if ($stmt->execute()) {
            $_SESSION['edit-post-success'] = "Post updated successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();
?>
