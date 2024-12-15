<title>Dịch vụ | DomDom - Chuỗi cửa hàng thức ăn nhanh</title>

<style>
    .arrow {
        animation: bounce 1.5s infinite;
        transition: all 1s linear;
    }

    .arrow:nth-child(2) {
        animation-delay: .15s;
    }

    .arrow:last-child {
        animation-delay: .25s;
    }

    @keyframes bounce {

        0%,
        20%,
        50% {
            transform: translateY(0);
            opacity: 0;
        }

        40% {
            transform: translateY(-15px);
        }

        60% {
            transform: translateY(-10px);
            opacity: 1;
        }

        80% {
            transform: translateY(0);
            opacity: 0.7;
        }

        100% {
            transform: translateY(0);
            opacity: 0.3;
        }
    }

    .text {
        transform: translatey(0px);
        animation: float 5s ease-in-out infinite;
        letter-spacing: 3px;
        color: #774f38;
        background-color: #ece5ce;
        padding: 50px;
        border-radius: 11px;
        box-shadow: 20px 20px #83af9b;
        font-family: "Baloo 2", cursive;
    }

    .text:after {
        transform: translatey(0px);
        animation: float2 5s ease-in-out infinite;
        content: ".";
        font-weight: bold;
        -webkit-text-fill-color: #ece5ce;
        text-shadow: 22px 22px #83af9b;
        text-align: left;
        font-size: 55px;
        width: 55px;
        height: 11px;
        line-height: 30px;
        border-radius: 11px;
        background-color: #ece5ce;
        position: absolute;
        display: block;
        bottom: -30px;
        left: 0;
        box-shadow: 22px 22px #83af9b;
        z-index: -2;
    }

    @keyframes float {
        0% {
            transform: translatey(0px);
        }

        50% {
            transform: translatey(-20px);
        }

        100% {
            transform: translatey(0px);
        }
    }

    @keyframes float2 {
        0% {
            line-height: 30px;
            transform: translatey(0px);
        }

        55% {
            transform: translatey(-20px);
        }

        60% {
            line-height: 10px;
        }

        100% {
            line-height: 30px;
            transform: translatey(0px);
        }
    }
</style>

<?php
$ctrlParty = new cPartyPackages;
$ctrlPromotion = new cPromotions;
$ctrlIngre = new cIngredients;
$ctrlCustomer = new cCustomers;
$ctrlOrder = new cOrders;
$ctrlMessage = new cMessage;

if (isset($_POST["btndattiec"])) {
    $_SESSION["ppID"] = (int) $_POST["btndattiec"];

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
    }

    if ($ctrlParty->cGetPartyPackageByID($_SESSION["ppID"]) != 0) {
        $result1 = $ctrlParty->cGetPartyPackageByID($_SESSION["ppID"]);
        $row1 = $result1->fetch_assoc();

        $_SESSION["ppName"] = $row1["partyPackageName"];
        $_SESSION["ppPrice"] = $row1["price"] * (1 - $discountRate / 100);
        $_SESSION["quantity"] = $row1["sumQuantity"];
    }

    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalParty = new bootstrap.Modal(document.getElementById('partyModal')); 
            modalParty.show();
        });
    </script>";
}

if (isset($_POST["btnxn"])) {
    if (!isset($_COOKIE["selectedStore"]))
        echo "<script>
            alert('Vui lòng chọn cửa hàng trước!');
        </script>";
    else {
        $ppID = $_SESSION["ppID"];
        $phone = $_POST["phone"];
        $name = $_POST["name"];
        $address = $_POST["address"];
        $email = $_POST["email"];
        $paymentMethod = $_POST["method"] == 1 ? "Ví điện tử" : "Ngân hàng";

        if ($ctrlCustomer->cGetAllCustomer() != 0) {
            $result = $ctrlCustomer->cGetAllCustomer();

            $exist = false;
            while ($row = $result->fetch_assoc()) {
                if ($phone == $row["phoneNumber"]) {
                    $exist = true;
                    break;
                }
            }

            if (!$exist)
                $ctrlCustomer->cInsertCustomer($phone, $name, $address, $email);

            $ctrlOrder->cInsertOrderPartyPackage($phone, $_SESSION["ppPrice"], $_SESSION["quantity"], $_SESSION["promotionID"], $paymentMethod, $_COOKIE["selectedStore"], $_SESSION["ppID"]);

            $row2 = $ctrlOrder->cGetOrderIDNew()->fetch_assoc();
            $orderID = $row2["orderID"];

            if ($ctrlParty->cGetDishFromPartyPacakge($ppID) != 0) {
                $resultParty = $ctrlParty->cGetDishFromPartyPacakge($ppID);

                while ($row3 = $resultParty->fetch_assoc()) {
                    $dishID = $row3["dishID"];
                    $quantity = $row3["quantity"];

                    $resultOrderDish = $ctrlOrder->cInsertOrderDish($orderID, $dishID, $quantity);
                    $ctrlIngre->cDecreaseIngredient($dishID, $quantity);

                    if ($resultOrderDish)
                        $ctrlMessage->successMessage("Đặt tiệc");
                    else
                        $ctrlMessage->errorMessage("Đặt tiệc");
                }
            } else
                $ctrlMessage->falseMessage("Không có dữ liệu!");
        }
    }
}
?>

<div class="flex flex-col justify-center items-center absolute top-48 left-28">
    <h2 class="text font-bold uppercase text-center relative text-3xl">Sử dụng ngay<br />các gói dịch vụ <br> của chúng
        tôi! <br>
        <span class="text-sm italic">Tổ chức các bữa tiệc sẽ trở nên đơn giản</span< </h2>
</div>

<div class="w-full py-20 ">
    <h2 id="title"
        class="text-center text-[#795548] text-3xl font-bold w-1/3 mb-8 mx-auto py-2 rounded-xl border-x-4 border-amber-300 border-dotted">
        CHƯƠNG TRÌNH DỊCH VỤ</h2>
    <div
        class="grid grid-cols-4 md:grid-cols-2 lg:grid-cols-3 gap-8 mx-14 flex justify-center gap-5 p-8 rounded-md shadow">
        <?php
        if ($ctrlParty->cGetAllPartyPackage() != 0) {
            $result = $ctrlParty->cGetAllPartyPackage();

            while ($row = $result->fetch_assoc()) {
                echo "<div class='h-72 w-full rounded-lg flex justify-center items-center bg-red-400 transition delay-200 ease-linear shadow-xl shadow-red-300'>
                    <form action='' method='POST' class='group w-full'>
                        <div class='relative flex flex-col justify-center items-center px-6 py-4 h-72 w-full'>
                            <div class='mb-2 z-10'>
                                <img src='images/party/" . $row["image"] . "' class='w-48 h-28 rounded-lg'>
                            </div>
                            <span class='absolute bg-green-200 bottom-0 left-0 w-6 h-4 rounded-tr-full rounded-bl-lg group-hover:rounded-lg group-hover:w-full group-hover:h-full transition-all ease-linear delay-150'></span>
                            <div class='text-white z-10'>
                                <h3 class='font-bold text-center text-xl group-hover:text-amber-500 delay-200'>" . $row["partyPackageName"] . "</h3>
                                <p class='text-wrap font-bold group-hover:text-gray-900 h-14'>Combo: <span class='text-gray-bold font-thin'>" . $row["Name"] . "</span></p>
                            </div>
                        </div>
                        <div class='translate-y-16 -translate-x-16 absolute opacity-[0.01] group-hover:opacity-100 group-hover:-translate-y-48 group-hover:translate-x-[162px] transition delay-100 z-10'>
                                <button class='btn btn-danger' name='btndattiec' value='" . $row["partyPackageID"] . "' id='btn'>Đặt ngay</button>
                        </div>
                    </form>
                </div>";
            }
        }
        ?>
    </div>
</div>

<div class="modal modalParty" id="partyModal" tabindex="-1" aria-labelledby="partyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header flex justify-center">
                    <h2 class="modal-title fs-5 font-bold text-3xl text-[#E67E22]" id="partyModalLabel">Thông tin đặt
                        tiệc</h2>
                </div>
                <div class=" modal-body">
                    <table class="w-full">
                        <tbody>
                            <tr>
                                <td>
                                    <h2 class="text-[#EF5350] font-bold mb-2">Thông tin cá nhân</h2>
                                    <input type="text" id="" name="name" class="form-control w-full mb-3"
                                        placeholder="Họ và tên..." required pattern="^[\p{L}\s]+$"
                                        title="Họ tên chỉ được bao gồm chữ cái tiếng Việt">
                                    <input type="text" id="" name="phone" class="form-control w-full mb-3"
                                        title="Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số"
                                        placeholder="Số điện thoại..." required
                                        pattern="^(0(2[0-9]|3[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{7})|(\+84(2[0-9]|3[0-9]|7[0-9]|8[0-9]|9[0-9])[0-9]{7})$">
                                    <input type="email" id="" name="email" class="form-control w-full mb-3"
                                        placeholder="Email..." required pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" title="Email phải theo định dạng: example@gmail.com">
                                    <input type="text" id="" name="address" class="form-control w-full mb-3"
                                        placeholder="Địa chỉ..." required>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="text-[#EF5350] font-bold mb-2">Thông tin tiệc</h2>
                                    <input type="date" id="party-date" class="form-control w-full mb-3"
                                        placeholder="Ngày diễn ra..." min="" required
                                        title="Ngày diễn ra phải sau ngày hiện tại">
                                    <input type="time" id="" class="form-control w-full mb-3"
                                        placeholder="Giờ diễn ra..." min="07:00" max="20:00" required
                                        title="Giờ phải trong khoảng từ 7h sáng đến 8h tối">
                                    <input type="text" id="" class="form-control w-full mb-3"
                                        placeholder="Yêu cầu khác...">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="text-[#EF5350] font-bold mb-2">Phương thức thanh toán</h2>
                                    <ol class="p-0 m-0">
                                        <li class="flex justify-center items-center w-fit">
                                            <input type="radio" name="method" id="momo" value="1">
                                            <label for="momo" class="ml-2">Ví diện tử</label>
                                        </li>
                                        <li class="flex justify-center items-center w-fit">
                                            <input type="radio" name="method" id="bank" value="2">
                                            <label for="bank" class="ml-2">Ngân hàng</label>
                                        </li>
                                    </ol>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger" name="btnxn">Xác nhận</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dateInput = document.getElementById("party-date");
        const today = new Date();
        const formattedDate = today.toISOString().split("T")[0];

        dateInput.setAttribute("min", formattedDate);
        
        dateInput.addEventListener("blur", function () {
        if (dateInput,value < formattedDate) {
            dateInput.value = formattedDate;
        } 
    });
    });
</script>