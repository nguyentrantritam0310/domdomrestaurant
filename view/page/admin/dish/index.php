<?php
$ctrl = new cDishes;
function removeVietnameseAccents($str)
{
    $unicode = array(
        'a' => ['á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'],
        'd' => ['đ'],
        'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ'],
        'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị'],
        'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'],
        'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'],
        'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'],
        'A' => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ'],
        'D' => ['Đ'],
        'E' => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ'],
        'I' => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'],
        'O' => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ'],
        'U' => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự'],
        'Y' => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ']
    );

    foreach ($unicode as $nonAccent => $accentedChars) {
        $str = str_replace($accentedChars, $nonAccent, $str);
    }

    $str = str_replace(' ', '', $str);

    return strtolower($str);
}
if (isset($_POST["btnthemmon"])) {
    $dishName = $_POST["name"];
    $category = $_POST["cate"];
    $price = $_POST["price"];
    $ingredient = $_POST["ingredientIds"];
    $quantity = $_POST["quantity"];
    $prepare = $_POST["prepare"];
    $description = $_POST["description"];
    $image = $_FILES["image"];
    $imgName = removeVietnameseAccents($dishName) . ".png";
    if (move_uploaded_file($image["tmp_name"], "../../../images/dish/" . $imgName))
        if($ctrl->cInsertDish($dishName, $category, $price, $prepare, $imgName, $description, $ingredient, $quantity)){
            echo "<script>alert('Thêm món ăn thành công')</script>";
        
        }else {
            echo "<script>alert('Thêm món ăn thất bại')</script>";
        
        }
}



if (isset($_POST["btncapnhat"])) {
    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modalUpdate = new bootstrap.Modal(document.getElementById('updateModal')); 
        modalUpdate.show();
    });
  </script>";
    $dishID = $_POST["btncapnhat"];

    if ($ctrl->cGetDishById($dishID) != 0) {
        $result = $ctrl->cGetDishById($dishID);
        $count = 0;
        while ($row = $result->fetch_assoc()) {
            $_SESSION["dishID"] = $row["dishID"];
            $u_dishName = $row["dishName"];
            $u_category = $row["dishCategory"];
            $u_price = $row["price"];
            $u_description = $row["description"];
            $u_prepare = $row["preparationProcess"];
            $u_img = $row["image"];
            $u_ingredientID[$count] = $row["ingredientID"];
            $u_quantity[$count] = $row["quantity"];
            $u_ingredientName[$count] = $row["ingredientName"];
            $u_unitOfcalculation[$count] = $row["unitOfcalculation"];
            $count++;
        }
    }    
}


if (isset($_POST["btnsuamonan"])) {
    $ctrl = new cDishes;
    $dishID = $_SESSION["dishID"];
    $table = $ctrl->cGetAllDishIngredientByID($dishID);
    $_SESSION["ingredient"] = [];
    $index = 0;
    while ($row = $table->fetch_assoc()) {
        $_SESSION["ingredient"][$index] = $row["ingredientID"];
        $index++;
    }
    $dishName = $_POST["u-name"];
    $category = $_POST["u-cate"];
    $price = $_POST["u-price"];
    $unit = $_POST["u-unit"];
    $ingredient = $_POST["u-ingredientIds"];
    $quantity = $_POST["u-quantity"];
    $description = $_POST["u-description"];
    $prepare = $_POST["u-prepare"];
    $status = $_POST["u-status"];
    $image = $_FILES["u-image"];
    $currentDateTime = date("YmdHis_");
    $filename_new = $currentDateTime . removeVietnameseAccents($dishName) .".". pathinfo($image["name"], PATHINFO_EXTENSION);
    if ($image["type"] == "image/png" || $image["type"] == "image/jpeg" || $image["type"] == "image/jpg") {
        if (move_uploaded_file($image["tmp_name"], "../../../images/dish/" . $filename_new)) {
            if ($ctrl->cUpdateDish($dishName, $category, $price, $prepare, $imgName, $dishID, $filename_new, $description, $ingredient, $_SESSION["ingredient"], $quantity)) {
                echo "<script>alert('Cập nhật thông tin món ăn thành công!')</script>";
            } else {
                echo "<script>alert('Cập nhật thông tin món ăn thất bại!')</script>";
            }
        } else {
            echo "<script>alert('Upload ảnh thất bại')</script>";
        }
    } else {
        echo "<script>alert('Không phải ảnh. Vui lòng chọn lại ảnh khác!')</script>";
    }
}

if (isset($_POST["btnkhoa"])) {
    $dishID = $_POST["btnkhoa"];
    $ctrl = new cDishes;
    $table = $ctrl->cGetDishById($dishID);
    while ($row = $table->fetch_assoc()) {
        $status = $row["businessStatus"];
    }

    $newStatus = ($status == 1) ? 0 : 1;

    $ctrl->cLockDish($newStatus, $dishID);
    
}
?>
<script>
    document.querySelector('[name="btncapnhat"]').addEventListener('click', function (event) {
        // Ngăn chặn hành động mặc định của nút submit
        event.preventDefault();

        // Hiển thị modal
        document.getElementById('updateModal').style.display = 'block';
    });
</script>
<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
                Danh sách món ăn
            </h2>
            <div class="flex items-center">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">Thêm
                    món ăn</button>

            </div>
            <div class="flex items-center">
                <button
                    class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white"
                    id="export">Xuất <i class="fa-solid fa-table"></i></button>
                <button
                    class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white"
                    id="print">In <i class="fa-solid fa-print"></i></button>
            </div>
        </div>
        <div class="h-fit bg-gray-100 rounded-lg p-6">
            <form action="" method="POST" enctype="multipart/form-data">
                <table class="text-base w-full text-center" id="dishTable">
                    <thead>
                        <tr>
                            <th class="text-gray-600 border-2 py-2">Mã món</th>
                            <th class="text-gray-600 border-2 py-2">Tên món</th>
                            <th class="text-gray-600 border-2 py-2">Phân loại</th>
                            <th class="text-gray-600 border-2 py-2">Giá bán (đ)</th>
                            <th class="text-gray-600 border-2 py-2">Trạng thái</th>
                            <th class="text-gray-600 border-2 py-2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ctrl = new cDishes;
                        if ($ctrl->cGetAllDish() != 0) {
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

                            $table = $ctrl->cGetAllDishLimit($startFrom, $productsPerPage);
                            $dishData = [];

                            while ($row = $table->fetch_assoc()) {
                                echo "
                    <tr>
                        <td class='py-2 border-2'>#010" . $row["dishID"] . "</td>
                        <td class='py-2 border-2'>" . $row["dishName"] . "</td>
                        <td class='py-2 border-2'>" . $row["dishCategory"] . "</td>
                        <td class='py-2 border-2'>" . str_replace(".00", "", number_format($row["price"], "2", ".", ",")) . "</td>
                        <td class='py-2 border-2'><span class='bg-" . ($row["businessStatus"] == 1 ? "green" : "red") . "-100 text-" . ($row["businessStatus"] == 1 ? "green" : "red") . "-500 py-1 px-2 rounded-lg'>" . ($row["businessStatus"] == 1 ? "Đang kinh doanh" : "Ngưng kinh doanh") . "</span></td>
                        <td class='py-2 border-2 flex justify-center'>
                            <button value='" . $row["dishID"] . "' type='submit' class='btn btn-primary' name='btncapnhat' data-bs-toggle='modal' data-bs-target='#updateModal'>Cập nhật</button>
                            <button onclick='return confirm(\" Bạn có chắc muốn " . ($row["businessStatus"] == 1 ? "khóa" : "mở khóa") . " không? \")' type='submit' class='btn btn-danger ml-1' name='btnkhoa' value='" . $row["dishID"] . "'>" . ($row["businessStatus"] == 1 ? "Khóa" : "Mở") . "</button>
                        </td>
                    </tr>";
                                $dishData[] = [
                                    "Mã món" => $row["dishID"],
                                    "Tên món" => $row["dishName"],
                                    "Danh mục" => $row["dishCategory"],
                                    "Giá bán" => str_replace(".00", "", number_format($row["price"], "2", ".", ",")),
                                    "Trạng thái" => ($row["businessStatus"] == 1 ? "Đang kinh doanh" : "Ngưng kinh doanh")
                                ];
                            }
                            /* $_SESSION["dishData"] = $dishData; */
                        }
                        $data = json_encode($dishData);
                        
                        ?>
                    </tbody>
                </table>
            </form>
            <?php
            $ctrl = new cDishes;
            echo '<div class="pagination">';
            $totalPages = ceil($ctrl->cGetTotalDish() / $productsPerPage);
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href='index.php?i=dish&page_num=$i'";
                if ($i == $currentPage) {
                    echo " class='active'";
                }
                echo ">$i</a>";
            }
            echo '</div>';
            
            // $db->close($conn);
            ?>
        </div>
    </div>

    <div class="modal modal-lg modalInsert fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-themmonan" action="" method="POST" class="form-container w-full"
                    enctype="multipart/form-data">
                    <div class="modal-header justify-center">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="insertModalLabel" style="color: #E67E22;">
                            Thêm món ăn</h2>
                    </div>
                    <div class="modal-body">
                        <table class="w-full">
                            <tr id="hiddenIngre"></tr>
                            <tr>
                                <td>
                                    <label for="name" class="w-full py-2"><b>Tên món ăn <span class="text-red-500"
                                                id="ierrDishName">*</span></b></label>
                                    <input type="text" class="w-full form-control" name="name" id="iDishName">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="cate" class="w-full py-2"><b>Loại món ăn <span
                                                class="text-red-500">*</span></b></label>
                                    <select name="cate" id="cateDish" class="w-full form-control">
                                        <?php
                                        $ctrl = new cDishes;
                                        if ($ctrl->cGetAllDish() != 0) {
                                            $result = $ctrl->cGetAllCategory();

                                            while ($row = $result->fetch_assoc()) {
                                                echo "<option value='" . $row["dishCategory"] . "'>" . $row["dishCategory"] . "</option>";
                                            }
                                        }
                                        
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="price" class="w-full py-2"><b>Giá bán <span class="text-red-500"
                                                id="ierrDishPrice">*</span></b></label>
                                    <input type="number" class="w-full form-control" name="price" id="iDishPrice">
                                </td>
                            </tr>
                            <tr>
                                <table id="tableIngredient" class="w-full  text-center">
                                    <tr class="mb-2">
                                        <td> <label for="name" class="w-full py-2"><b>Mã NL</b></label></td>
                                        <td> <label for="name" class="w-full py-2"><b>Tên nguyên liệu <span
                                                        class="text-red-500"></span></b></label></td>
                                        <td> <label for="name" class="w-full py-2"><b>Đơn vị tính</b></label></td>
                                        <td> <label for="name" class="w-full py-2"><b>Số lượng <span
                                                        class="text-red-500">*</span></b></label></td>
                                        <td> <label for="name" class="w-full py-2"><b>Hành động</b></label></td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><span id="error-quantity-0" class="text-red-500 error-message"></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input name="ingredientIds[]" type="text" id="ma-0"
                                                class="clsNLThem w-20 form-control bg-gray-100" readonly>
                                        </td>
                                        <td>
                                            <select class="clsIngreName" name="ingredient[]" id="cateIngredient-0"
                                                data-row-id="0" class="w-full form-control">
                                                <?php
                                                $ctrl = new cIngredients;

                                                if ($ctrl->cGetAllIngredient1() != 0) {
                                                    $result = $ctrl->cGetAllIngredient1();

                                                    while ($row = $result->fetch_assoc()) {

                                                        echo "<option value='" . $row["unitOfcalculation"] . "' data-id='" . $row["ingredientID"] . "'>" . $row["ingredientName"] . "</option>";
                                                    }
                                                }
                                                
                                                ?>
                                            </select>
                                        </td>
                                        <div id="ingredientOptions" style="display: none;">
                                            <?php
                                            $ctrl = new cIngredients;

                                            if ($ctrl->cGetAllIngredient1() != 0) {
                                                $result = $ctrl->cGetAllIngredient1();

                                                while ($row = $result->fetch_assoc()) {

                                                    echo "<option value='" . $row["unitOfcalculation"] . "' data-id='" . $row["ingredientID"] . "'>" . $row["ingredientName"] . "</option>";
                                                }
                                            }
                                            
                                            ?>
                                        </div>
                                        <td>
                                            <input type="text" id="unit-0"
                                                class="clsDVT w-full form-control bg-gray-100" readonly>
                                        </td>
                                        <td>
                                            <input type="number" class="w-full form-control quantityIngre"
                                                id="quantityIngre-0" name="quantity[]">

                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="deleteRowBtn"><i
                                                    class="fa-solid fa-circle-minus text-danger text-xl text-center w-full"></i></a>
                                        </td>
                                    </tr>


                                </table>
                                <a href="javascript:void(0);" id="addRowBtn" class="btn btn-secondary mt-2">Thêm Hàng<i
                                        class="fa-solid fa-plus"></i></a>
                            </tr>

                            <tr>
                                <td>
                                    <label for="description" class="w-full py-2"><b>Mô tả <span id="ierrDishDescription"
                                                class="text-red-500">*</span></b></label>
                                    <textarea id="iDishDescription" class="w-full form-control" name="description"
                                        rows="4" cols="50" placeholder="Nhập quy mô tả..."></textarea>

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="prepare" class="w-full py-2"><b>Quy trình chế biến <span
                                                id="ierrDishProcess" class="text-red-500">*</span></b></label>
                                    <textarea id="iDishProcess" class="w-full form-control" name="prepare" rows="4"
                                        cols="50" placeholder="Nhập quy trình chế biến..."></textarea>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="image" class="w-full py-2"><b>Hình ảnh <span
                                                class="text-red-500"></span></b></label>
                                    <input type="file" class="w-full form-control" name="image" required>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            onclick="if (confirm('Thông tin chưa được lưu. Bạn có chắc chắn thoát?') === false) { var modalInsert = new bootstrap.Modal(document.querySelector('.modalInsert')); modalInsert.show();}">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="btnthemmon">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modal-lg modalUpdate fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-suamonan" action="" method="POST" class="form-container w-full"
                    enctype="multipart/form-data">
                    <div class="modal-header justify-center">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="updateModalLabel" style="color: #E67E22;">
                            Cập nhật món ăn</h2>
                    </div>
                    <div class="modal-body">
                        <table class="w-full">
                            <tr id="hiddenIngre"></tr>
                            <tr>
                                <td>
                                    <label for="uDishName" class="w-full py-2"><b>Tên món ăn <span class="text-red-500"
                                                id="uerrDishName">*</span></b></label>
                                    <input type="text" class="w-full form-control" name="u-name" id="uDishName" value="<?php if (isset($u_dishName))
                                        echo $u_dishName ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="u-cate" class="w-full py-2"><b>Loại món ăn <span
                                                    class="text-red-500">*</span></b></label>
                                        <select name="u-cate" class="w-full form-control">
                                            <?php
                                    $ctrl = new cDishes;
                                    if ($ctrl->cGetAllDish() != 0) {
                                        $result = $ctrl->cGetAllCategory();

                                        while ($row = $result->fetch_assoc()) {
                                            $selected = ($row["dishCategory"] == $u_category) ? "selected" : "";
                                            echo "<option value='" . $row["dishCategory"] . "'$selected>" . $row["dishCategory"] . "</option>";
                                        }
                                    }
                                    
                                    ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="uDishPrice" class="w-full py-2"><b>Giá bán <span class="text-red-500"
                                                id="uerrDishPrice">*</span></b></label>
                                    <input type="number" class="w-full form-control" name="u-price" id="uDishPrice"
                                        value="<?php if (isset($u_price))
                                            echo $u_price ?>">
                                    </td>
                                </tr>
                                <tr>
                                    <table id="u-tableIngredient" class="w-full  text-center">
                                        <tr class="mb-2">
                                            <td> <label for="name" class="w-full py-2"><b>Mã NL</b></label></td>
                                            <td> <label for="name" class="w-full py-2"><b>Tên nguyên liệu <span
                                                            class="text-red-500">*</span></b></label></td>
                                            <td> <label for="name" class="w-full py-2"><b>Đơn vị tính</b></label></td>
                                            <td> <label for="name" class="w-full py-2"><b>Số lượng <span
                                                            class="text-red-500">*</span></b></label></td>
                                            <td> <label for="name" class="w-full py-2"><b>Hành động</b></label></td>

                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><span id="uerror-quantity-0" class="text-red-500 uerror-message"></span>
                                            </td>
                                        </tr>
                                        <tr></tr>
                                        <input type="hidden" name="countIngre" id="u_countIngreDish"
                                            value="<?php echo count($u_ingredientID); ?>">
                                    <?php
                                    for ($i = 0; $i < count($u_ingredientID); $i++) {
                                        echo '<tr><td><span id="u-error-quantity-' . $i . '" class="text-red-500 error-message"></span></td></tr>
                                        <tr>
                                            <td>
                                                <input name="u-ingredientIds[]" type="text" id="u-ma-' . $i . '"
                                                    class="w-20 form-control bg-gray-100" readonly value="' . $u_ingredientID[$i] . '">
                                            </td>
                                            <td>
                                                <select name="u-ingredient[]" id="u-cateIngredient-' . $i . '" data-row-id="' . $i . '"
                                                    class="w-full form-control" value="' . $u_ingredientName[$i] . '">';
                                        $ctrl = new cIngredients;

                                        if ($ctrl->cGetAllIngredient1() != 0) {
                                            $result = $ctrl->cGetAllIngredient1();

                                            while ($row = $result->fetch_assoc()) {
                                                $selected = ($row["ingredientName"] == $u_ingredientName[$i]) ? "selected" : "";
                                                echo "<option $selected value='" . $row["unitOfcalculation"] . "' data-id='" . $row["ingredientID"] . "'>" . $row["ingredientName"] . "</option>";
                                            }
                                        }
                                        echo '
                                            </select>
                                        </td>
                                        <div id="u-ingredientOptions" style="display: none;">';

                                        $ctrl = new cIngredients;

                                        if ($ctrl->cGetAllIngredient1() != 0) {
                                            $result = $ctrl->cGetAllIngredient1();
                                            while ($row = $result->fetch_assoc()) {

                                                echo "<option value='" . $row["unitOfcalculation"] . "' data-id='" . $row["ingredientID"] . "'>" . $row["ingredientName"] . "</option>";


                                            }
                                        }
                                        echo '
                                        </div>
                                        <td>
                                            <input type="text" id="u-unit-' . $i . '" class="w-full form-control bg-gray-100"
                                                readonly value="' . $u_unitOfcalculation[$i] . '">
                                        </td>
                                        <td>
                                            <input id="uquantityIngre-' . $i . '" type="number" class="w-full form-control" name="u-quantity[]"
                                                required value="' . $u_quantity[$i] . '">
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="deleteRowBtn"><i
                                                    class="fa-solid fa-circle-minus text-danger text-xl text-center w-full"></i></a>
                                        </td>
                                    </tr>';
                                    }
                                    
                                    ?>


                                </table>
                                <a href="javascript:void(0);" id="u-addRowBtn" class="btn btn-secondary mt-2">Thêm
                                    Hàng<i class="fa-solid fa-plus"></i></a>
                            </tr>

                            <tr>
                                <td>
                                    <label for="u-description" class="w-full py-2"><b>Mô tả <span
                                                id="uerrDishDescription" class="text-red-500">*</span></b></label>
                                    <textarea id="uDishDescription" class="w-full form-control" name="u-description"
                                        rows="4" cols="50" placeholder="Nhập mô tả..."><?php if (isset($u_description))
                                            echo $u_description ?></textarea>

                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <label for="u-prepare" class="w-full py-2"><b>Quy trình chế biến <span
                                                    id="uerrDishProcess" class="text-red-500">*</span></b></label>
                                        <textarea id="uDishProcess" class="w-full form-control" name="u-prepare" rows="4"
                                            cols="50" placeholder="Nhập quy trình chế biến..."><?php if (isset($u_prepare))
                                            echo $u_prepare ?></textarea>

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="u-image" class="w-full py-2"><b>Hình ảnh <span
                                                    class="text-red-500">*</span></b></label>
                                        <input value="kk" type="file" class="w-full form-control" required name="u-image">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" name="btndong" data-bs-dismiss="modal"
                                onclick="if (confirm('Thông tin chưa được lưu. Bạn có chắc chắn thoát?') === false) { var modalUpdate = new bootstrap.Modal(document.querySelector('.modalUpdate')); modalUpdate.show();}">Hủy</button>
                            <button type="submit" class="btn btn-primary" name="btnsuamonan">Xác nhận</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>

    <script>
        /* Xuất */
        document.getElementById("export").addEventListener("click", function () {
            let data = <?php echo $data; ?>;

        let worksheet = XLSX.utils.json_to_sheet(data);

        let workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(workbook, worksheet, "Danh sách món ăn");

        XLSX.writeFile(workbook, "DishList.xlsx");
    });

    /* In  */
    document.getElementById("print").addEventListener("click", () => {
        var actionColumn = document.querySelectorAll("#dishTable tr td:last-child, #dishTable tr th:last-child");

        actionColumn.forEach(function (cell) {
            cell.style.display = "none";
        });

        var content = document.getElementById("dishTable").outerHTML;

        var printWindow = window.open("", "", "height=500,width=800");

        printWindow.document.write("<html><head><title>In danh sách món ăn</title>");
        printWindow.document.write("<style>table {width: 100%; border-collapse: collapse;} table, th, td {border: 1px solid black; padding: 10px;} </style>");
        printWindow.document.write("</head><body>");
        printWindow.document.write("<h1>Danh sách món ăn</h1>");
        printWindow.document.write(content);
        printWindow.document.write("</body></html>");

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();

        actionColumn.forEach(function (cell) {
            cell.style.display = "block";
        });
    });
</script>