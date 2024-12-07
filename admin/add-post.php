<?php
include "partials/header.php";

// Truy vấn cơ sở dữ liệu để lấy danh sách các danh mục (categories)
$query = "SELECT * FROM categories";
$statement = $connection->prepare($query); 
$statement->execute(); 
$categories = $statement->fetchAll(PDO::FETCH_ASSOC); 

// Lấy lại dữ liệu form nếu form trước đó không hợp lệ (dữ liệu lưu trong session)
$title = $_SESSION['add-post-data']['title'] ?? null; 
$body = $_SESSION['add-post-data']['body'] ?? null; 
unset($_SESSION['add-post-data']); 

?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Thêm Bài Viết</h2>
        
        <?php if(isset($_SESSION['add-post'])) : ?>
        <!-- Hiển thị thông báo lỗi nếu có -->
        <div class="alert__message error">
            <p>
                <?= $_SESSION['add-post']; unset($_SESSION['add-post']); // Hiển thị thông báo lỗi và xóa dữ liệu trong session ?>
            </p>
        </div>
        <?php endif ?>
        
        <!-- Form thêm bài viết -->
        <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text" name="title" value ="<?= $title ?>" placeholder="Tiêu đề">
            <select name="category_id">
                <?php foreach($categories as $category) : ?>
                <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                <?php endforeach ?>
            </select>

            <?php if(isset($_SESSION["user_is_admin"])) : ?>
            <div class="form__control inline">
                <input type="checkbox" name="is_featured" value='1' id="is_featured" checked>
                <label for="is_featured" >Nổi bật</label>
            </div>
            <?php endif ?>
            <textarea rows="8" name="body" placeholder="Nội dung"><?= $body ?></textarea>
            <div class="form__control">
                <label for="thumbnail">Thêm Hình Thu Nhỏ</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Thêm Bài Viết</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
