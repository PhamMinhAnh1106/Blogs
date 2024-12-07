<?php
include "partials/header.php";

// Kiểm tra xem người dùng có phải là admin không, nếu không thì đăng xuất
if (!isset($_SESSION['user_is_admin'])) {
    header("location: " . ROOT_URL . "logout.php");
    // Huỷ tất cả session và chuyển hướng người dùng về trang đăng nhập
    session_destroy();
}

// Nếu có id trong URL, lấy thông tin người dùng
if (isset($_GET['id'])) {
    // Làm sạch id từ URL
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Truy vấn lấy thông tin người dùng từ cơ sở dữ liệu bằng PDO
    $query = "SELECT firstname, lastname, is_admin FROM users WHERE id = :id";
    $stmt = $connection->prepare($query);
    $stmt->execute([':id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Nếu không có id, chuyển hướng về trang quản lý người dùng
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
}
?>

<section class="form__section">
    <div class="container form__section-container">
        <h2>Edit User</h2>

        <!-- Form chỉnh sửa người dùng -->
        <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" enctype="multipart/form-data" method="POST">
            <input type="hidden" value="<?= $id ?>" name='id'>
            <input type="text" name="firstname" value="<?= $user['firstname'] ?>" placeholder="First Name">
            <input type="text" name="lastname" value="<?= $user['lastname'] ?>" placeholder="Last Name">
            
            <!-- Chọn quyền người dùng (admin hoặc user) -->
            <select name="userrole">
                <option <?= $user['is_admin'] ? 'selected' : '' ?> value="1">Admin</option>
                <option <?= !$user['is_admin'] ? 'selected' : '' ?> value="0">User</option>
            </select>
            
            <!-- Nút để cập nhật người dùng -->
            <button type="submit" name="submit" class="btn">Update User</button>
        </form>
    </div>
</section>

<?php
include "../partials/footer.php";
?>
