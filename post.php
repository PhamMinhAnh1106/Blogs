<?php
include 'partials/header.php';

// Lấy bài viết theo ID từ URL
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Truy vấn bài viết
    $query = "SELECT * FROM posts WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    // Lấy thông tin tác giả của bài viết
    if ($post) {
        $author_id = $post['author_id'];
        $author_query = "SELECT * FROM users WHERE id = :author_id";
        $author_stmt = $connection->prepare($author_query);
        $author_stmt->bindParam(':author_id', $author_id, PDO::PARAM_INT);
        $author_stmt->execute();
        $author = $author_stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Nếu không tìm thấy bài viết
        header('location: ' . ROOT_URL . 'blog.php');
        die();
    }
} else {
    // Nếu không có ID trong URL, chuyển hướng về trang blog
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<section class="singlepost">
    <div class="container singlepost__container">

        <h2>
            <?= htmlspecialchars($post['title']) ?>
        </h2>

        <div class="post__author">
            <div class="post__author-avatar">
                <img src="./images/<?= htmlspecialchars($author['avatar']) ?>">
            </div>
            <div class="post__author-info">
                <h5>By: <?= "{$author['firstname']} {$author['lastname']}" ?></h5>
                <small>
                    <?= date("M d, Y - H:i", strtotime($post['date_time'])) ?>
                </small>
            </div>
        </div>

        <div class="singlepost__thumbnail">
            <img src="./images/<?= htmlspecialchars($post['thumbnail']) ?>">
            <div style="width: auto; display: flex; flex-direction: row; gap: 10px;">
                <span><h2 style="font-size: x-large; text-decoration: underline;">Mua ngay tấm hình này: </h2></span>
                <!-- Start- Thanh toán momo QR code button form    -->
                <form class="" method="post" target="" enctype="application/x-www-form-urlencoded" action="xulythanhtoanmomo.php">
                    <input type="submit" name="momo" style="font-weight: bolder;" value="Thanh toán MOMO QR code" class="btn">
                </form>
                <!-- End- Thanh toán momo QR code button form    -->
                
                <!-- Start- Thanh toán momo ATM button form    -->
                <form class="" method="post" target="" enctype="application/x-www-form-urlencoded" action="xulythanhtoanmomo_atm.php">
                    <input type="submit" name="momo" style="font-weight: bolder;" value="Thanh toán MOMO ATM" class="btn">
                </form>
                <!-- End- Thanh toán momo ATM button form    -->

            </div>

        </div>

        <p><?= nl2br(htmlspecialchars($post['body'])) ?></p>

    </div>
</section>

<?php
include './partials/footer.php';
?>