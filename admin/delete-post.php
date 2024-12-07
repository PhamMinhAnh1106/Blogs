<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    // Lọc và xác nhận giá trị id từ URL
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Truy vấn bài viết từ cơ sở dữ liệu
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Kiểm tra nếu có 1 bản ghi được lấy từ cơ sở dữ liệu
    if ($stmt->rowCount() == 1) {
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        $thumbnail_name = $post['thumbnail'];
        $thumbnail_path = "../images/" . $thumbnail_name;

        // Nếu có thumbnail, xóa ảnh khỏi thư mục
        if ($thumbnail_path) {
            unlink($thumbnail_path);
        }

        // Xóa bài viết khỏi cơ sở dữ liệu
        $delete_post_query = "DELETE FROM posts WHERE id = :id LIMIT 1";
        $delete_stmt = $connection->prepare($delete_post_query);
        $delete_stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $delete_stmt->execute();

        // Kiểm tra nếu không có lỗi trong quá trình xóa
        if ($delete_stmt->rowCount() > 0) {
            $_SESSION['edit-post-success'] = "Post deleted successfully";
        }
    }

} else {
    header('location: ' . ROOT_URL . 'admin/');
    die();
}

// Chuyển hướng lại về trang quản lý bài viết
header('location: ' . ROOT_URL . 'admin/');
die();
?>
