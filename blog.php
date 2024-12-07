<?php 
include 'partials/header.php';  // Bao gồm file header.php

// Truy vấn bài viết nổi bật
$featured_query = "SELECT * FROM posts WHERE is_featured = 1";
$featured_stmt = $connection->prepare($featured_query);  // Chuẩn bị truy vấn
$featured_stmt->execute();  // Thực thi truy vấn
$featured = $featured_stmt->fetch(PDO::FETCH_ASSOC);  // Lấy dữ liệu bài viết nổi bật

// Truy vấn lấy 9 bài viết mới nhất
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts_stmt = $connection->prepare($query);  // Chuẩn bị truy vấn
$posts_stmt->execute();  // Thực thi truy vấn
$posts = $posts_stmt->fetchAll(PDO::FETCH_ASSOC);  // Lấy tất cả bài viết

?>
<section class="search__bar">
    <form class="container search__bar-container" action="<?=ROOT_URL?>search.php" method="GET">
        <div>
            <i class="uil uil-search"></i>  <!-- Biểu tượng tìm kiếm -->
            <input type="search" name="search" placeholder="Search">  <!-- ô tìm kiếm -->
            <button type="submit" name="submit" class="btn">Go</button>  <!-- Nút tìm kiếm -->
        </div>
    </form>
</section>

<!-- ===================END OF SEARCH================-->

<!-- #region POSTS -->
<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>"> <!-- Nếu có bài viết nổi bật thì không có margin, ngược lại có margin -->
    <div class="container posts__container">
        <?php foreach ($posts as $post) : ?>  <!-- Lặp qua từng bài viết -->
            <article class="post">
                <div class="post__thumbnail" style="width: 300px; height: 200px;">
                    <img src="./images/<?= $post['thumbnail'] ?>" >  <!-- Hiển thị hình ảnh bài viết -->
                </div>
                <div class="post__info">
                    <?php 
                    // Lấy danh mục bài viết từ bảng categories thông qua category_id
                    $category_id = $post['category_id'];
                    $category_query = "SELECT * FROM categories WHERE id = :category_id";
                    $category_stmt = $connection->prepare($category_query);
                    $category_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                    $category_stmt->execute();
                    $category = $category_stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>  <!-- Liên kết tới danh mục -->
                    <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>  <!-- Tiêu đề bài viết -->
                    <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">
                        <p class="post__body" style="min-height: 100px;">
                            <?= substr(html_entity_decode($post['body']), 0, 120) ?>...  <!-- Lấy đoạn trích bài viết -->
                        </p>
                    </a>

                    <div class="post__author">
                        <?php 
                        // Lấy tác giả từ bảng users thông qua author_id
                        $author_id = $post['author_id'];
                        $author_query = "SELECT * FROM users WHERE id = :author_id";
                        $author_stmt = $connection->prepare($author_query);
                        $author_stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
                        $author_stmt->execute();
                        $author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="post__author-avatar">
                            <img src="./images/<?= $author['avatar'] ?>" alt="" />  <!-- Hiển thị ảnh đại diện tác giả -->
                        </div>
                        <div class="post__author-info">
                            <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>  <!-- Tên tác giả -->
                            <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>  <!-- Ngày giờ đăng bài -->
                        </div>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>  <!-- Kết thúc vòng lặp qua bài viết -->
    </div>
</section>
<!-- ========================== END OF THE POSTS ========================== -->

<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php 
        // Lấy tất cả danh mục từ bảng categories
        $all_categories_query = "SELECT * FROM categories";
        $all_categories_stmt = $connection->prepare($all_categories_query);
        $all_categories_stmt->execute();
        $all_categories = $all_categories_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($all_categories as $category) : ?>  <!-- Lặp qua tất cả danh mục -->
            <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category__button"><?=$category['title']?></a>  <!-- Liên kết tới trang danh mục -->
        <?php endforeach ?>
    </div>
</section>
<!--=======================END OF CATEGORY ===================================-->

<?php
include './partials/footer.php';  // Bao gồm file footer.php
?>
