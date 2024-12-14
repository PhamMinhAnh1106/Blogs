<?php
require 'config/database.php'; // Bao gồm file kết nối cơ sở dữ liệu

if (isset($_SESSION['user-id'])) {
    // Lọc và làm sạch dữ liệu user-id từ session
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);

    // Truy vấn lấy avatar của người dùng từ cơ sở dữ liệu
    $query = "SELECT avatar FROM users WHERE id = :id";
    $stmt = $connection->prepare($query); // Chuẩn bị câu lệnh
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Gắn tham số vào câu lệnh
    $stmt->execute(); // Thực thi truy vấn
    $avatar = $stmt->fetch(PDO::FETCH_ASSOC); // Lấy kết quả và trả về dưới dạng mảng kết hợp
}
?>

<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="max-age=3600">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>

    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">

    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <!-- GOOGLE FONT(MONTSERATE) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,800;1,700&display=swap" rel="stylesheet">



    <style>
        .nav-bar-tilte-hover {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .nav-bar-tilte-hover:hover {
            color: var(--color-red);
            transform: scale(1.5);
        }

        /* About Us css*/
        .Bg-Block {
            background-color: rgba(138, 133, 133, 0.5);
            padding: 10px;
            border-radius: 10px;
        }

        .site-inner {
            clear: both;
            margin: 0 auto;
            padding: 40px 0;
            color: #fff;
        }

        .container-fluid {
            padding-left: 0px;
        }

        .site-inner,
        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            /* Combined left/right margins */
        }

        .container2 {
            display: flex;
            padding: 20px 20px;
        }

        .content {
            flex: 1;
            padding: 20px;
            text-align: center;
            color: #fff;
        }
        .content2 {
            flex: 1;
            padding: 50px;
            text-align: center;
            color: #fff;
        }
        .content-right {
            flex: 4;
            margin-right: 50px;
            margin-top: 10px;
        }

        .content-left {
            flex: 1;
            margin-left: 50px;
        }

    
    </style>
</head>

<body>

    <nav>
        <div class="container nav__container">
            <a href="<?= ROOT_URL ?>index.php" class="nav__logo">
                <h2 style="font-style: oblique;">WallPaper 4K</h3>
            </a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php" class="nav-bar-tilte-hover">Bài Viết</a></li>
                <li><a href="<?= ROOT_URL ?>services.php" class="nav-bar-tilte-hover">Lịch Sử</a></li>
                <li><a href="<?= ROOT_URL ?>about.php" class="nav-bar-tilte-hover">About Us</a></li>
                <?php if (isset($_SESSION['user-id'])) : ?>

                    <li class="nav__profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>">
                        </div>
                        <ul style="width:200px;">
                            <li><a href="<?= ROOT_URL ?>/admin/index.php">Quản Lý Tài Khoản</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Đăng Xuất</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?= ROOT_URL ?>signin.php" class="nav-bar-tilte-hover">Đăng Nhập</a></li>
                <?php endif ?>
            </ul>

            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- ======================== END OF NAV ======================== -->