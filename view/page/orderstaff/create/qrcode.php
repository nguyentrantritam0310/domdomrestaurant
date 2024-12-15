<?php
include("../../../../phpqrcode/qrlib.php");

$size = 5;
$orderID = $_GET["orderID"];
$amount = $_GET["amount"];

$bank_code = "MBBank"; 
$account_number = "0941802624";
$amount = "100000";
$note = "Thanh toán dịch vụ";
$currency = "VND";

if ($_GET["type"] == "momo")
    $data = "https://test-payment.momo.vn/v2/gateway/api/create?orderID=".$orderID."&amount=".$amount."";
else     
    $data = "00020101021129370016VN6012" . $bank_code . "970422" . $account_number . "5802" . $currency . "5912" . $amount . "5955" . $note . "620705300100750000";

QRcode::png($data, false, QR_ECLEVEL_L, $size);
?>
