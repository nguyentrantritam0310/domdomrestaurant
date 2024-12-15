<?php
$_SESSION["currentTotal"] = 0;

$currentPath = $_SERVER['REQUEST_URI'];

if (isset($_POST["store"])) {
    $storeID = $_POST["store"];
    setcookie("selectedStore", $_POST["store"], time() + 3600, "/");
    
    echo "<script>window.location.href = '".$currentPath."';</script>";
}

$selectedStore = isset($_COOKIE["selectedStore"]) ? $_COOKIE["selectedStore"] : "";
?>
<!DOCTYPE html>
<html lang="en">

</html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Font Awesome -->
    <link href="view/css/all.css" rel="stylesheet" />

    <!-- Preconnect for Google Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Playwrite+DE+Grund:wght@100..400&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Baloo+2:400,800&display=swap">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="view/css/bootstrap.min.css">

    <!-- Style CSS -->
    <link rel="stylesheet" href="view/css/style.css">

    <!-- SweetAlerts CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="view/js/tailwindcss.js"></script>

    <!-- jQuery -->
    <script src="view/js/jquery.min.js"></script>

    <!-- Chart -->
    <script src="view/js/chart.js"></script>

    <!-- Font Awesome JS -->
    <script src="view/js/all.js"></script>

    <!-- Bootstrap JS -->
    <script src="view/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="view/js/main.js"></script>

    <style>
        header {
            padding: 10px 0;
            transition: all 0.15s linear;
        }

        .scrolled {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 5px 10px 0 rgba(138, 155, 165, 0.15);
            padding: 2px 0;
            -webkit-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;
        }

        #onTopBtn {
            display: none;
        }

        .modal-backdrop {
            z-index: -1;
        }

        .banner {
            height: 100vh;
            background-size: cover;
        }

        header .active {
            border-radius: 10px;
            border-bottom: 2px solid;
            border-color: var(--fourth-color);
            opacity: 0.7;
            transition: all 0.2s ease;
        }

        .nav-item {
            position: relative;
            transition: all 200ms linear;
        }

        .nav-link:hover {
            border-radius: 10px;
            border-bottom: 2px solid;
            border-color: var(--fourth-color);
            opacity: 0.7;
            transition: all 0.2s ease;
        }

        .nav-item .dropdown-menu {
            transform: translate3d(0, 10px, 0);
            visibility: hidden;
            opacity: 0;
            max-height: 0;
            display: block;
            padding: 0;
            margin: 0;
            transition: all 200ms linear;
        }

        .nav-item:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            max-height: 999px;
            transform: translate3d(0, 0, 0);
        }

        .dropdown-menu {
            padding: 10px !important;
            left: -8%;
            margin: 0;
            font-size: 16px;
            letter-spacing: 1px;
            color: #212121;
            background-color: #fcfaff;
            border: none;
            border-radius: 6px;
            box-shadow: 0 5px 10px 0 rgba(138, 155, 165, 0.15);
            transition: all 200ms linear;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .dropdown-item {
            padding: 3px 12px;
            color: #212121;
            border-radius: 2px;
            transition: all 200ms linear;
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            color: #fff;
            background-color: rgba(129, 103, 169, .6);
        }

        #progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 4px;
            background-color: #EF5350;
            z-index: 9999;
            transition: width 0.4s ease-out;
        }
    </style>
</head>

<body
    style="scroll-behavior: smooth; font-family: 'Playwrite DE Grund', cursive; background-color: var(--third-color);">
    <div id="progress-bar">
    </div>
    <header class="fixed w-full top-0 z-50">
        <div class="container mx-auto px-6">
            <nav class="navbar navbar-expand-md">
                <a class="" href="index.php"><img src="images/logo-nobg.png" alt="" class="h-16 rounded-full"></a>
                <ul class="nav ml-auto py-4 py-md-0">
                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                        <a class="nav-link" href="index.php" id="home">Trang chủ</a>
                    </li>
                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                        <a class="nav-link dropdown-toggle" href="index.php?p=dish" id="dish">Thực đơn</a>
                        <div class="dropdown-menu">
                            <?php
                            $ctrl = new cDishes;

                            if ($ctrl->cGetAllCategory() != 0) {
                                $result = $ctrl->cGetAllCategory();
                                while ($row = $result->fetch_assoc()) {
                                    echo "<a class='dropdown-item' href='index.php?p=dish&c=" . $row["dishCategory"] . "#ci'>" . $row["dishCategory"] . "</a>";
                                }
                                
                                $db->close($conn);
                            } else
                                echo "Không có dữ liệu!";
                            ?>
                        </div>
                    </li>
                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                        <a class="nav-link" href="index.php?p=partypackage" id="partypackage">Dịch vụ</a>
                    </li>
                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                        <a class="nav-link" href="index.php?p=promotion" id="promotion">Khuyến mãi</a>
                    </li>
                </ul>
                <ul class="nav ml-auto py-4 py-md-0">
                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                        <form action="" method="POST">
                            <select name="store" id="" class="form-control" onchange="this.form.submit()">
                                <option value="">Chọn cửa hàng</option>
                                <option value="1" <?php echo $selectedStore == "1" ? "selected" : ""; ?>>Quận 1
                                </option>
                                <option value="4" <?php echo $selectedStore == "4" ? "selected" : ""; ?>>Quận 3
                                </option>
                                <option value="3" <?php echo $selectedStore == "3" ? "selected" : ""; ?>>Quận 5
                                </option>
                                <option value="5" <?php echo $selectedStore == "5" ? "selected" : ""; ?>>Quận 10
                                </option>
                                <option value="2" <?php echo $selectedStore == "2" ? "selected" : ""; ?>>Quận Tân Bình
                                </option>
                            </select>
                        </form>
                    </li>
                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4" data-bs-toggle="modal" data-bs-target="#cartModal"
                        title="Giỏ hàng">
                        <a class="nav-link" href="view/page/dish/cart.php" id="cart"><i
                                class="fas fa-shopping-cart text-xl"> </i>
                            <?php
                            if (isset($_SESSION["cart"])) {
                                echo "<span class='h-fit w-fit px-1.5 py-0.5 absolute -top-0.5 right-1 bg-gray-100 rounded-full text-xs'>" . count($_SESSION["cart"]) . "</span>";
                            }
                            ?>
                        </a>
                    </li>
                    <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4" data-bs-toggle="modal" data-bs-target="#followModal"
                        title="Theo dõi đơn hàng">
                        <a class="nav-link" href="#" id="flCart"><i class="fa-solid fa-eye text-lg"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="modal modalFollow" id="followModal" tabindex="-1" aria-labelledby="followModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header flex justify-center">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="followModalLabel" style="color: #E67E22;">
                            Theo dõi đơn hàng</h2>
                    </div>
                    <div class=" modal-body">
                        <div class="w-full border-b pb-4 mb-4">
                            <label for="" class="font-bold text-lg mb-2">Nhập mã đơn hàng</label>
                            <input type="text" name="txtMaDonHang" id="" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-danger" name="btnxn">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_POST["txtMaDonHang"])) {
        $orderDetails = null;
        $orderID = (int) $_POST["txtMaDonHang"];
        $ctrl = new cOrders;
        $ctrlMessage = new cMessage;
        $orderDetails = $ctrl->cGetAllOrderByID($orderID);
        if (isset($_POST["btnxn"])) {
            if ($orderDetails == 0) {
                $ctrlMessage->falseMessage("Không tìm thấy đơn hàng!");
            } else {
                foreach ($orderDetails['data'] as $orderdetail) {
                    $_SESSION["orderIDD"] = (int) $orderdetail["orderID"];
                    $orderDate = $orderdetail["orderDate"];
                    $total = $orderdetail["total"];
                    $status = (int) $orderdetail["status"];
                    $note = $orderdetail["note"];
                }
                echo "<script>
                document.addEventListener('DOMContentLoaded', function () {
                    const followDetailModal = new bootstrap.Modal(document.getElementById('followDetailModal'));
                    followDetailModal.show();
                });
            </script>";
            }
        }
    }

    if (isset($_POST["btnLuuThongTin"])) {
        if (isset($_POST["statusOrder0"]) && !isset($_POST["HuyDonHang"])) {
            $ctrl = new cOrders;
            $ctrlMessage = new cMessage;
            if (isset($_POST["dishName"])) {
                $quantityUpdate = $_POST["quantityUpdate"];
                $notes = (isset($_POST["notes"]) ? trim($_POST["notes"]) : "");
                $tongTienCheck = (int) str_replace(['.', 'đ'], '', $_POST["tongTienCheck"]);
                $dishID = $_POST["dishID"];

                $result = $ctrl->cUpdateOrderDish((int) $_SESSION["orderIDD"], $quantityUpdate, $notes, $tongTienCheck, $dishID);

                if (!$result)
                    $ctrlMessage->errorMessage("Thay đổi đơn hàng ");
                else
                    $ctrlMessage->successMessage("Thay đổi đơn hàng ");


            } else if (isset($_POST["partyPackageName"])) {
                $notes = (isset($_POST["notes"]) ? trim($_POST["notes"]) : "");

                if ($ctrl->cUpdateOrderPartyPackage($_SESSION["orderIDD"], $notes))
                    $ctrlMessage->successMessage("Thay đổi đơn hàng ");
                else
                    $ctrlMessage->errorMessage("Thay đổi đơn hàng ");
            }
        }

        if (isset($_POST["statusOrder1"]) && !isset($_POST["HuyDonHang"])) {
        
            $ctrlMessage = new cMessage;
            
                $ctrlMessage->falseMessage("Đơn hàng này không được phép chỉnh sửa");
        }
    }

    if (isset($_POST["statusOrder0"]) && isset($_POST["HuyDonHang"])) {
        $ctrl = new cOrders;
        $ctrlMessage = new cMessage;
        if ($ctrl->cUpdateStatusOrder($_SESSION["orderIDD"], 4, NULL))
            $ctrlMessage->successMessage("Huỷ đơn hàng ");
        else
            $ctrlMessage->errorMessage("Huỷ đơn hàng ");
    }else if(!isset($_POST["statusOrder0"]) && isset($_POST["HuyDonHang"])) {
        $ctrlMessage = new cMessage;
        $ctrlMessage->errorMessage("Huỷ đơn hàng ");
    }
    ?>

    <?php if (isset($orderDetails)): ?>
        <div class="modal modalFollowDetail modal-lg" id="followDetailModal" tabindex="-1"
            aria-labelledby="followDetailModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="" method="POST" id="infoOrder">
                        <div class="modal-header flex justify-center">
                            <h2 class="modal-title fs-5 font-bold text-3xl" id="followDetailModalLabel"
                                style="color: #E67E22;">Thông tin đơn hàng</h2>
                        </div>
                        <div class=" modal-body">
                            <div class="w-full border-b pb-4 mb-4">

                                <!-- <input onclick='return confirm(" Bạn có chắc muốn hủy đơn hàng không?")' name="HuyDonHang"
                                    type="submit" value="Hủy đơn hàng" class="btn btn-danger"> -->
                                <table class="w-full">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label for="" class="font-bold mb-2">Mã đơn hàng</label>
                                                <input type="text" name="" id=""
                                                    class="form-control mb-2 bg-secondary-subtle"
                                                    value="#Order0<?php echo $_SESSION["orderIDD"]; ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="" class="font-bold mb-2">Ngày đặt</label>
                                                <input type="text" name="" id=""
                                                    class="form-control mb-2 bg-secondary-subtle"
                                                    value="<?php echo date('d-m-Y', strtotime($orderDate)); ?>" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <?php if ($orderDetails['type'] == 'dishes'): ?>
                                                    <label for="" class="font-bold mb-2">Tên món ăn</label>
                                                    <?php
                                                    $ctrl = new cOrders;
                                                    $result = $ctrl->cGetAllOrderDishByID($orderID);
                                                    $tongtien = 0;
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<input type="hidden" name="dishID[]" value= "' . $row["dishID"] . '">';
                                                        echo '<div class="flex items-center border-b pb-4 mb-4">
                                                                <img alt="' . $row["dishName"] . '" class="w-20 h-20 object-cover rounded"
                                                                    height="100" src="images/dish/' . $row["image"] . '" width="100" />
                                                                <div class="ml-4 flex-1">
                                                                    <h3 class="text-lg font-semibold">' . $row["dishName"] . '</h3>
                                                                    <div class="flex items-center mt-2">
                                                                        <span class="text-gray-500"></span>
                                                                        <div class="flex items-center border rounded">
                                                                        <input name="quantityUpdate[]" min="1" type="number" value="' . $row["quantity"] . '" 
                                                                                class="form-control w-20 quantity-input" 
                                                                                data-unit-price="' . $row["price"] . '"
                                                                            ></div>
                                                                    </div>
                                                                </div>
                                                                <div class="text-right">
                                                                    <p class="text-lg font-semibold">' . number_format($row["price"], 0, ',', '.') . 'đ</p>
                                                                </div>
                                                            </div>';
                                                        $tongtien += $row['quantity'] * $row['price'];


                                                        echo '<input type="hidden" name="currentTotal" id="currentTotal" value= "' . $row["total"] . '">';
                                                        echo '<input type="hidden" name="dishName" value= "' . $row["dishName"] . '">';
                                                        if ($status == 0) {
                                                            echo '<input type="hidden" name="statusOrder0" id="statusOrder0" value= "0">';
                                                        } else {
                                                            echo '<input type="hidden" name="statusOrder1" id="statusOrder1" value= "1">';
                                                        }
                                                    }


                                                    ?>
                                                <?php elseif ($orderDetails['type'] == 'package'): ?>
                                                    <label for="" class="font-bold mb-2">Tên gói tiệc</label>
                                                    <?php
                                                    $ctrl = new cOrders;
                                                    $result = $ctrl->cGetAllOrderPackageByID($orderID);
                                                    $tongtien = 0;
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<div class="flex items-center border-b pb-4 mb-4">
                                                        <img alt="Blue T-shirt" class="w-20 h-20 object-cover rounded"
                                                            height="100" src="images/party/' . $row["image"] . '" width="100" />
                                                        <div class="ml-4 flex-1">
                                                            <h3 class="text-lg font-semibold">' . $row["partyPackageName"] . '</h3>
                                                            <div class="flex items-center mt-2">
                                                                <span class="text-gray-500"></span>
                                                                <div class="flex items-center border rounded">
                                                                        <input name="quantityUpdate" type="number" value="1" 
                                                                        class="form-control w-20 quantity-input" 
                                                                        disabled
                                                                      >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text-right">
                                                            <p class="text-lg font-semibold">' . number_format($row["price"], 0, ',', '.') . 'đ</p>
                                                        </div>
                                                    </div>';

                                                        $tongtien += $row['price'];
                                                        echo '<input type="hidden" name="currentTotal" id="currentTotal" value= "' . $row["total"] . '">';
                                                        echo '<input type="hidden" name="partyPackageName" value= "' . $row["partyPackageName"] . '">';
                                                        if ($status == 0) {
                                                            echo '<input type="hidden" name="statusOrder0" id="statusOrder0" value= "0">';
                                                        } else {
                                                            echo '<input type="hidden" name="statusOrder1" id="statusOrder1" value= "1">';
                                                        }
                                                    }
                                                    ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <label for="" class="font-bold mb-2">Tổng tiền</label>
                                                <input id="tongTienCheck" type="text" name="tongTienCheck"
                                                    class="form-control mb-2 bg-secondary-subtle"
                                                    value="<?php echo number_format($tongtien, 0, ',', '.') ?>đ" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="" class="font-bold mb-2">Ghi chú</label>
                                                <textarea name="notes" id=""
                                                    class="form-control"><?php echo $note; ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label for="" class="font-bold mb-2">Trạng thái</label>
                                                <input type="text" name="" id=""
                                                    class="form-control mb-2 bg-secondary-subtle" value="<?php switch ($status) {
                                                        case 0:
                                                            echo "Chờ nhận đơn";
                                                            break;
                                                        case 1:
                                                            echo "Đang chế biến";
                                                            break;
                                                        case 2:
                                                            echo "Chế biến xong";
                                                            break;
                                                        case 3:
                                                            echo "Hoàn thành";
                                                            break;
                                                        case 4:
                                                            echo "Đã hủy";
                                                            break;
                                                        default:
                                                            echo "Trạng thái không hợp lệ";
                                                            break;
                                                    } ?>" readonly>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <input onclick='return confirm(" Bạn có chắc muốn hủy đơn hàng không?")' name="HuyDonHang"
                                type="submit" value="Hủy đơn hàng" class="btn btn-danger">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-danger" name="btnLuuThongTin"
                                id="btnLuuThongTin">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="banner w-full flex items-center relative">
        <div id="carousel" class="carousel slide w-full" data-bs-ride="carousel">
            <div class="carousel-indicators" id="ci">
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true"
                    aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="2000">
                    <img src="images/banner.png" class="d-block w-100" alt="images/banner.png">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="images/banner2.png" class="d-block w-100" alt="images/banner2.png">
                </div>
                <div class="carousel-item">
                    <img src="images/banner3.png" class="d-block w-100" alt="images/banner3.png">
                </div>
            </div>
        </div>
    </div>