<?php

include "config/constants.php";

// Lấy lại dữ liệu từ form nếu có lỗi đăng ký
$firstname=$_SESSION['signup-data']['firstname'] ?? null; // Lấy tên
$lastname=$_SESSION['signup-data']['lastname'] ?? null;   // Lấy họ
$username=$_SESSION['signup-data']['username'] ?? null;   // Lấy tên người dùng
$email=$_SESSION['signup-data']['email'] ?? null;         // Lấy email
$createpassword=$_SESSION['signup-data']['createpassword'] ?? null; // Lấy mật khẩu
$confirmpassword = $_SESSION['signup-data']['confirmpassword'] ?? null; // Lấy xác nhận mật khẩu

// Xóa dữ liệu đăng ký trong session
unset($_SESSION['signup-data']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNDEREMPLOYED</title>
    <!-- CUSTOM STYLESHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <!-- ICONSCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONT(MONTSERATE) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,800;1,700&display=swap" rel="stylesheet"> 
</head>
<body>

<section class="form__section">

    <div class="container form__section-container">
        <h2>Sign Up</h2>
        <?php
        // Hiển thị thông báo lỗi nếu có
        if(isset($_SESSION['signup'])): ?> 
            <div class="alert__message error">
            <p>
                <?= $_SESSION['signup']; // Hiển thị thông báo lỗi
                unset($_SESSION['signup']); // Xóa thông báo lỗi
                ?>
            </p>
            
            </div>
        
        <?php endif ?>
        
        <!-- Form đăng ký người dùng -->
        <form action="<?=ROOT_URL?>signup-logic.php" enctype="multipart/form-data" method="POST">
            <input type="text"     name ="firstname"       value ="<?= $firstname?>"  placeholder="First Name"> <!-- Nhập tên -->
            <input type="text"     name ="lastname"        value ="<?= $lastname?>"  placeholder="Last Name"> <!-- Nhập họ -->
            <input type="username"     name ="username"        value ="<?= $username?>"  placeholder="Username"> <!-- Nhập tên người dùng -->
            <input type="email"    name ="email"           value ="<?= $email?>"  placeholder="Email"> <!-- Nhập email -->
            <input type="password" name ="createpassword"  value ="<?= $createpassword?>"  placeholder="Password"> <!-- Nhập mật khẩu -->
            <input type="password" name ="confirmpassword" value ="<?= $confirmpassword?>"  placeholder="Confirm Password"> <!-- Nhập xác nhận mật khẩu -->
            
            <div class="form__control">
                <label for="avatar">User Avatar</label> <!-- Chọn ảnh đại diện -->
                <input type="file" name="avatar" id="avatar"> <!-- Tải lên ảnh đại diện -->
            </div>
            
            <button type="submit" name ="submit" class="btn">Sign Up</button> <!-- Nút đăng ký -->
            <small>Already have an Account? <a href="signin.php">Sign in</a></small> <!-- Liên kết đến trang đăng nhập -->
        </form>
    </div>

</section>

</body>
</html>
