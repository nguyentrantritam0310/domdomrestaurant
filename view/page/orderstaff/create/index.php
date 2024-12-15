<?php
$ctrlOrder = new cOrders;
$ctrlCustomer = new cCustomers;
$ctrlPromotion = new cPromotions;
$ctrlDish = new cDishes;
$ctrlIngre = new cIngredients;
$ctrlMessage = new cMessage;
echo "<script>document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('create').classList.add('activeAd');
    });</script>";

$storeID = $_SESSION["user"][1];

/* Lưu đơn hàng theo cửa hàng */
if (!isset($_SESSION["product"])) {
    $_SESSION["product"] = [];
}

if (isset($_GET["p"])) {
    $productID = $_GET["p"];

    echo "<script>
        document.addEventListener('DOMContentLoaded', () => {
            focusQuantityInput(" . json_encode($productID) . ");
        });
    </script>";

    $quantity = isset($_POST["quantity"]) ? (int) $_POST["quantity"] : 1;

    $productExists = false;
    foreach ($_SESSION["product"] as $product) {
        if ($product["id"] == $productID) {
            $productExists = true;
            break;
        }
    }

    if (!$productExists) {
        $_SESSION["product"][$productID] = ["id" => $productID, "quantity" => $quantity];
    }
}

if (isset($_POST["quantity"])) {
    foreach ($_POST["quantity"] as $productID => $quantity) {
        $productID = (int) $productID;
        $quantity = (int) $quantity;

        if (isset($_SESSION["product"][$productID])) {
            $_SESSION["product"][$productID]["quantity"] = $quantity;
        }
    }
}

$_SESSION["delivery"] = isset($_POST["delivery"]) ? $_POST["delivery"] : "";
?>

<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="w-full px-8 flex">
            <div class="w-3/5 pr-4">
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-[#EF5350]">Danh mục</h2>
                    </div>
                    <div class="grid grid-cols-6 gap-2">
                        <?php
                        if ($ctrlDish->cGetAllCategory() != 0) {
                            $result = $ctrlDish->cGetAllCategory();

                            $img_dish = "";

                            while ($row = $result->fetch_assoc()) {
                                $img_dish = "../../../images/dish/" . $row["image"];
                                if (!file_exists($img_dish))
                                    $img_dish = "../../../images/nodish.png";
                                echo "<div class='card px-auto py-3 rounded'>
                                <a href='?i=create&c=" . $row["dishCategory"] . "' class='flex flex-col items-center'>
                                    <img alt='" . $row["dishCategory"] . "' class='mb-2 size-20 rounded-md' src='" . $img_dish . "'/>
                                    <h2 class='text-sm font-bold text-center'>" . $row["dishCategory"] . "</h2>
                                </a>
                            </div>";
                            }
                        } else
                            echo "Không có dữ liệu!";
                        ?>
                    </div>
                    <div class="flex mt-3 pt-3 border-t">
                        <?php
                        $category = str_replace("%20", " ", $_GET["c"]);
                        if ($ctrlDish->cGetDishByCategory($category)) {
                            $result = $ctrlDish->cGetDishByCategory($category);

                            $img_dish = "";

                            echo "<div class='grid grid-cols-4 gap-2 w-full'>";
                            while ($row = $result->fetch_assoc()) {
                                $img_dish = "../../../images/dish/" . $row["image"];
                                if (!file_exists($img_dish))
                                    $img_dish = "../../../images/nodish.png";
                                echo "<div class='card px-auto py-3 rounded'>
                                <a href='index.php?i=create&c=" . $row["dishCategory"] . "&p=" . $row["dishID"] . "' class='text-center flex flex-col items-center'>
                                    <img alt='" . $row["dishName"] . "' class='mb-2 rounded-md size-28' src='" . $img_dish . "'/>
                                    <h2 class='text-base font-bold my-1 h-12'>" . $row["dishName"] . "</h2>
                                    <p class='text-sm text-red-400'>" . str_replace(".00", "", number_format($row["price"], "2", ".", ",")) . " đ</p>
                                </a>
                            </div>";
                            }
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-[#EF5350]">Món HOT</h2>
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        <?php
                        if ($ctrlDish->cGetDishTop() != 0) {
                            $result = $ctrlDish->cGetDishTop();

                            while ($row = $result->fetch_assoc()) {
                                echo "<div class='card px-auto py-3 rounded'>
                                    <a href='index.php?i=create&p=" . $row["dishID"] . "' class='text-center flex flex-col items-center'>
                                        <img alt='" . $row["dishName"] . "' class='mb-2 rounded-md size-28' src='../../../images/dish/" . $row["image"] . "'/>
                                        <h2 class='text-base font-bold my-1 h-12'>" . $row["dishName"] . "</h2>
                                        <p class='text-sm text-red-400'>" . str_replace(".00", "", number_format($row["price"], "2", ".", ",")) . " đ</p>
                                    </a>
                                </div>";
                            }
                        } else
                            echo "Không có dữ liệu!";
                        ?>
                    </div>
                </div>
            </div>
            <div class="w-2/5 pl-4">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-[#EF5350]">Thông tin đơn hàng</h2>
                </div>
                <div class="card p-4 rounded mb-8">
                    <form action="" method="POST" class="formmethod mb-0">
                        <h2 class="text-lg font-bold pb-2 mb-3 border-b">Hình thức mua hàng</h2>
                        <div class="flex items-center">
                            <input class="mr-2 size-4" id="dinein" value="1" name="delivery" <?php echo $_SESSION["delivery"] == 1 ? "checked" : ""; ?> type="radio" />
                            <label class="text-base" for="dinein">Tại quán</label>
                            <input class="ml-4 mr-2 size-4" id="takeaway" value="2" name="delivery" <?php echo $_SESSION["delivery"] == 2 ? "checked" : ""; ?> type="radio" />
                            <label class="text-base" for="takeaway">Mang đi</label>
                        </div>
                    </form>
                </div>
                <div class="card p-4 rounded">
                    <h2 class="text-lg font-bold pb-2 mb-3 border-b">Đơn hàng</h2>
                    <?php
                    if (isset($_POST["btnxoa"])) {
                        foreach ($_SESSION["product"] as $index => $product) {
                            if ($product["id"] == $_POST["btnxoa"]) {
                                unset($_SESSION["product"][$index]);
                                break;
                            }
                        }

                        $_SESSION["product"] = array_values($_SESSION["product"]);
                    }

                    $total = 0;

                    if (isset($_SESSION["product"])) {
                        echo "<form action='' method='POST' class='m-0 form'>";
                        foreach ($_SESSION["product"] as $product) {
                            $productID = (int) $product["id"];
                            $quantity = $product["quantity"];

                            if ($ctrlDish->cGetDishById($productID) != 0) {
                                $result = $ctrlDish->cGetDishById($productID);
                                $row = $result->fetch_assoc();

                                echo "<div class='flex justify-between items-center mb-2'>
                                        <span class='font-bold w-2/6'>" . $row["dishName"] . "</span>
                                        <span class='w-2/6 italic text-gray-400'>" . number_format($row["price"], 0, ".", ",") . "</span>
                                        <input type='number' name='quantity[" . $productID . "]' min='1' value='" . $quantity . "' class='w-1/6 text-center quantityInput mr-2' data-id='" . $productID . "' data-name='" . $row["dishName"] . "' data-price='" . $row["price"] . "'>
                                        <button type='submit' name='btnxoa' value='" . $productID . "' class='btn btn-secondary w-1/6 ml-2'><i class='fa-solid fa-trash-can'></i></button>
                                    </div>";

                                $total += $row["price"] * $quantity;
                            }
                        }
                        echo "</form>";

                        $_SESSION["total"] = $total;
                    }

                    if (empty($_SESSION["product"]))
                        echo "<div class='flex justify-between items-center my-2'>
                                <img src='../../../images/nodish.png' class='h-40 w-full'>    
                            </div>";
                    ?>
                    <form action="index.php?i=create&checkout" method="POST" class="formCheckout">
                        <div class="flex justify-between items-center pt-2 mb-4 border-t">
                            <span class="text-lg font-bold">Tổng thanh toán:</span>
                            <span
                                class="text-lg font-bold finalTotal"><?php echo str_replace(".00", "", number_format($total, "2", ".", ",")) . " đ"; ?></span>
                        </div>
                        <button class="btn btn-danger w-full p-2 rounded" id="tt" name="btntt" type="submit" <?php echo (empty($_SESSION["product"]) ? "disabled" : ""); ?>>Thanh
                            toán</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
if ($ctrlPromotion->cGetAllPromotionGoingOn() != 0) {
    $date = date("Y-m-d");
    $discountRate = 0;

    $result = $ctrlPromotion->cGetAllPromotionGoingOn();
    while ($row = $result->fetch_assoc()) {
        if ($date >= $row["startDate"] && $date <= $row["endDate"]) {
            $_SESSION["promotionID"] = $row["promotionID"];
            if ($discountRate < $row["discountPercentage"])
                $discountRate = $row["discountPercentage"];
        }
    }

    $_SESSION["discount"] = $discountRate;
}

$_SESSION["customerPay"] = [
    0 => isset($_POST["cash"]) ? (int) $_POST["cash"] : 0,
    1 => isset($_POST["momo"]) ? (int) $_POST["momo"] : 0,
    2 => isset($_POST["banking"]) ? (int) $_POST["banking"] : 0,
];

if (isset($_POST["priceBtn"])) {
    list($method, $value) = explode("|", $_POST["priceBtn"]);

    $methodIndex = null;
    if ($method == "cash")
        $methodIndex = 0;
    elseif ($method == "momo")
        $methodIndex = 1;
    elseif ($method == "banking")
        $methodIndex = 2;

    $_SESSION["method"] = $method;

    if ($value == "reset")
        $_SESSION["customerPay"][$methodIndex] = 0;
    else
        $_SESSION["customerPay"][$methodIndex] += (int) $value * 1000;

    $_SESSION["cusPay"] = $_SESSION["customerPay"][$methodIndex];

    if ($_SESSION["customerPay"] > $_SESSION["totalAfterDiscount"])
        $_SESSION["charge"] = array_sum($_SESSION["customerPay"]) - $_SESSION["totalAfterDiscount"];
    else
        $_SESSION["charge"] = 0;
}

$_SESSION["totalAfterDiscount"] = isset($_SESSION["discount"]) ? $_SESSION["total"] * (1 - $_SESSION["discount"] / 100) : $_SESSION["total"];
?>
<div class="modalCheckout hidden justify-center items-center w-screen h-screen fixed top-0 left-0" id="checkoutModal">
    <div class="w-3/5 h-fit bg-white rounded-2xl shadow border">
        <div>
            <div class="w-full text-center">
                <h2 class="modal-title mt-4 mb-2 pb-4 border-b-2 font-bold text-2xl text-[#E67E22]">Thông tin
                    thanh toán</h2>
            </div>
            <div class="px-4 flex">
                <div class="w-2/3 mr-2 p-2 border rounded-lg">
                    <table class="w-full">
                        <tbody>
                            <form action="" method="POST" class="formCheckoutInfo">
                                <tr>
                                    <td colspan="2" class="font-bold text-[#EF5350]">Hình thức
                                        thanh toán
                                        <hr class="mt-1 mb-2 text-gray-400">
                                        </hr>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-3 py-1 w-32 flex items-start">Tiền mặt</td>
                                    <td class="divMoney group"><input type="text" class="form-control m-0 pr-3 money"
                                            name="cash" id=""
                                            value="<?php echo ($_SESSION["method"] == "cash" ? $_SESSION["cusPay"] : ""); ?>"
                                            placeholder="Số tiền thanh toán" autocomplete="off">
                                        <div
                                            class="group-hover:block <?php echo ($_SESSION["method"] == "cash" ? "block" : "hidden"); ?> w-full h-fit mt-2">
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|1">1</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|2">2</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|5">5</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|10">10</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|20">20</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|50">50</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|100">100</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|200">200</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|500">500</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="cash|reset">Nhập
                                                lại</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-3 py-1 w-32 flex items-start">Ví điện tử</td>
                                    <td class="divMoney group"><input type="text" class="form-control m-0 pr-3 money"
                                            name="vnpay" id=""
                                            value="<?php echo ($_SESSION["method"] == "momo" ? $_SESSION["cusPay"] : ""); ?>"
                                            placeholder="Số tiền thanh toán" autocomplete="off">
                                        <div
                                            class="group-hover:block <?php echo ($_SESSION["method"] == "momo" ? "block" : "hidden"); ?> w-full h-fit mt-2">
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|1">1</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|2">2</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|5">5</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|10">10</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|20">20</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|50">50</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|100">100</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|200">200</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|500">500</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="momo|reset">Nhập
                                                lại</button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-3 py-1 w-32 flex items-start">Ngân hàng</td>
                                    <td class="divMoney group"><input type="text" class="form-control m-0 pr-3 money"
                                            name="banking" id=""
                                            value="<?php echo ($_SESSION["method"] == "banking" ? $_SESSION["cusPay"] : ""); ?>"
                                            placeholder="Số tiền thanh toán" autocomplete="off">
                                        <div
                                            class="group-hover:block <?php echo ($_SESSION["method"] == "banking" ? "block" : "hidden"); ?> w-full h-fit mt-2">
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|1">1</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|2">2</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|5">5</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|10">10</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|20">20</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|50">50</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|100">100</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|200">200</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|500">500</button>
                                            <button class="btn btn-light m-1 rounded" name="priceBtn"
                                                value="banking|reset">Nhập
                                                lại</button>
                                        </div>
                                    </td>
                                </tr>
                            </form>
                            <?php
                            if (!isset($_SESSION["exist"]))
                                $_SESSION["exist"] = false;

                            if (!isset($_SESSION["customer"]))
                                $_SESSION["customer"] = ["", ""];

                            if (isset($_POST["btncus"])) {
                                $phoneNumber = $_POST["phone"];
                                $customerName = $_POST["customerName"];
                                /* $_SESSION["exist"] = false;

                                $result = $ctrlCustomer->cGetAllCustomer();
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        if ($row["phoneNumber"] == $phone) {
                                            $_SESSION["customer"] = [$row["fullName"], $row["phoneNumber"]];
                                            $_SESSION["exist"] = true;
                                            break;
                                        }
                                    }
                                } */

                                $_SESSION["customer"] = [$customerName, $phoneNumber];

                                /* if ($_SESSION["customer"][0] != "" && $_SESSION["customer"][1] != "" && !$_SESSION["exist "]) {
                                    $ctrlCustomer->cInsertCustomer($_SESSION["customer"][1], $_SESSION["customer"][0], "", "");
                                } */
                            }

                            /* if ($_SESSION["exist"])
                                echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var checkoutModal = new bootstrap.Modal(document.getElementById('checkoutModal')); 
                                        checkoutModal.show();
                                    });
                                </script>"; */
                            ?>

                            <tr>
                                <td colspan="2" class="font-bold text-[#EF5350]">Khách hàng
                                    <hr class="mt-1 mb-2 text-gray-400">
                                    </hr>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <form action="" method="POST">
                                        <div class='flex flex-col justify-between'>
                                            <input type="text" class="form-control m-0" style="width: 80%;" name="phone"
                                                id="" value="<?php echo $_SESSION["customer"][1]; ?>"
                                                title="Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số"
                                                placeholder="Nhập số điện thoại" required
                                                pattern="^(0(2[0-9]|3[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{7})|(\+84(2[0-9]|3[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{7})$">

                                            <input type='text' class='form-control m-0 mt-2' style='width: 80%;'
                                                name='customerName' id=''
                                                value='<?php echo $_SESSION["customer"][0]; ?>'
                                                placeholder='Nhập tên khách hàng'>

                                            <button type='submit' class='btn btn-primary w-fit mt-3' name="btncus">Xác
                                                nhận</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="w-1/3 ml-2 p-2 border rounded-lg">
                    <form action="" method="POST">
                        <table class="w-full">
                            <tbody>
                                <tr>
                                    <th colspan="2" class="text-[#EF5350]">Thanh toán
                                        <hr class="mt-1 mb-2 text-gray-400">
                                        </hr>
                                    </th>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-2 py-1">Tổng đơn</td>
                                    <td><input type="text" name="" class="totalOrder w-24 border-none outline-none"
                                            readonly
                                            value="<?php echo number_format($_SESSION["total"], 0, ",", ".") . " đ"; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-2 py-1">Khuyến mãi</td>
                                    <td><input type="text" class="promotion w-24 border-none outline-none" readonly
                                            value="<?php echo (isset($_SESSION["discount"]) ? $_SESSION["discount"] : 0) . "%"; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-2 py-1">Phải trả</td>
                                    <td><input type="text" name="" class="total w-24 border-none outline-none" readonly
                                            value="<?php echo number_format($_SESSION["totalAfterDiscount"], 0, ",", ".") . " đ"; ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-2 py-1">Khách trả</td>
                                    <td><input type="text" class="w-24 border-none outline-none" readonly
                                            value="<?php
                                            echo number_format(($_SESSION["customerPay"] != 0 ? $_SESSION["cusPay"] : 0), 0, ",", ".") . " đ"; ?>"></td>
                                </tr>
                                <tr>
                                    <td class="font-bold pl-2 py-1">Tiền thối</td>
                                    <td><input type="text" class="w-24 border-none outline-none" readonly
                                            value="<?php echo number_format($_SESSION["charge"], 0, ",", ".") . " đ"; ?>">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <form action="" method="POST">
                <div class="pt-2 px-4 mt-2 mb-8 border-t-2 flex justify-end">
                    <button type="button" class="btn btn-secondary mr-1 mt-2" id="cancel">Hủy</button>
                    <button type="submit" class="btn btn-danger ml-1 mt-2" name="btnxn" <?php echo ((!isset($_SESSION["cusPay"]) || $_SESSION["customer"][0] == "") ? "disabled" : ""); ?>>Xác
                        nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class='modal modalPayment fade' id='paymentModal' tabindex='-1' aria-labelledby='paymentModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content <?php echo $_SESSION["method"] == "cash" ? "opacity-0" : "opacity-1"; ?>'>
            <div class='modal-header justify-center'>
                <h2 class='modal-title fs-5 font-bold text-3xl' id='paymentModalLabel' style='color: #E67E22;'>Thanh
                    toán</h2>
            </div>
            <div class='modal-body'>
                <?php
                if (isset($_POST["btnxn"])) {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var modalPayment = new bootstrap.Modal(document.getElementById('paymentModal')); 
                            modalPayment.show();
                        });
                    </script>";

                    if ($_SESSION["method"] == "momo")
                        $type = "Momo";
                    else if ($_SESSION["method"] == "banking")
                        $type = "Ngân hàng";
                    else
                        $type = "Tiền mặt";

                    $sumQuantity = 0;
                    foreach ($_SESSION["product"] as $product) {
                        $sumQuantity += $product["quantity"];
                    }

                    $result = $ctrlCustomer->cGetAllCustomer();
                    $_SESSION["exist"] = false;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row["phoneNumber"] == $_SESSION["customer"][1]) {
                                $_SESSION["exist"] = true;
                                break;
                            }
                        }
                    }
                    
                    if (!$_SESSION["exist"]) {
                        $ctrlCustomer->cInsertCustomer($_SESSION["customer"][1], $_SESSION["customer"][0], "", "");
                    }

                    $customerPhoneNew = $_SESSION["customer"][1];

                    $ctrlOrder->cInsertOrder($customerPhoneNew, $_SESSION["totalAfterDiscount"], $sumQuantity, $_SESSION["promotionID"], $type, $storeID);
                    $row = $ctrlOrder->cGetOrderIDNew()->fetch_assoc();
                    $orderIDnew = $row["orderID"];
                    $ctrlOrder->cUpdateStatusOrder($orderIDnew, 1, $storeID);

                    foreach ($_SESSION["product"] as $product) {
                        $ctrlOrder->cInsertOrderDish($orderIDnew, $product["id"], $product["quantity"]);
                        $ctrlIngre->cDecreaseIngredient($product["id"], $product["quantity"]);
                    }

                    if ($_SESSION["method"] == "momo") {
                        $type = "momo";
                        echo "<div class='relative'>
                            <div class='absolute mt-4 top-4 left-36 w-44 h-44 border-2 border-[#a50064]'><h3 class='font-bold absolute -top-6 left-[50%] translate-x-[-50%] bg-white text-[#a50064] text-xl'>MOMO</h3></div>
                        </div>";
                    } else if ($_SESSION["method"] == "banking") {
                        $type = "banking";
                        echo "<div class='relative'>
                            <div class='absolute mt-4 top-4 left-36 w-44 h-44 border-2 border-[#1a417d]'><h3 class='font-bold absolute -top-6 left-[50%] translate-x-[-50%] bg-white text-[#1a417d] text-xl'><span class='text-red-500'>VIET</span>QR</h3></div>
                        </div>";
                    }

                    if ($_SESSION["method"] == "momo" || $_SESSION["method"] = "banking") {
                        echo "<div>
                                <img class='block mx-auto mt-4'
                                    src='http://localhost/domdom/view/page/orderstaff/create/qrcode.php?type=" . $type . "&orderID=" . $orderIDnew . "&amount=" . $totalAmount . "'
                                    alt='Mã QR'>
                            </div>
                            <div class='w-full mt-8'>
                                <p>OrderID: #" . $orderIDnew . ". <br> Ngày: " . date("Y-m-d") . ". <br> " . ($_SESSION["delivery"]
                            == 1 ? "Dùng tại quán" : "Mang đi") . " <br> Tổng tiền: " . number_format(
                            $_SESSION["totalAfterDiscount"],
                            0,
                            ",",
                            "."
                        ) . " VND</p>
                            </div>";

                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let timerInterval;
                                    setTimeout(() => {
                                        Swal.fire({
                                            title: 'Thanh toán thành công',
                                            html: '<b></b> milliseconds.',
                                            timer: 2000,
                                            icon: 'success',
                                            timerProgressBar: true,
                                            didOpen: () => {
                                                Swal.showLoading();
                                                const timer = Swal.getPopup().querySelector('b');
                                                timerInterval = setInterval(() => {
                                                    timer.textContent = Swal.getTimerLeft();
                                                }, 100);
                                            },
                                            willClose: () => {
                                                clearInterval(timerInterval);
                                            }
                                        }).then((result) => {
                                            if (result.dismiss === Swal.DismissReason.timer) {
                                                window.location.href = 'index.php?i=create';
                                            }
                                        });
                                    }, 5000);
                                });
                            </script>";
                    } else {
                        echo "<script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    let timerInterval;
                                    Swal.fire({
                                        title: 'Thanh toán thành công',
                                        html: '<b></b> milliseconds.',
                                        timer: 2000,
                                        icon: 'success',
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading();
                                            const timer = Swal.getPopup().querySelector('b');
                                            timerInterval = setInterval(() => {
                                                timer.textContent = Swal.getTimerLeft();
                                            }, 100);
                                        },
                                        willClose: () => {
                                            clearInterval(timerInterval);
                                        }
                                    }).then((result) => {
                                        if (result.dismiss === Swal.DismissReason.timer) {
                                            window.location.href = 'index.php?i=create';
                                        }
                                    });
                                });
                            </script>";
                    }

                    unset($_SESSION["customer"]);
                    unset($_SESSION["product"]);
                    unset($_SESSION["total"]);
                    unset($_SESSION["promotionID"]);
                    unset($_SESSION["discount"]);
                    unset($_SESSION["method"]);
                    unset($_SESSION["customerPay"]);
                    unset($_SESSION["cusPay"]);
                    unset($_SESSION["charge"]);
                    unset($_SESSION["totalAfterDiscount"]);
                }
                ?>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function totalUpdate() {
        let total = 0;
        let quantities = document.querySelectorAll(".quantityInput");

        quantities.forEach(input => {
            let dishPrice = parseFloat(input.getAttribute("data-price"));
            let quantity = parseInt(input.value);

            if (input.value < 1)
                input.value = 1;

            total += dishPrice * quantity;

            document.querySelector(".finalTotal").textContent = total.toLocaleString() + " đ";
        });
    }

    document.querySelectorAll(".quantityInput").forEach(input => {
        input.addEventListener("change", () => {
            totalUpdate();
            input.form.submit();
        });
    });

    function focusQuantityInput(productID) {
        const input = document.querySelector(`input[data-id='${productID}']`);
        if (input)
            input.focus();
    }

    var formmethod = document.querySelector(".formmethod");
    var radioBtn = document.querySelectorAll('input[type="radio"][name="delivery"]');

    radioBtn.forEach(btn => {
        btn.addEventListener("change", (event) => {
            if (event.target.checked) {
                formmethod.submit();
            }
        });
    });

    document.addEventListener("DOMContentLoaded", () => {
        const urlParams = new URLSearchParams(window.location.search);
        let checkoutModal = document.getElementById("checkoutModal");
        const cancelButton = document.getElementById("cancel");

        if (urlParams.has("checkout")) {
            checkoutModal.classList.remove("hidden");
            checkoutModal.style.display = "flex";
        };

        cancelButton.addEventListener("click", () => {
            checkoutModal.classList.remove("flex");
            checkoutModal.style.display = "none";
        });

        const paymentInputs = document.querySelectorAll(".money");

        paymentInputs.forEach((input) => {
            input.addEventListener("focus", function () {
                paymentInputs.forEach((otherInput) => {
                    if (otherInput !== input) {
                        otherInput.value = "";
                    }
                });
            });
        });
    });
</script>