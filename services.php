
<?php
include 'partials/header.php';
?>
<div class="lichsupage">
<section class="empty__page ">
    
<?php

// Kết nối cơ sở dữ liệu bằng PDO
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage());
}

// Kiểm tra xem các thông tin cần thiết có trong URL hay không
if (isset($_GET['partnerCode'], $_GET['orderId'], $_GET['amount'], $_GET['orderInfo'], $_GET['orderType'], $_GET['transId'], $_GET['payType'])) {
    try {
        // Lấy thông tin từ URL
        $partnerCode = $_GET['partnerCode'];
        $orderId = $_GET['orderId'];
        $amount = $_GET['amount'];
        $orderInfo = $_GET['orderInfo'];
        $orderType = $_GET['orderType'];
        $transId = $_GET['transId'];
        $payType = $_GET['payType'];

        // Lưu thông tin vào cơ sở dữ liệu
        $insert_query = "INSERT INTO momopay (partner_code, id_order, amount, order_info, order_type, id_trans, pay_type) 
                         VALUES (:partner_code, :id_order, :amount, :order_info, :order_type, :id_trans, :pay_type)";
        $stmt = $pdo->prepare($insert_query);
        $stmt->execute([
            ':partner_code' => $partnerCode,
            ':id_order' => $orderId,
            ':amount' => $amount,
            ':order_info' => $orderInfo,
            ':order_type' => $orderType,
            ':id_trans' => $transId,
            ':pay_type' => $payType,
        ]);

        // Lưu thông tin vào session để hiển thị sau này
        $_SESSION['order_info'] = [
            'partnerCode' => $partnerCode,
            'orderId' => $orderId,
            'amount' => $amount,
            'orderInfo' => $orderInfo,
            'orderType' => $orderType,
            'transId' => $transId,
            'payType' => $payType
        ];

        // Hiển thị thông tin ra màn hình
        // echo '<h2>Chi tiết đơn hàng</h2>';
        // echo '<p><strong>Partner Code:</strong> ' . htmlspecialchars($partnerCode) . '</p>';
        // echo '<p><strong>Order ID:</strong> ' . htmlspecialchars($orderId) . '</p>';
        // echo '<p><strong>Amount:</strong> ' . htmlspecialchars($amount) . '</p>';
        // echo '<p><strong>Order Info:</strong> ' . htmlspecialchars($orderInfo) . '</p>';
        // echo '<p><strong>Order Type:</strong> ' . htmlspecialchars($orderType) . '</p>';
        // echo '<p><strong>Transaction ID:</strong> ' . htmlspecialchars($transId) . '</p>';
        // echo '<p><strong>Pay Type:</strong> ' . htmlspecialchars($payType) . '</p>';

    } catch (PDOException $e) {
        // Xử lý lỗi khi lưu thông tin
        echo '<h3>Lỗi khi lưu dữ liệu:</h3>';
        echo '<p>' . $e->getMessage() . '</p>';
    }
} else {
    // Truy vấn tất cả đơn hàng từ cơ sở dữ liệu
    try {
        $query = "SELECT * FROM momopay";
        $stmt = $pdo->query($query);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($orders) > 0) {
            echo '<h2>Lịch sử chi tiết đơn hàng</h2>';
            foreach ($orders as $order) {
               
                echo '<div class="order-item">';
                echo "<div style='height: 1px; background-color: #ccc; margin: 20px 0;'></div>";
                echo '<p><strong>Partner Code:</strong> ' . htmlspecialchars($order['partner_code']) . '</p>';
                echo '<p><strong>Order ID:</strong> ' . htmlspecialchars($order['id_order']) . '</p>';
                echo '<p><strong>Amount:</strong> ' . htmlspecialchars($order['amount']) . '</p>';
                echo '<p><strong>Order Info:</strong> ' . htmlspecialchars($order['order_info']) . '</p>';
                echo '<p><strong>Order Type:</strong> ' . htmlspecialchars($order['order_type']) . '</p>';
                echo '<p><strong>Transaction ID:</strong> ' . htmlspecialchars($order['id_trans']) . '</p>';
                echo '<p><strong>Pay Type:</strong> ' . htmlspecialchars($order['pay_type']) . '</p>';
                echo '</div><hr>';
            }
        } else {
            echo '<p>Không có đơn hàng nào để hiển thị.</p>';
        }

    } catch (PDOException $e) {
        // Xử lý lỗi khi truy vấn dữ liệu
        echo '<h3>Lỗi khi truy vấn dữ liệu:</h3>';
        echo '<p>' . $e->getMessage() . '</p>';
    }
}

?>

</section>
</div>
<?php
include './partials/footer.php';
?>

