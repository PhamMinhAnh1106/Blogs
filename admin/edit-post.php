<?php
include "partials/header.php";

// Truy vấn lấy tất cả các danh mục từ cơ sở dữ liệu
$category_query = "SELECT * FROM categories";
$categories = $connection->query($category_query);  // Sử dụng PDO để truy vấn danh mục

// Lấy dữ liệu bài viết từ cơ sở dữ liệu nếu ID được cung cấp qua URL
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);  // Lọc và xác nhận ID
    $query = "SELECT * FROM posts WHERE id = :id";  // Sử dụng PDO để tránh SQL Injection
    $stmt = $connection->prepare($query);  // Chuẩn bị câu lệnh SQL
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);  // Liên kết tham số với ID bài viết
    $stmt->execute();  // Thực thi câu lệnh

    // Lấy dữ liệu bài viết
    $post = $stmt->fetch(PDO::FETCH_ASSOC);  // Lấy kết quả dạng mảng liên kết
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" enctype="multipart/form-data" method="POST">
            <!-- Tiêu đề bài viết -->
            <input type="text" value="<?=$post['title']?>" name ="title" placeholder="Title">
            <input type="hidden" value="<?=$post['id']?>" name="id">
            <input type="hidden" value="<?=$post['thumbnail']?>" name="previous_thumbnail_name">

            <!-- Danh mục bài viết -->
            <select name="category_id">
                <?php while ($category = $categories->fetch(PDO::FETCH_ASSOC)) : ?>
                    <option value='<?= $category['id'] ?>'><?= $category['title'] ?></option>
                <?php endwhile ?>
            </select>

            <!-- Trường hợp nếu là Admin thì có checkbox để chọn bài viết "Nổi bật" -->
            <?php if (isset($_SESSION['user_is_admin'])) : ?>
            <div class="form__control inline">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" checked>
                <label for="is_featured">Nổi bật</label>
            </div>
            <?php endif ?>

            <!-- Nội dung bài viết -->
            <textarea rows="8" name="body" placeholder="Body"><?=$post['body']?></textarea>

            <!-- Thay đổi ảnh thumbnail -->
            <div class="form__control">
                <label for="thumbnail">Đổi ảnh</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>

            <!-- Nút để cập nhật bài viết -->
            <button type="submit" name="submit" class="btn">Update Post</button>
        </form>
    </div>
</section>

<?php
include "../partials/footer.php";
?>
