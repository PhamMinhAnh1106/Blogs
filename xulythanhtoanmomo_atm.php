<?php
header('Content-type: text/html; charset=utf-8');
//dữ liệu để test
/*
Tên chủ thẻ: NGUYEN VAN A	
Số thẻ: 9704 0000 0000 0018	
Ngày phát hành: 03/07	
SDT: 0919100100
Mã opt: OTP
*/

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    // Tắt xác minh SSL trong môi trường phát triển
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);

    // Kiểm tra lỗi cURL
    if(curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch); // Hiển thị lỗi nếu có
        curl_close($ch);
        return false;
    }

    curl_close($ch);
    return $result;
}



$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


// Thông tin từ MoMo
$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

$orderInfo = "Thanh toán qua ATM MoMo";
$amount = rand(10000, 100000);
$orderId = time() . "";

$redirectUrl = "http://localhost/Blogs/services.php";
$ipnUrl = "http://localhost/Blogs/services.php";

$extraData = "";

    $requestId = time() . "";
    $requestType = "payWithATM";

    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array('partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature);
    // Gửi yêu cầu POST đến MoMo
$result = execPostRequest($endpoint, json_encode($data));

// Kiểm tra kết quả trả về từ MoMo
if ($result === false) {
    echo "Có lỗi khi kết nối đến MoMo.";
    exit;
}

$jsonResult = json_decode($result, true);  // Giải mã JSON
if (isset($jsonResult['payUrl'])) {
    // Redirect người dùng đến URL thanh toán
    header('Location: ' . $jsonResult['payUrl']);
    exit;
} else {
    echo "Lỗi khi nhận phản hồi từ MoMo: " . $jsonResult['message'];
}

?>