<?php
include 'config/constants.php';  // Kết nối với các hằng số cấu hình (ví dụ: đường dẫn cơ sở dữ liệu, ROOT_URL)

// Lấy dữ liệu đăng nhập từ session, nếu có
$username_email = $_SESSION['signin-data']['username_email'] ?? null; // Lấy username hoặc email từ session
$password = $_SESSION['signin-data']['password'] ?? null; // Lấy mật khẩu từ session

// Xóa dữ liệu đăng nhập khỏi session sau khi sử dụng
unset($_SESSION['signin-data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  <!-- Định nghĩa bộ ký tự -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">  <!-- Đảm bảo hiển thị đúng trên các trình duyệt hiện đại -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  <!-- Đảm bảo tính tương thích với thiết bị di động -->
    <title>UNDEREMPLOYED</title>  <!-- Tiêu đề trang -->
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="./css/style.css">  <!-- Liên kết tới file CSS tùy chỉnh -->
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">  <!-- Liên kết tới biểu tượng từ Iconscout -->
    <!-- GOOGLE FONT(MONTSERATE) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,800;1,700&display=swap" rel="stylesheet">  <!-- Liên kết tới Google Font -->
</head>
<body>
<section class="form__section">  <!-- Phần chứa form đăng nhập -->
    <div class="container form__section-container">
        <h2>Sign In</h2>  <!-- Tiêu đề của trang -->
        
        <?php
        // Kiểm tra nếu có thông báo thành công khi đăng ký
        if(isset($_SESSION['signup-success'])): 
        ?> 
            <div class="alert__message success">
            <p>
                <?= $_SESSION['signup-success'];  // Hiển thị thông báo thành công khi đăng ký
                unset($_SESSION['signup-success']);  // Xóa thông báo sau khi đã hiển thị
                ?>
            </p>
            </div>
        <?php elseif(isset($_SESSION['signin'])): ?>  <!-- Kiểm tra nếu có thông báo lỗi khi đăng nhập -->
            <div class="alert__message error">
                <p>
                    <?=$_SESSION['signin'];  // Hiển thị thông báo lỗi khi đăng nhập
                    unset($_SESSION['signin']);  // Xóa thông báo sau khi đã hiển thị
                    ?>
                </p>
            </div>
        <?php endif; ?>
        
        <!-- Form đăng nhập -->
        <form action="<?= ROOT_URL ?>signin-logic.php" method="POST">
            <!-- Trường nhập tên người dùng hoặc email -->
            <input type="text" name="username_email" value='<?= $username_email ?>' placeholder="Username or Email">
            <!-- Trường nhập mật khẩu -->
            <input type="password" name="password" value='<?= $password ?>' placeholder="Password">
            <!-- Nút đăng nhập -->
            <button type="submit" class="btn" name="submit">Sign in</button>
            <!-- Liên kết tới trang đăng ký nếu người dùng chưa có tài khoản -->
            <small>Don't have an account? <a href="signup.php">Sign up</a></small>
        </form>
    </div>
</section>
</body>
</html>
