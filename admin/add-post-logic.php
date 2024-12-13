<?php
require "config/database.php";

if(isset($_POST['submit'])){
    $author_id = $_SESSION['user-id'];
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8');
    $category_id = htmlspecialchars($_POST['category_id'], ENT_QUOTES, 'UTF-8');
    $is_featured = htmlspecialchars($_POST['is_featured'], ENT_QUOTES, 'UTF-8');
    $thumbnail = $_FILES['thumbnail'];

    // Đặt giá trị is_featured bằng 0 nếu không được chọn
    $is_featured = $is_featured == 1 ? 1 : 0;

    // Kiểm tra dữ liệu form
    if(!$title){
        $_SESSION['add-post'] = "Nhập tiêu đề bài viết";
    } elseif(!$category_id) {
        $_SESSION['add-post'] = "Chọn danh mục bài viết";
    } elseif(!$body) {
        $_SESSION['add-post'] = "Nhập nội dung bài viết";
    } elseif(!$thumbnail['name']) {
        $_SESSION['add-post'] = "Chọn hình thu nhỏ cho bài viết";
    } else {
        // Xử lý hình thu nhỏ
        // Đổi tên hình ảnh
        $time = time(); // Đảm bảo tên duy nhất cho mỗi hình ảnh
        $thumbnail_name = $time . $thumbnail['name'];
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = "../images/" . $thumbnail_name;

        // Kiểm tra xem file có phải là hình ảnh không
        $allowed_files = ['jpg', 'png', 'jpeg'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);
        if (in_array($extension, $allowed_files)) {
            // Kiểm tra kích thước hình ảnh không quá lớn (2mb+)
            if ($thumbnail['size'] < 2000000) {
                // Tải lên hình thu nhỏ
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "Kích thước file quá lớn. Phải nhỏ hơn 2mb";
            }
        } else {
            $_SESSION['add-post'] = "File phải có định dạng png, jpg hoặc jpeg";
        }
    }

    // Chuyển hướng nếu có lỗi trong form
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        // Đặt giá trị is_featured của tất cả bài viết thành 0 nếu is_featured của bài viết này được chọn là 1
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $stmt = $connection->prepare($zero_all_is_featured_query);
            $stmt->execute();
        }

        // Thêm bài viết vào cơ sở dữ liệu sử dụng PDO
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) 
                  VALUES (:title, :body, :thumbnail, :category_id, :author_id, :is_featured)";
        $stmt = $connection->prepare($query);
        
        // Liên kết các tham số
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':body', $body);
        $stmt->bindParam(':thumbnail', $thumbnail_name);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $stmt->bindParam(':is_featured', $is_featured, PDO::PARAM_INT);

        // Thực thi truy vấn
        if ($stmt->execute()) {
            $_SESSION['add-post-success'] = "Thêm bài viết mới thành công";
            header("location: " . ROOT_URL . 'admin/index.php');
            die();
        } else {
            $_SESSION['add-post'] = "Thêm bài viết thất bại";
            header("location: " . ROOT_URL . 'admin/index.php');
            die();
        }
    }
}

header("location: " . ROOT_URL . 'admin/index.php');
die();
?>
