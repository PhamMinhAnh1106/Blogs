<?php
require 'partials/header.php';

// Nếu có input tìm kiếm
if (isset($_GET['search']) && isset($_GET['submit'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Truy vấn tìm kiếm bài viết
    $query = "SELECT * FROM posts WHERE title LIKE :search ORDER BY date_time DESC";
    $stmt = $connection->prepare($query);
    $search_term = '%' . $search . '%';  // Thêm ký tự % để tìm kiếm phần từ
    $stmt->bindParam(':search', $search_term, PDO::PARAM_STR);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    header("location: " . ROOT_URL . 'blog.php');
    die();
}
?>

<?php if (count($posts) > 0) : ?>
<section class="posts section__extra-margin">
    <div class="container posts__container">
        <?php foreach ($posts as $post) : ?>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./images/<?= htmlspecialchars($post['thumbnail']) ?>" >
            </div>
            <div class="post__info">
                <?php
                // Fetch category
                $category_id = $post['category_id'];
                $category_query = "SELECT * FROM categories WHERE id = :category_id";
                $category_stmt = $connection->prepare($category_query);
                $category_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
                $category_stmt->execute();
                $category = $category_stmt->fetch(PDO::FETCH_ASSOC);

                // Fetch author
                $author_id = $post['author_id'];
                $author_query = "SELECT * FROM users WHERE id = :author_id";
                $author_stmt = $connection->prepare($author_query);
                $author_stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
                $author_stmt->execute();
                $author = $author_stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <a href="category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= htmlspecialchars($category['title']) ?></a>
                <h3 class="post__title"><a href="post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
                <p class="post__body">
                    <?= substr(html_entity_decode($post['body']), 0, 150) ?>...
                </p>
                <div class="post__author">
                    <div class="post__author-avatar">
                        <img src="./images/<?= htmlspecialchars($author['avatar']) ?>">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= htmlspecialchars("{$author['firstname']} {$author['lastname']}") ?></h5>
                        <small>
                            <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php else : ?>
    <div class="alert__message error lg section__extra-margin">
        <p>No post found for this search</p>
    </div>
<?php endif; ?>

<!-- ========================= END OF POSTS ============================= -->
<section class="category__buttons">
    <div class="container category__buttons-container">
        <?php
        // Lấy tất cả các thể loại bài viết
        $all_categories_query = "SELECT * FROM categories";
        $all_categories_stmt = $connection->prepare($all_categories_query);
        $all_categories_stmt->execute();
        $all_categories = $all_categories_stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($all_categories as $category) : ?>
        <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= htmlspecialchars($category['title']) ?></a>
        <?php endforeach; ?>
    </div>
</section>
<!-- ========================== END OF CATEGORY ========================= -->

<?php
include './partials/footer.php';
?>
