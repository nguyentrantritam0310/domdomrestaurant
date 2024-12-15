<?php
/* Ghi đè js */
echo "<script>
    document.getElementById('ingredient').classList.add('activeAd');
    
    if (document.body.scrollHeight > window.innerHeight)
        document.getElementById('right').style.height = '';
    else
        document.getElementById('right').style.height = '100vh';
</script>";
$ctrl = new cIngredients;

if (isset($_POST["btnthemnl"])) {
    $ingreName = $_POST["ingreName"];
    $unit = $_POST["unitCalculation"];
    $price = $_POST["price"];
    $type = $_POST["typeIngre"];

    if ($ctrl->cInsertIngredient($ingreName, $unit, $price, $type)) {
        echo "<script>alert('Thêm nguyên liệu thành công')</script>";
    } else {
        echo "<script>alert('Thêm nguyên liệu thất bại')</script>";

    }
}

if (isset($_POST["btncapnhat"])) {

    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var modalUpdate = new bootstrap.Modal(document.getElementById('updateModal')); 
            modalUpdate.show();
        });
    </script>";

    $ingreID = $_POST["btncapnhat"];

    $row = $ctrl->cGetIngredientById($ingreID);

    $_SESSION["ingreID"] = $row["ingredientID"];
    $_SESSION["ingreName"] = $row["ingredientName"];
    $_SESSION["unit"] = $row["unitOfcalculation"];
    $_SESSION["price"] = $row["price"];
    $_SESSION["type"] = $row["typeIngredient"];
}

if (isset($_POST["btnSLT"])) {
    $ingreID = $_POST["btnSLT"];
    $ctrl = new cIngredients;
    $table = $ctrl->cGetAllStoreIngredient($ingreID);

    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
                var modalSLT = new bootstrap.Modal(document.getElementById('sltModal')); 
                modalSLT.show();
            });
        </script>";
    $_SESSION["storeNameSLT"] = [];
    $_SESSION["storeIDSLT"] = [];
    $_SESSION["quantityInStockSLT"] = [];
    $sltdem = 0;
    while ($r = $table->fetch_assoc()) {
        $_SESSION["ingredientIDSLT"] = $r["ingredientID"];
        $_SESSION["ingredientNameSLT"] = $r["ingredientName"];
        $_SESSION["storeNameSLT"][$sltdem] = $r["storeName"];
        $_SESSION["storeIDSLT"][$sltdem] = $r["storeID"];
        $_SESSION["quantityInStockSLT"][$sltdem] = $r["quantityInStock"];
        $sltdem++;
    }
}

if (isset($_POST["btnChuyenNL"])) {
    $soLuongChuyen = $_POST["txtQuantityInStock"];
    $storeThua = $_POST["txtStoreThua"];
    $storeThieu = $_POST["txtStoreThieu"];
    if ($ctrl->cUpdateStoresIngredient($storeThua, $storeThieu, $soLuongChuyen)) {
        echo "<script>alert('Chuyển nguyên liệu thành công')</script>";
    } else {
        echo "<script>alert('Chuyển nguyên liệu thất bại')</script>";
    }

}

if (isset($_POST["btnsuanl"])) {
    $ingreID = $_SESSION["ingreID"];
    $ingreName = $_POST["ingreName"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];
    $type = $_POST["typeIngre"];

    if($ctrl->cUpdateIngredient($ingreName, $unit, $price, $type, $ingreID)) {
        echo "<script>alert('Cập nhật thông tin nguyên liệu thành công')</script>";
    }else {
        echo "<script>alert('Cập nhật thông tin nguyên liệu thất bại')</script>";
    }
}

if (isset($_POST["btnkhoa"])) {
    $ingredientID = $_POST["btnkhoa"];
    $ctrl = new cIngredients;
    $table = $ctrl->cGetIngredientById($ingredientID);
    $status = $table["status"];

    $newStatus = ($status == 1) ? 0 : 1;

    $ctrl->cLockIngredient($newStatus, $ingredientID);
}

?>

<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
                Danh sách nguyên liệu
            </h2>
            <div class="flex items-center">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">Thêm
                    nguyên liệu</button>
            </div>

            <div class="flex items-center">
                <button
                    class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất
                    <i class="fa-solid fa-table"></i></button>
                <button
                    class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In
                    <i class="fa-solid fa-print"></i></button>
            </div>

        </div>
        <div class="h-fit bg-gray-100 rounded-lg p-6">
            <form action="" method="POST">
                <table class="text-base w-full text-center">
                    <thead>
                        <tr>
                            <th class="text-gray-600 border-2 py-2">Mã NL</th>
                            <th class="text-gray-600 border-2 py-2">Tên NL</th>
                            <th class="text-gray-600 border-2 py-2">Đơn vị tính</th>
                            <th class="text-gray-600 border-2 py-2">Giá mua (đồng)</th>
                            <th class="text-gray-600 border-2 py-2">Loại NL</th>
                            <th class="text-gray-600 border-2 py-2">Số lượng tồn</th>
                            <th class="text-gray-600 border-2 py-2">Trạng thái</th>
                            <th class="text-gray-600 border-2 py-2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ctrl = new cIngredients;
                        $productsPerPage = 6;
                        // Xác định trang hiện tại
                        if (isset($_GET['page_num']) && is_numeric($_GET['page_num'])) {
                            $currentPage = intval($_GET['page_num']);
                        } else {
                            $currentPage = 1;
                        }
                        // Tính toán vị trí bắt đầu lấy dữ liệu từ cơ sở dữ liệu
                        $startFrom = ($currentPage - 1) * $productsPerPage;
                        // Tổng số sản phẩm
                        $totalProducts = $table->num_rows;
                        // Tính toán số trang
                        $totalPages = ceil($totalProducts / $productsPerPage);
                        $result = $ctrl->cGetAllIngredientLimit($startFrom, $productsPerPage);
                        if ($ctrl->cGetAllIngredientLimit($startFrom, $productsPerPage) != 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "
                        <tr>
                            <td class='py-2 border-2'>#NL0" . ($row["ingredientID"] < 10 ? "0" . $row["ingredientID"] : $row["ingredientID"]) . "</td>
                            <td class='py-2 border-2'>" . $row["ingredientName"] . "</td>
                            <td class='py-2 border-2'>" . $row["unitOfcalculation"] . "</td>
                            <td class='py-2 border-2'>" . str_replace(".00", "", number_format($row["price"], "2", ".", ",")) . "</td>
                            <td class='py-2 border-2'>" . $row["typeIngredient"] . "</td>
                            <td class='py-2 border-2'> <button class=' mr-1' name='btnSLT' value='" . $row["ingredientID"] . "'><i class='fa-solid fa-eye fa-lg'></i></button></td>
                            <td class='py-2 border-2'><span class='bg-" . ($row["status"] == 1 ? "green" : "red") . "-100 text-" . ($row["status"] == 1 ? "green" : "red") . "-500 py-1 px-2 rounded-lg'>" . ($row["status"] == 1 ? "Đang dùng" : "Ngưng dùng") . "</span></td>
                            <td class='py-2 border-2 flex justify-center items-center'>
                                <button class='btn btn-primary mr-1' name='btncapnhat' value='" . $row["ingredientID"] . "'>Cập nhật</button>
                                <button  value='" . $row["ingredientID"] . "' class='btn btn-danger ml-1' name='btnkhoa' onclick='return confirm(\" Bạn có chắc muốn " . ($row["status"] == 1 ? "khóa" : "mở khóa") . " không? \")'>" . ($row["status"] == 1 ? "Khóa" : "Mở") . "</button>
                            </td>
                        </tr>";
                            }
                        } else
                            echo "<tr><td colspan='7' class='text-center pt-2'>Chưa có dữ liệu!</td></tr>";
                        ?>
                    </tbody>
                </table>
            </form>
            <?php
            $ctrl = new cIngredients;
            echo '<div class="pagination">';
            $totalPages = ceil($ctrl->cGetTotalIngredient() / $productsPerPage);
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='index.php?i=ingredient&page_num=$i'";
                if ($i == $currentPage) {
                    echo " class='active'";
                }
                echo ">$i</a>";
            }
            echo '</div>';
            ?>
        </div>
    </div>

    <div class="modal modalInsert fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-themnguyenlieu" action="" class="form-container w-full" method="POST">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="insertModalLabel" style="color: #E67E22;">
                            Thêm nguyên liệu</h2>
                    </div>
                    <div class="modal-body">
                        <table class="w-full">
                            <tr>
                                <td>
                                    <label for="ingreName" class="w-full py-2"><b>Tên NL <span class="text-red-500"
                                                id="errIngredientName">*</span></b></label>
                                    <input type="text" class="w-full form-control" id="iIngredientName"
                                        name="ingreName">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="typeIngre" class="w-full py-2"><b>Loại NL <span
                                                class="text-red-500"></span></b></label>
                                    <select name="typeIngre" class="w-full form-control">
                                        <?php
                                        $ctrl = new cIngredients;
                                        $result = $ctrl->cGetTypeIngredient();

                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["typeIngredient"] . "'>" . $row["typeIngredient"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="price" class="w-full py-2"><b>Giá mua <span class="text-red-500"
                                                id="errIngredientPrice">*</span></b></label>
                                    <input type="number" class="w-full form-control" name="price" id="iIngredientPrice">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="unit" class="w-full py-2"><b>Đơn vị tính <span
                                                class="text-red-500"></span></b></label>
                                    <select name="unitCalculation" id="unit" class="w-full form-control">
                                        <?php
                                        $ctrl = new cIngredients;

                                        if ($ctrl->cGetUnitIngredient() != 0) {
                                            $result = $ctrl->cGetUnitIngredient();

                                            while ($row = $result->fetch_assoc())
                                                echo "<option value='" . $row["unitOfcalculation"] . "'>" . $row["unitOfcalculation"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button onclick="if (confirm('Thông tin chưa được lưu. Bạn có chắc chắn thoát?') === false) { var modalInsert = new bootstrap.Modal(document.querySelector('.modalInsert')); modalInsert.show();}" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="btnthemnl">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modalUpdate fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-suanguyenlieu" action="" method="POST" class="form-container w-full">
                    <div class="modal-header justify-center">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="updateModalLabel" style="color: #E67E22;">
                            Cập nhật nguyên liệu</h2>
                    </div>
                    <div class="modal-body">
                        <table class="w-full">
                            <tr>
                                <td>
                                    <label for="ingreName" class="w-full py-2"><b>Tên nguyên liệu <span
                                                class="text-red-500" id="uerrIngredientName">*</span></b></label>
                                    <input id="uIngredientName" type="text" class="w-full form-control" name="ingreName"
                                        value="<?php echo $_SESSION["ingreName"]; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="typeIngre" class="w-full py-2"><b>Loại nguyên liệu</b></label>
                                    <select name="typeIngre" class="w-full form-control">
                                        <?php
                                        $type = $_SESSION["type"];
                                        echo "<option value='" . $type . "' selected>" . $type . "</option>";

                                        $result = $ctrl->cGetIngredientNotType($type);
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row["typeIngredient"] . "'>" . $row["typeIngredient"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="price" class="w-full py-2"><b>Giá mua <span class="text-red-500"
                                                id="uerrIngredientPrice">*</span></b></label>
                                    <input id="uIngredientPrice" type="number" class="w-full form-control" name="price"
                                        value="<?php echo $_SESSION["price"]; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="unit" class="w-full py-2"><b>Đơn vị tính</b></label>
                                    <select name="unit" id="cate" class="w-full form-control">
                                        <?php
                                        $ctrl = new cIngredients;

                                        if ($ctrl->cGetIngredientById($_SESSION["ingreID"]) != 0) {
                                            $row = $ctrl->cGetIngredientById($_SESSION["ingreID"]);

                                            echo "<option value='" . $row["unitOfcalculation"] . "'>" . $row["unitOfcalculation"] . "</option>";
                                        }

                                        if ($ctrl->cGetIngredientNotUnit($_SESSION["unit"]) != 0) {
                                            $result = $ctrl->cGetIngredientNotUnit($_SESSION["unit"]);

                                            while ($row = $result->fetch_assoc())
                                                echo "<option value='" . $row["unitOfcalculation"] . "'>" . $row["unitOfcalculation"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" name="btndong" data-bs-dismiss="modal"
                            onclick="if (confirm('Thông tin chưa được lưu. Bạn có chắc chắn thoát?') === false) { var modalUpdate = new bootstrap.Modal(document.querySelector('.modalUpdate')); modalUpdate.show();}">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="btnsuanl">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modalSLT fade modal-lg" id="sltModal" tabindex="-1" aria-labelledby="sltModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-SLT" action="" method="POST" class="form-container w-full">
                    <div class="modal-header justify-center">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="sltModalLabel" style="color: #E67E22;">Số
                            lượng tồn</h2>
                    </div>
                    <div class="modal-body">
                        <p class="font-bold text-gray-600 mb-2">Danh sách tồn kho của
                            <?php echo $_SESSION["ingredientNameSLT"]; ?>
                        </p>
                        <table class="text-base w-full text-center">
                            <thead>
                                <tr>
                                    <th class="text-gray-600 border-2 py-2">Cửa hàng</th>
                                    <th class="text-gray-600 border-2 py-2">Số lượng tồn</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($_SESSION["storeNameSLT"] as $index => $storeName) {
                                    echo "<tr>
                                    <td class='py-2 border-2'>" . $storeName . "</td>
                                    <td class='py-2 border-2'>" . $_SESSION["quantityInStockSLT"][$index] . "</td></tr>
                                    ";
                                }
                                ?>
                            </tbody>
                        </table>
                        <p class="font-bold text-gray-600 mb-2 mt-3">Chuyển nguyên liệu giữa các cửa hàng</p>
                        <div class="d-flex">
                            <div class="d-flex w-50 mr-3">
                                <label style="width:30%;" class="mt-1" for="txtStoreThua">CH thừa</label>
                                <select class="form-control" name="txtStoreThua" id="txtStoreThua">
                                    <?php
                                    foreach ($_SESSION["storeNameSLT"] as $index => $storeName) {
                                        echo "<option data-quantity='" . $_SESSION["quantityInStockSLT"][$index] . "' value='" . $_SESSION["storeIDSLT"][$index] . "'>$storeName</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="d-flex w-50 ml-3">
                                <label style="width:30%;" class="mt-1" for="txtStoreThieu">CH thiếu</label>
                                <select class="form-control" name="txtStoreThieu" id="txtStoreThieu">
                                    <?php
                                    foreach ($_SESSION["storeNameSLT"] as $index => $storeName) {
                                        echo "<option data-quantity='" . $_SESSION["quantityInStockSLT"][$index] . "' value='" . $_SESSION["storeIDSLT"][$index] . "'>$storeName</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="mt-1 d-flex">
                            <div style="width: 12.3%;"></div>
                            <p class="text-danger" id="errStore">*</p>
                        </div>

                        <div class="d-flex mt-2">
                            <label style="width: 12.3%" for="txtQuantityInStock">Số lượng</label>
                            <input class="form-control" type="number" id="txtQuantityInStock" name="txtQuantityInStock">
                        </div>

                        <div class="d-flex mt-2">
                            <div style="width: 12.3%;"></div>
                            <p class="text-danger" id="errQuantityInStock">*</p>
                        </div>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" name="btndong" data-bs-dismiss="modal"
                            onclick="if (confirm('Thông tin chưa được lưu. Bạn có chắc chắn thoát?') === false) { var modalSLT = new bootstrap.Modal(document.querySelector('.modalSLT')); modalSLT.show();}">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="btnChuyenNL">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>