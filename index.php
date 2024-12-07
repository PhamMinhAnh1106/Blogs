<?php 
include 'partials/header.php';

// Kết nối PDO
try {
    // Kết nối cơ sở dữ liệu bằng PDO
    $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Cấu hình chế độ lỗi, sẽ ném ra ngoại lệ nếu có lỗi
} catch (PDOException $e) {
    // Nếu kết nối thất bại, thông báo lỗi và dừng chương trình
    die("Connection failed: " . $e->getMessage());
}

// Fetch bài viết nổi bật
$featured_query = "SELECT * FROM posts WHERE is_featured=1";
$featured_stmt = $connection->prepare($featured_query); // Chuẩn bị câu truy vấn
$featured_stmt->execute(); // Thực thi câu truy vấn
$featured = $featured_stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả

// Fetch 9 bài viết gần đây
$query = "SELECT * FROM posts WHERE is_featured=0 ORDER BY date_time DESC LIMIT 9";
$posts_stmt = $connection->prepare($query); // Chuẩn bị câu truy vấn
$posts_stmt->execute(); // Thực thi câu truy vấn

?>

<?php if ($featured) : ?>
<section class="featured">
    <div class="container featured__container">
        <div class="post__thumbnail">
            <img src="./images/<?= $featured['thumbnail'] ?>">
        </div>
        <div class="post__info">
            <?php
            // Fetch danh mục của bài viết nổi bật
            $category_id = $featured['category_id'];
            $category_query = "SELECT * FROM categories WHERE id = :category_id"; // Sử dụng tham số để bảo mật
            $category_stmt = $connection->prepare($category_query); // Chuẩn bị câu truy vấn
            $category_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT); // Liên kết tham số
            $category_stmt->execute(); // Thực thi câu truy vấn
            $category = $category_stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả

            // Fetch tác giả của bài viết
            $author_id = $featured['author_id'];
            $author_query = "SELECT * FROM users WHERE id = :author_id"; // Sử dụng tham số để bảo mật
            $author_stmt = $connection->prepare($author_query); // Chuẩn bị câu truy vấn
            $author_stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT); // Liên kết tham số
            $author_stmt->execute(); // Thực thi câu truy vấn
            $author = $author_stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả
            ?>
            <a href="category-posts.php?id=<?= $category_id ?>" class="category__button"><?= $category['title'] ?></a>
            <h2 class="post__title"><a href="post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a></h2>
            <p class="post__body">
                <?= substr(html_entity_decode($featured['body']), 0, 300) ?>...
            </p>
            <div class="post__author-avatar">
                <img src="./images/<?= $author['avatar'] ?>">
            </div>
            <div class="post__author-info">
                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($featured['date_time'])) ?></small>
            </div>
        </div>
    </div>
</section>
<?php endif ?> 
<!-- ===================END OF FEATURED================-->

<!-- #region POSTS -->
<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
  <div class="container posts__container">
    <?php while ($post = $posts_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
      <article class="post">
        <div class="post__thumbnail" style="width: 300px; height: 200px;">
          <img src="./images/<?= $post['thumbnail'] ?>" >
        </div>
        <div class="post__info">
          <?php
          // Fetch danh mục của bài viết
          $category_id = $post['category_id'];
          $category_query = "SELECT * FROM categories WHERE id = :category_id"; // Sử dụng tham số để bảo mật
          $category_stmt = $connection->prepare($category_query); // Chuẩn bị câu truy vấn
          $category_stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT); // Liên kết tham số
          $category_stmt->execute(); // Thực thi câu truy vấn
          $category = $category_stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả
          ?>
          <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
          <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
          <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">
            <p class="post__body" style="min-height: 100px;">
              <?= substr($post['body'], 0, 150) ?>...
            </p>
          </a>
          <div class="post__author">
            <?php
            // Fetch tác giả của bài viết
            $author_id = $post['author_id'];
            $author_query = "SELECT * FROM users WHERE id = :author_id"; // Sử dụng tham số để bảo mật
            $author_stmt = $connection->prepare($author_query); // Chuẩn bị câu truy vấn
            $author_stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT); // Liên kết tham số
            $author_stmt->execute(); // Thực thi câu truy vấn
            $author = $author_stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả
            ?>
            <div class="post__author-avatar">
              <img src="./images/<?= $author['avatar'] ?>" alt="" />
            </div>
            <div class="post__author-info">
              <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
              <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
            </div>
          </div>
        </div>
      </article>
    <?php endwhile; ?>
  </div>
</section>
<!-- #endregion POSTS -->

<!-- #region CATEGORIES -->
<section class="category__buttons">
  <div class="container category__buttons-container">
      <?php
      // Fetch tất cả các danh mục
      $all_categories_query = "SELECT * FROM categories";
      $all_categories_stmt = $connection->prepare($all_categories_query); // Chuẩn bị câu truy vấn
      $all_categories_stmt->execute(); // Thực thi câu truy vấn
      ?>
      <?php while ($category = $all_categories_stmt->fetch(PDO::FETCH_ASSOC)) : ?>
      <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
      <?php endwhile ?>
  </div>
</section>
<!-- #endregion CATEGORIES -->

<?php
include './partials/footer.php';
?>
