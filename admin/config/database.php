<?php
require "constants.php";

try {
    // Tạo kết nối PDO
    $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connection->exec("SET NAMES 'utf8mb4'");
    // Đặt chế độ báo lỗi của PDO là exception
} catch (PDOException $e) {
    // Nếu có lỗi, dừng và hiển thị thông báo lỗi
    die("Connection failed! " );
}
?>
