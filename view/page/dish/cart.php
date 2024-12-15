<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="shortcut icon" href="../../../images/logo-nobg.png" type="image/x-icon">
    <link rel="stylesheet" href="../../../view/css/all.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="../../../view/js/tailwindcss.js"></script>
    <script src="../../../view/js/all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../../view/js/order.js" defer></script>
</head>

<?php
error_reporting(1);
session_start();

include("../../../model/connect.php");
include("../../../controller/cPromotions.php");
include("../../../controller/cOders.php");

if (isset($_POST["action"])) {
    list($action, $dishID) = explode("/", $_POST["action"]);
    foreach ($_SESSION["cart"] as &$item) {
        if ($item["id"] == $dishID) {
            if ($action == "increase") {
                $item["quantity"]++;
            } elseif ($action == "decrease" && $item["quantity"] > 1) {
                $item["quantity"]--;
            }
            $item["total"] = $item["quantity"] * $item["price"];
            break;
        }
    }
    unset($item);
}

if (isset($_POST["btndel"])) {
    $dishID = $_POST["btndel"];
    foreach ($_SESSION["cart"] as $key => $item) {
        if ($item["id"] == $dishID) {
            unset($_SESSION["cart"][$key]);
            break;
        }
    }
    if (count($_SESSION["cart"]) == 0)
        unset($_SESSION["cart"]);
}

if (isset($_POST["clear"]) || !isset($_SESSION["cart"])) {
    unset($_SESSION["cart"]);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION["formData"] = [
        "name" => $_POST["name"],
        "phone" => $_POST["phone"],
        "email" => $_POST["email"],
        "address" => $_POST["address"],
    ];
}

if (isset($_GET["out"])) {
    unset($_SESSION["formData"]);
    header("Location: ../../../index.php?p=dish");
}
?>

<body>
    <div class="box-1">
        <div
            class="fixed top-5 left-5 px-3 py-1 bg-gray-200 rounded-lg w-12 h-8 btn-one hover:w-fit overflow-hidden linear transition-all delay-200">
            <a href="cart.php?out">
                <i class="fa-solid fa-arrow-left mr-2"></i>Tiếp tục đặt món
            </a>
        </div>
    </div>

    <h2 class="my-8 font-bold text-center text-3xl text-[#EF5350] w-3/5 mx-auto">Giỏ Hàng</h2>
    <form action="" method="POST" class="" novalidate>
        <div class="w-2/3 flex mx-auto shadow rounded-lg border-amber-400 border-2">
            <div class="p-8 w-2/3 border-r-2 border-amber-400 flex flex-col">
                <?php
                $total = 0;

                if (isset($_SESSION["cart"])) {
                    foreach ($_SESSION["cart"] as $cart) {
                        echo "<div class='flex justify-between items-center border-b pb-4 mb-4'>";
                        echo "<img alt='" . $cart["name"] . "' class='w-20 h-20 object-cover rounded' height='100' width='100' src='../../../images/dish/" . $cart["image"] . "' />";
                        echo "<div class='ml-4 flex-1'>
                            <h3 class='text-lg font-semibold'>" . $cart["name"] . "</h3>
                            <div class='flex items-center mt-2 w-full'>
                                <h4 class='text-gray-500 w-1/2'>" . number_format($cart["price"], 0, ".", ",") . " đ</h4>
                                <div class='flex w-fit items-center border rounded ml-2'>
                                    <button type='submit' class='px-2 py-1 decrease' name='action' value='decrease/" . $cart["id"] . "'>-</button>
                                    <span class='px-2'>" . $cart["quantity"] . "</span>
                                    <button type='submit' class='px-2 py-1 increase' name='action' value='increase/" . $cart["id"] . "'>+</button>
                                </div>
                            </div>
                        </div>";
                        echo "<div class='text-right'>
                            <p class='text-lg font-semibold' name='totalAmount'>" . number_format($cart["total"], 0, ".", ",") . " đ</p>
                            <div class='mt-2'>
                                <button type='submit' class='btn btn-secondary w-full' name='btndel' value='" . $cart["id"] . "'>
                                    <i class='far fa-trash-alt mr-2'></i>Xóa
                                </button>
                            </div>
                        </div>";
                        echo "</div>";

                        $total += $cart["total"];
                    }
                } else {
                    echo "<div class='flex justify-center items-center w-full h-full text-gray-400'>Giỏ hàng đang trống!</div>";
                }
                ?>
            </div>

            <div class="w-1/3 p-8">
                <h3 class="font-bold text-2xl mb-3 pb-2 pl-3 border-b-2 border-l-8 border-amber-200">Thông tin thanh
                    toán</h3>
                <div>
                    <label for="name" class="form-label mt-3">Họ tên:</label>
                    <input type="text" name="name" id="name" class="form-control" required pattern="^[a-zA-ZÀ-ỹ\s]+$"
                        value="<?php echo $_SESSION["formData"]["name"]; ?>">
                    <div id="name-error" class="text-red-500 text-sm"></div>

                    <label for="phone" class="form-label mt-3">Số điện thoại:</label>
                    <input type="text" name="phone" id="phone" class="form-control" required
                        pattern="^((0[1-9]{1}[0-9]{8})|(\+84[1-9]{1}[0-9]{8}))$"
                        value="<?php echo $_SESSION["formData"]["phone"]; ?>">
                    <div id="phone-error" class="text-red-500 text-sm"></div>


                    <label for="email" class="form-label mt-3">Email:</label>
                    <input type="text" name="email" id="email" class="form-control" required
                        pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                        value="<?php echo $_SESSION["formData"]["email"]; ?>">
                    <div id="email-error" class="text-red-500 text-sm"></div>

                    <label for="address" class="form-label mt-3">Địa chỉ nhận:</label>
                    <input type="text" name="address" id="address" class="form-control" required
                        pattern="^[a-zA-Z0-9À-ỹ\s].*" title="Địa chỉ phải bắt đầu bằng chữ cái hoặc chữ số"
                        value="<?php echo $_SESSION["formData"]["address"]; ?>">
                    <div id="address-error" class="text-red-500 text-sm"></div>

                </div>
                <div class="flex justify-between">
                    <h2 class='font-bold text-xl'>Tổng đơn:</h2>
                    <?php echo number_format($total, 0, ".", ",") . " đ"; ?>
                </div>
                <div class="mt-3 flex justify-between">
                    <button class="btn btn-secondary" name="clear">Xóa tất cả</button>
                    <button type="button" class="btn btn-danger" id="submitButton" onclick="validateAndFillModal()">Xác
                        nhận</button>
                </div>
            </div>

            <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header justify-center">
                            <h2 class="modal-title fs-5 font-bold text-3xl" id="checkoutModalLabel"
                                style="color: #E67E22;">Thông tin đơn hàng</h2>
                        </div>

                        <div class="modal-body">
                            <div class="TTKH mb-4">
                                <h3 style="color: #E67E22;">Thông tin khách hàng</h3>
                                <table class="table">
                                    <tr>
                                        <td>Họ tên:</td>
                                        <td id="modalName"></td>
                                    </tr>
                                    <tr>
                                        <td>Số điện thoại:</td>
                                        <td id="modalPhone"></td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td id="modalEmail"></td>
                                    </tr>
                                    <tr>
                                        <td>Địa chỉ nhận:</td>
                                        <td id="modalAddress"></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="TTDH mb-4">
                                <h3 style="color: #E67E22;">Thông tin đơn hàng</h3>
                                <table class="table">
                                    <tr>
                                        <td>Ngày tạo đơn:</td>
                                        <td>
                                            <?php echo date('d/m/Y H:i:s'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tổng số lượng món:</td>
                                        <td>
                                            <?php
                                            $sumofQuantity = 0;
                                            foreach ($_SESSION["cart"] as $cart) {
                                                $sumofQuantity += $cart["quantity"];
                                            }
                                            echo $sumofQuantity;
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ghi chú:</td>
                                        <td>
                                            <textarea name="note" id="note" class="form-control mb-4"
                                                rows="4"></textarea>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <div class="CTDH mb-4">
                                <h3 style="color: #E67E22;">Chi tiết đơn hàng</h3>
                                <?php
                                $totalAmount = 0;
                                foreach ($_SESSION["cart"] as $cart):
                                    $totalAmount += $cart['total'];
                                ?>
                                    <div class="d-flex justify-between align-items-center border-bottom pb-3 mb-3 cart-item"
                                        data-dish-id="<?php echo $cart['id']; ?>"
                                        data-dish-price="<?php echo $cart['price']; ?>"
                                        data-dish-quantity="<?php echo $cart['quantity']; ?>">
                                        <img src="../../../images/dish/<?php echo $cart['image']; ?>"
                                            alt="<?php echo $cart['name']; ?>" class="w-20 h-20 object-cover rounded"
                                            width="100" height="100">
                                        <div class="ml-4 flex-grow-1">
                                            <h4 class="text-lg font-semibold"><?php echo $cart['name']; ?></h4>
                                            <p class="text-gray-500">Giá: <span
                                                    class="dish-price"><?php echo number_format($cart['price'], 0, ".", ","); ?></span>
                                                đ</p>
                                            <p class="text-gray-500">Số lượng: <span
                                                    class="dish-quantity"><?php echo $cart['quantity']; ?></span></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-semibold dish-total">
                                                <?php echo number_format($cart['total'], 0, ".", ","); ?> đ
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Hiển thị tổng tiền của đơn hàng -->
                                <p class="text-lg font-semibold text-right">Tổng cộng: <span name="totalAmount"
                                        id="totalAmount"><?php echo number_format($totalAmount, 0, ".", ","); ?></span>
                                    đ</p>
                                <p class="text-lg font-semibold text-right">Số tiền giảm giá: <span
                                        name="discountAmount" id="discountAmount">0</span> đ</p>
                                <p class="text-lg font-semibold text-right">Tổng sau giảm giá: <span name="finalAmount"
                                        id="finalAmount"><?php echo number_format($totalAmount, 0, ".", ","); ?></span>
                                    đ</p>
                            </div>

                            <div class="store mb-4">
                                <h3 style="color: #E67E22;">Cửa hàng</h3>
                                <?php
                                $db = new Database();
                                $conn = $db->connect();
                                $sql = "SELECT * FROM `store`";
                                $result = $conn->query($sql);
                                $store = [];
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        $store[] = $row;
                                    }
                                } else {
                                    echo "Không có cửa hàng nào.";
                                }
                                ?>
                                <select name="store" id="store" class="form-control">
                                    <option value="">Chọn cửa hàng</option>
                                    <?php
                                    foreach ($store as $row) {
                                        $store_id = $row['storeID'];
                                        $store_name = $row['storeName'];
                                        $store_address = $row['address'];
                                        echo "<option value=\"$store_id\">$store_name ($store_address)</option>";
                                    }
                                    ?>
                                </select>
                                <div id="store-error" class="text-red-500 text-sm"></div>
                            </div>

                            <div class="KM">
                                <h3 style="color: #E67E22;">Khuyến mãi</h3>
                                <?php
                                $ctrl = new cPromotions;
                                $promotions = $ctrl->cGetAllPromotionGoingOn();
                                if ($promotions) {
                                    echo '<select class="form-control" name="promotionID" id="promotionID">';
                                    echo '<option value="" disabled readonly selected>Chọn mã giảm giá</option>';
                                    echo '<option value="0" data-max-discount="0">--</option>';
                                    foreach ($promotions as $promotion) {
                                        echo '<option value="' . $promotion['promotionID'] . '" data-p-d="' . $promotion['discountPercentage'] . '" data-max-discount="' . $promotion['maxDiscountAmount'] . '">';
                                        echo substr($promotion['promotionName'], 0, 50) . '</option>';
                                    }
                                    echo '</select>';
                                } else {
                                    echo 'Không có mã giảm giá';
                                }
                                ?>
                                <input type="hidden" name="hiddenDiscountAmount" id="hiddenDiscountAmount" value="0">
                                <input type="hidden" name="hiddenFinalAmount" id="hiddenFinalAmount" value="0">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-danger" id="submitButton"
                                    onclick="validateStore()">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header flex justify-center">
                            <h2 class="modal-title fs-5 font-bold text-3xl" id="payModalLabel" style="color: #E67E22;">
                                Phương thức thanh toán</h2>
                        </div>
                        <div class="modal-body">
                            <div class="border-b pb-4 mb-4">
                                <label for="" class="font-bold w-full mb-2">Phương thức thanh toán</label>
                                <ul class="w-full">
                                    <li><input type="radio" name="payment_method" id="1" class="mr-2" value="1"
                                            required>Ví điện tử</li>
                                    <li><input type="radio" name="payment_method" id="2" class="mr-2" value="2"
                                            required>Thẻ ngân hàng</li>
                                </ul>
                                <div id="payment-error" class="text-red-500 text-sm"></div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-bold text-xl">Tổng đơn</p>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold">
                                        <?php echo number_format($total, 0, ".", ",") . " đ"; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-danger" onclick="checkPaymentMethod()">Tiếp
                                tục</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="ttpayModal" tabindex="-1" aria-labelledby="ttpayModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header flex justify-center">
                            <h2 class="modal-title fs-5 font-bold text-3xl" id="payModalLabel" style="color: #E67E22;">
                                Chuyển khoản</h2>
                        </div>
                        <div class="modal-body">
                            <div class="flex justify-between items-center">
                                <div class='w-full md:w-1/2 mb-4 pr-4'>
                                    <div class="h-40">
                                        <h5 class='font-bold text-lg' style='color: #E67E22;'>Ngân hàng</h5>
                                        <p>VietinBank</p>
                                        <h5 class='font-bold text-lg mt-2' style='color: #E67E22;'>Tên tài khoản</h5>
                                        <p>DomDom</p>
                                        <h5 class='font-bold text-lg mt-2' style='color: #E67E22;'>Số tài khoản</h5>
                                        <p>8386</p>
                                    </div>
                                    <div class='relative'>
                                        <div class='absolute mt-4 -top-2 left-5 w-44 h-44 border-2 border-[#1a417d]'>
                                            <h3
                                                class='font-bold absolute -top-6 left-[50%] translate-x-[-50%] bg-white text-[#1a417d] text-xl'>
                                                <span class='text-red-500'>VIET</span>QR
                                            </h3>
                                        </div>
                                        <img class='block mx-auto mt-4'
                                            src='http://localhost/domdom/view/page/orderstaff/create/qrcode.php?type=banking&orderID=<?= $orderID ?>&amount=1000'
                                            alt='Mã QR'>
                                    </div>
                                </div>
                                <div class='w-full md:w-1/2 mb-4 pl-4'>
                                    <div class="h-40">
                                        <h5 class='font-bold text-lg' style='color: #E67E22;'>Ví Momo</h5>
                                        <p>DomDom</p>
                                        <h5 class='font-bold text-lg mt-2' style='color: #E67E22;'>Số tài khoản</h5>
                                        <p>0923262123</p>
                                    </div>
                                    <div class='relative'>
                                        <div class='absolute mt-4 -top-2 left-5 w-44 h-44 border-2 border-[#a50064]'>
                                            <h3
                                                class='font-bold absolute -top-6 left-[50%] translate-x-[-50%] bg-white text-[#a50064] text-xl'>
                                                MOMO</h3>
                                        </div>
                                        <img class='block mx-auto mt-4'
                                            src='http://localhost/domdom/view/page/orderstaff/create/qrcode.php?type=momo&orderID=<?= $orderID ?>&amount=1000'
                                            alt='Mã QR'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger" id="confirmPay" name="btntt">Thanh
                                toán</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['payment_method'])) {
            $payment_method = ($_POST['payment_method'] == 1 ? "Momo" : "Ngân hàng");
            $name = $_POST['name'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $email = $_POST['email'] ?? '';
            $address = $_POST['address'] ?? '';
            $note = $_POST['note'] ?? null;
            $storeID = $_POST['store'] ?? '';
            $promotionID = $_POST['promotionID'] ?? '';
            $discountAmount = $_POST['hiddenDiscountAmount'] ?? 0;
            $finalAmount = $_POST['hiddenFinalAmount'] ?? 0;
            $partyPackageID = null;

            $sql_check = "SELECT * FROM customer WHERE phoneNumber = '$phone'";
            $result = $conn->query($sql_check);

            if ($result->num_rows == 0) {
                $sql_insert_customer = "INSERT INTO `customer` (phoneNumber, fullName, address, email) VALUES ('$phone', '$name', '$address', '$email')";
                if ($conn->query($sql_insert_customer) !== TRUE) {
                    echo "<p>Lỗi khi thêm khách hàng: " . $conn->error . "</p>";
                    exit();
                }
            }

            $sql_check_orders = "SELECT COUNT(*) AS order_count FROM `order` WHERE phoneNumber = '$phone' AND status = 4";
            $order_result = $conn->query($sql_check_orders);
            $sumofQuantity = 0;
            foreach ($_SESSION["cart"] as $cart) {
                $sumofQuantity += $cart["quantity"];
            }

            if ($order_result) {
                $order_row = $order_result->fetch_assoc();
                $order_count = $order_row['order_count'];

                if ($order_count > 3 || $order_count == 3) {
                    echo "<script>alert('Không thể đặt hàng: Khách hàng đã hủy đơn quá 3 lần.');</script>";
                } else {
                    //echo "$total, $sumOfQuantity, $payment_method, $note, '1', $phone, $discountAmount, $finalAmount, $partyPackageID, $storeID";
                    $sql_insert_order = "INSERT INTO `order` (orderDate, total, sumOfQuantity, paymentMethod, note, phoneNumber, promotionID, storeID) 
                    VALUES (NOW(), $total, $sumofQuantity, '$payment_method', '$note', '$phone', '$promotionID', $storeID)";
                    if ($conn->query($sql_insert_order) === TRUE) {
                        $orderID = $conn->insert_id;
                        foreach ($_SESSION["cart"] as $cart) {
                            $dishID = $cart['id'];
                            $quantity = $cart['quantity'];
                            $unitPrice = $cart['price'];
                            $discountAmount = isset($cart['discountAmount']) ? $cart['discountAmount'] : "NULL";
                            $lineTotal = $cart['total'];

                            $sql_insert_order_detail = "INSERT INTO order_dish (orderID, dishID, quantity) 
                                                        VALUES ('$orderID', '$dishID', '$quantity')";
                            
                            $result = $conn->query($sql_insert_order_detail);
                            
                            if (!$result)
                                echo "<p>Lỗi khi thêm chi tiết món $dishID: " . $conn->error . "</p>";
                        }

                        if ($result) {
                            unset($_SESSION["cart"]);
                            unset($_SESSION["formData"]);
                            echo "<script>if (alert('Đã đặt hàng thành công!') != false) window.location.href = 'cart.php';</script>";
                        }
                    } else {
                        echo "<p>Lỗi khi thêm đơn hàng: " . $conn->error . "</p>";
                    }
                }
            } else {
                echo "<p>Lỗi khi kiểm tra đơn hàng: " . $conn->error . "</p>";
            }
        }
    }
    ?>
</body>

</html>