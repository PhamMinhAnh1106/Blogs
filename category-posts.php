<?php
include 'partials/header.php';

// Lấy bài viết nếu id đã được thiết lập
if (isset($_GET['id'])) {
  // Lọc và làm sạch giá trị id
  $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

  // Sử dụng PDO để chuẩn bị và thực thi câu lệnh truy vấn
  $query = "SELECT * FROM posts WHERE category_id = :id ORDER BY date_time DESC";
  $stmt = $connection->prepare($query);
  $stmt->execute(['id' => $id]); // Truyền giá trị id vào câu lệnh SQL
  $posts = $stmt->fetchAll(PDO::FETCH_ASSOC); // Lấy tất cả các bài viết dưới dạng mảng kết hợp
} else {
  header('Location: ' . ROOT_URL . 'blog.php');
  exit; // Nếu không có id, chuyển hướng về trang blog
}

?>

<header class="category__title">
  <?php
  // Truy vấn để lấy thông tin danh mục
  $category_query = "SELECT * FROM categories WHERE id = :id";
  $stmt = $connection->prepare($category_query);
  $stmt->execute(['id' => $id]);
  $category = $stmt->fetch(PDO::FETCH_ASSOC);
  ?>
  <h2><?= htmlspecialchars($category['title']) ?></h2> <!-- Hiển thị tên danh mục -->
</header>

<?php if (!empty($posts)): ?> <!-- Kiểm tra xem có bài viết nào không -->
  <section class="posts">
    <div class="container posts__container">
      <?php foreach ($posts as $post): ?> <!-- Lặp qua tất cả các bài viết -->
        <article class="post">
          <div class="post__thumbnail" style="width: 300px; height: 200px;">
            <img src="./images/<?= htmlspecialchars($post['thumbnail']) ?>" alt="Thumbnail">
          </div>
          <div class="post__info">
            <?php
            // Truy vấn lấy thông tin danh mục của bài viết
            $category_id = $post['category_id'];
            $category_query = "SELECT * FROM categories WHERE id = :category_id";
            $stmt = $connection->prepare($category_query);
            $stmt->execute(['category_id' => $category_id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id'] ?>"
              class="category__button"><?= htmlspecialchars($category['title']) ?></a>
            <h2 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h2>
            <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>">

              <p class="post__body" style="min-height: 100px;">
                <?= substr(html_entity_decode($post['body']), 0, 120) ?>...
              </p>
            </a>

            <div class="post__author">
              <?php
              // Truy vấn để lấy thông tin tác giả từ bảng users
              $author_id = $post['author_id'];
              $author_query = "SELECT * FROM users WHERE id = :author_id";
              $stmt = $connection->prepare($author_query);
              $stmt->execute(['author_id' => $author_id]);
              $author = $stmt->fetch(PDO::FETCH_ASSOC);
              ?>
              <div class="post__author-avatar">
                <img src="./images/<?= htmlspecialchars($author['avatar']) ?>" alt="Avatar">
              </div>
              <div class="post__author-info">
                <h5>By: <?= htmlspecialchars($author['firstname'] . ' ' . $author['lastname']) ?></h5>
                <small><?= date("M d, Y - H:i", strtotime($post['date_time'])) ?></small>
              </div>
            </div>
          </div>
        </article>
      <?php endforeach ?>

    </div>
  </section>
<?php else: ?>
  <div class="alert__message error lg">
    <p>
      No posts found for this category
    </p>
  </div>
<?php endif ?>

<section class="category__buttons">
  <div class="container category__buttons-container">
    <?php
    // Truy vấn lấy tất cả danh mục
    $all_categories_query = "SELECT * FROM categories";
    $stmt = $connection->prepare($all_categories_query);
    $stmt->execute();
    $all_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <?php foreach ($all_categories as $category): ?>
      <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>"
        class="category__button"><?= htmlspecialchars($category['title']) ?></a>
    <?php endforeach ?>
  </div>
</section>

<?php
include './partials/footer.php';
?>
