<?php
$ctrl = new cPromotions;

echo "<script>
        window.addEventListener('load', () => {
            document.getElementById('promotion').classList.add('activeAd'); 
        });
    </script>";

// Khai báo riêng mảng lỗi cho từng form
$addErrors = array();
$updateErrors = array();

// Xử lý form thêm mới
if (isset($_POST["btnthemkm"])) {
    $proName = $_POST["proName"];
    $des = $_POST["description"];
    $percent = $_POST["percent"];
    $start = $_POST["startDate"];
    $end = $_POST["endDate"];
    $image = $_FILES["image"];
    $status = 1;

    if (empty($proName)) {
        $addErrors['proName'] = 'Vui lòng nhập tên khuyến mãi!';
    } elseif (strlen($proName) < 5) {
        $addErrors['proName'] = 'Tên khuyến mãi phải có ít nhất 5 ký tự!';
    }

    if (empty($des)) {
        $addErrors['description'] = 'Vui lòng nhập mô tả!';
    } elseif (strlen($des) < 10) {
        $addErrors['description'] = 'Mô tả phải có ít nhất 10 ký tự!';
    }

    if (empty($percent)) {
        $addErrors['percent'] = 'Vui lòng nhập phần trăm khuyến mãi!';
    } elseif (!is_numeric($percent) || $percent <= 0 || $percent > 100) {
        $addErrors['percent'] = 'Phần trăm khuyến mãi phải từ 1 đến 100!';
    }

    if (empty($start)) {
        $addErrors['startDate'] = 'Vui lòng chọn ngày bắt đầu!';
    }

    if (empty($end)) {
        $addErrors['endDate'] = 'Vui lòng chọn ngày kết thúc!';
    }

    if (!empty($start) && !empty($end)) {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        $currentDate = new DateTime();

        if ($startDate > $endDate) {
            $addErrors['date'] = 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc!';
        }
        if ($startDate <= $currentDate) {
            $addErrors['startDate'] = 'Ngày bắt đầu phải từ ngày hiện tại trở đi!';
        }
    }

    if ($image["size"] == 0) {
        $addErrors['image'] = 'Vui lòng chọn ảnh!';
    } else {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $image["name"];
        $filetype = $image["type"];
        $filesize = $image["size"];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            $addErrors['image'] = 'Vui lòng chọn định dạng ảnh hợp lệ (jpg, jpeg, png)!';
        }

        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            $addErrors['image'] = 'Kích thước ảnh quá lớn. Vui lòng chọn ảnh dưới 5MB!';
        }
    }
    if (empty($addErrors)) {
        $imgName = $image["name"];
        move_uploaded_file($image["tmp_name"], "../../../images/promotion/".$imgName);
        
        if ($ctrl->cInsertPromotion($proName, $des, $percent, $start, $end, $imgName, $status)) {
            echo "<script>alert('Thêm khuyến mãi thành công!');</script>";
        } 
    } else {
        // Nếu có lỗi, hiển thị lại modal ngay lập tức
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var insertModal = document.getElementById('insertModal');
                var modal = new bootstrap.Modal(insertModal);
                modal.show();
            });
        </script>";
    }
}

if (isset($_POST["btncapnhat"])) {

    echo "<script>
            window.addEventListener('load', () =>  {
                var modalUpdate = new bootstrap.Modal(document.getElementById('updateModal'));
                modalUpdate.show();
            });
        </script>";

    $proID = $_POST["btncapnhat"];

    $row = $ctrl->cGetPromotionById($proID);

    $_SESSION["proID"] = $row["promotionID"];
    $_SESSION["proName"] = $row["promotionName"];
    $_SESSION["description"] = $row["description"];
    $_SESSION["percent"] = $row["discountPercentage"];
    $_SESSION["startDate"] = $row["startDate"];
    $_SESSION["endDate"] = $row["endDate"];
    $_SESSION["status"] = $row["status"];
    $_SESSION["currentImage"] = $row["image"];
}

if (isset($_POST["btnsuakm"])) {
    $proID = $_SESSION["proID"];
    $proName = $_POST["proName"];
    $des = $_POST["description"];
    $percent = $_POST["percent"];
    $start = $_POST["startDate"];
    $end = $_POST["endDate"];
    $image = $_FILES["image"];
    $status = $_POST["status"];

    if (empty($proName)) {
        $updateErrors['proName'] = 'Vui lòng nhập tên khuyến mãi!';
    } elseif (strlen($proName) < 5) {
        $updateErrors['proName'] = 'Tên khuyến mãi phải có ít nhất 5 ký tự!';
    }

    if (empty($des)) {
        $updateErrors['description'] = 'Vui lòng nhập mô tả!';
    } elseif (strlen($des) < 10) {
        $updateErrors['description'] = 'Mô tả phải có ít nhất 10 ký tự!';
    }

    if (empty($percent)) {
        $updateErrors['percent'] = 'Vui lòng nhập phần trăm khuyến mãi!';
    } elseif (!is_numeric($percent) || $percent <= 0 || $percent > 100) {
        $updateErrors['percent'] = 'Phần trăm khuyến mãi phải từ 1 đến 100!';
    }

    if (empty($start)) {
        $updateErrors['startDate'] = 'Vui lòng chọn ngày bắt đầu!';
    }

    if (empty($end)) {
        $updateErrors['endDate'] = 'Vui lòng chọn ngày kết thúc!';
    }

    if (!empty($start) && !empty($end)) {
        $startDate = new DateTime($start);
        $endDate = new DateTime($end);
        $currentDate = new DateTime();

        if ($startDate > $endDate) {
            $updateErrors['date'] = 'Ngày bắt đầu phải nhỏ hơn ngày kết thúc!';
        }
        if ($startDate < $currentDate) {
            $updateErrors['startDate'] = 'Ngày bắt đầu phải từ ngày hiện tại trở đi!';
        }
    }

    if ($image["size"] > 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $image["name"];
        $filetype = $image["type"];
        $filesize = $image["size"];

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            $updateErrors['image'] = 'Vui lòng chọn định dạng ảnh hợp lệ (jpg, jpeg, png)!';
        }

        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            $updateErrors['image'] = 'Kích thước ảnh quá lớn. Vui lòng chọn ảnh dưới 5MB!';
        }
    }


    if (empty($updateErrors)) {
        $imgName = $image["size"] > 0 ? $image["name"] : $_SESSION["currentImage"];
        
        if ($image["size"] > 0) {
            move_uploaded_file($image["tmp_name"], "../../../images/promotion/".$imgName);
        }
        
        if ($ctrl->cUpdatePromotion($proID, $proName, $des, $percent, $start, $end, $imgName, $status)) {
            echo "<script>alert('Cập nhật khuyến mãi thành công!');</script>";
        }
    } else {
        // Nếu có lỗi, hiển thị lại modal ngay lập tức
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var updateModal = document.getElementById('updateModal');
                var modal = new bootstrap.Modal(updateModal);
                modal.show();
            });
        </script>";
    }
}

if (isset($_POST["btnkhoa"])) {
    $proID = $_POST["btnkhoa"];
    if ($ctrl->cUpdatePromotionStatus($proID)) {
        echo "<script>alert('Đã ngưng áp dụng khuyến mãi!');</script>";
    }
}
?>
<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
                Danh sách khuyến mãi
            </h2>
            <div class="flex items-center">
                <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#insertModal">Thêm khuyến mãi</button>
            </div>
            <div class="flex items-center">
                <button class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất <i class="fa-solid fa-table"></i></button>
                <button class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In <i class="fa-solid fa-print"></i></button>
            </div>
        </div>
        <div class="h-fit bg-gray-100 rounded-lg p-6">
            <form action="" method="POST">
                <table class="text-sm w-full text-center">
                    <thead>
                        <tr>
                            <th class="text-gray-600 border-2 py-2">Mã KM</th>
                            <th class="text-gray-600 border-2 py-2">Tên KM</th>
                            <th class="text-gray-600 border-2 py-2">Mô tả</th>
                            <th class="text-gray-600 border-2 py-2">Phần trăm</th>
                            <th class="text-gray-600 border-2 py-2">Ngày bắt đầu</th>
                            <th class="text-gray-600 border-2 py-2">Ngày kết thúc</th>
                            <th class="text-gray-600 border-2 py-2">Hình ảnh</th>
                            <th class="text-gray-600 border-2 py-2">Trạng thái</th>
                            <th class="text-gray-600 border-2 py-2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($ctrl->cGetAllPromotion() != 0) {
                            $result = $ctrl->cGetAllPromotion();
                            while ($row = $result->fetch_assoc()) {
                                echo "
                        <tr>
                            <td class='py-2 border-2'>#KM0" . ($row["promotionID"] < 10 ? "0" . $row["promotionID"] : $row["promotionID"]) . "</td>
                            <td class='py-2 border-2'>" . $row["promotionName"] . "</td>
                            <td class='py-2 border-2 w-40'>" . $row["description"] . "</td>
                            <td class='py-2 border-2'>" . str_replace(".00", "%", $row["discountPercentage"]) . "</td>
                            <td class='py-2 border-2'>" . $row["startDate"] . "</td>
                            <td class='py-2 border-2'>" . $row["endDate"] . "</td>
                            <td class='py-2 border-2'><img src='../../../images/promotion/" . $row["image"] . "' alt='" . $row["promotionName"] . "' class='size-24' /></td>
                            <td class='py-2 border-2 text-" . ($row["status"] == 1 ? "green" : "red") . "-500'>" . ($row["status"] == 1 ? "Đang áp dụng" : "Ngưng áp dụng") . "</td>
                            <td class='py-2 border-2 flex justify-center items-center h-28'>
                                <button class='btn btn-secondary mr-1' name='btncapnhat' value='" . $row["promotionID"] . "'>Cập nhật</button>
                                <button class='btn btn-danger ml-1' name='btnkhoa' value='" . $row["promotionID"] . "' onclick='return confirm(\"Bạn có chắc chắn khóa khuyến mãi này?\");'>Khóa</button>
                            </td>
                        </tr>";
                            }
                        } else echo "<tr><td colspan='9' class='text-center pt-2'>Chưa có dữ liệu!</td></tr>";
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <div class="modal modalInsert fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" class="form-container w-full" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="insertModalLabel" style="color: #E67E22;">Thêm khuyến mãi</h2>
                    </div>
                    <div class="modal-body">
                        <table class="w-full">
                            <tr>
                                <td>
                                    <label for="proName" class="w-full py-2"><b>Tên KM <span class="text-red-500">*</span></b></label>
                                    <input type="text" class="w-full form-control <?php echo isset($addErrors['proName']) ? 'border-red-500' : ''; ?>" 
                                        name="proName" value="<?php echo isset($proName) ? $proName : ''; ?>">
                                    <?php if (isset($addErrors['proName'])) {
                                        echo '<div class="text-red-500">' . $addErrors['proName'] . '</div>';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="description" class="w-full py-2"><b>Mô tả <span class="text-red-500">*</span></b></label>
                                    <input type="text" class="w-full form-control <?php echo isset($addErrors['description']) ? 'border-red-500' : ''; ?>" 
                                        name="description" value="<?php echo isset($des) ? $des : ''; ?>">
                                    <?php if (isset($addErrors['description'])) {
                                        echo '<div class="text-red-500">' . $addErrors['description'] . '</div>';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="percent" class="w-full py-2"><b>Phần trăm KM<span class="text-red-500">*</span></b></label>
                                    <input type="number" class="w-full form-control <?php echo isset($addErrors['percent']) ? 'border-red-500' : ''; ?>" 
                                        name="percent" value="<?php echo isset($percent) ? $percent : ''; ?>">
                                    <?php if (isset($addErrors['percent'])) {
                                        echo '<div class="text-red-500">' . $addErrors['percent'] . '</div>';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="startDate" class="w-full py-2"><b>Ngày bắt đầu<span class="text-red-500">*</span></b></label>
                                    <input type="date" class="w-full form-control <?php echo isset($addErrors['startDate']) ? 'border-red-500' : ''; ?>" 
                                        name="startDate" value="<?php echo isset($start) ? $start : ''; ?>">
                                    <?php if (isset($addErrors['startDate'])) {
                                        echo '<div class="text-red-500">' . $addErrors['startDate'] . '</div>';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="endDate" class="w-full py-2"><b>Ngày kết thúc<span class="text-red-500">*</span></b></label>
                                    <input type="date" class="w-full form-control <?php echo isset($addErrors['endDate']) ? 'border-red-500' : ''; ?>" 
                                        name="endDate" value="<?php echo isset($end) ? $end : ''; ?>">
                                    <?php if (isset($addErrors['endDate'])) {
                                        echo '<div class="text-red-500">' . $addErrors['endDate'] . '</div>';
                                    } ?>
                                    <?php if (isset($addErrors['date'])) {
                                        echo '<div class="text-red-500">' . $addErrors['date'] . '</div>';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="image" class="w-full py-2"><b>Hình ảnh<span class="text-red-500">*</span></b></label>
                                    <input type="file" class="w-full form-control <?php echo isset($addErrors['image']) ? 'border-red-500' : ''; ?>" 
                                        name="image">
                                    <?php if (isset($addErrors['image'])) {
                                        echo '<div class="text-red-500">' . $addErrors['image'] . '</div>';
                                    } ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="btnthemkm">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal modalUpdate fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="POST" class="form-container w-full" enctype="multipart/form-data">
                    <div class="modal-header justify-center">
                        <h2 class="modal-title fs-5 font-bold text-3xl" id="updateModalLabel" style="color: #E67E22;">Cập nhật khuyến mãi</h2>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label"><b>Tên khuyến mãi<span class="text-red-500">*</span></b></label>
                            <input type="text" class="form-control <?php echo isset($updateErrors['proName']) ? 'border-red-500' : ''; ?>" 
                                name="proName" value="<?php echo $_SESSION["proName"] ?? ''; ?>">
                            <?php if (isset($updateErrors['proName'])): ?>
                                <span class="text-red-500 text-sm mt-1 block"><?php echo $updateErrors['proName']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><b>Mô tả<span class="text-red-500">*</span></b></label>
                            <input type="text" class="form-control <?php echo isset($updateErrors['description']) ? 'border-red-500' : ''; ?>" 
                                name="description" value="<?php echo $_SESSION["description"] ?? ''; ?>">
                            <?php if (isset($updateErrors['description'])): ?>
                                <span class="text-red-500 text-sm mt-1 block"><?php echo $updateErrors['description']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><b>Phần trăm KM<span class="text-red-500">*</span></b></label>
                            <input type="number" class="form-control <?php echo isset($updateErrors['percent']) ? 'border-red-500' : ''; ?>" 
                                name="percent" value="<?php echo $_SESSION["percent"] ?? ''; ?>">
                            <?php if (isset($updateErrors['percent'])): ?>
                                <span class="text-red-500 text-sm mt-1 block"><?php echo $updateErrors['percent']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><b>Ngày bắt đầu<span class="text-red-500">*</span></b></label>
                            <input type="date" class="form-control <?php echo isset($updateErrors['startDate']) ? 'border-red-500' : ''; ?>" 
                                name="startDate" value="<?php echo $_SESSION["startDate"] ?? ''; ?>">
                            <?php if (isset($updateErrors['startDate']) || isset($updateErrors['date'])): ?>
                                <span class="text-red-500 text-sm mt-1 block">
                                    <?php echo $updateErrors['startDate'] ?? $updateErrors['date'] ?? ''; ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><b>Ngày kết thúc<span class="text-red-500">*</span></b></label>
                            <input type="date" class="form-control <?php echo isset($updateErrors['endDate']) ? 'border-red-500' : ''; ?>" 
                                name="endDate" value="<?php echo $_SESSION["endDate"] ?? ''; ?>">
                            <?php if (isset($updateErrors['endDate'])): ?>
                                <span class="text-red-500 text-sm mt-1 block"><?php echo $updateErrors['endDate']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><b>Hình ảnh</b></label>                 
                            <input type="file" class="form-control <?php echo isset($updateErrors['image']) ? 'border-red-500' : ''; ?>" 
                                name="image" accept="image/*">
                            <?php if (isset($updateErrors['image'])): ?>
                                <span class="text-red-500 text-sm mt-1 block"><?php echo $updateErrors['image']; ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><b>Trạng thái<span class="text-red-500">*</span></b></label>
                            <select name="status" class="form-control">
                                <option value="1" <?php echo ($_SESSION["status"] ?? '') == 1 ? 'selected' : ''; ?>>Đang áp dụng</option>
                                <option value="0" <?php echo ($_SESSION["status"] ?? '') == 0 ? 'selected' : ''; ?>>Ngưng áp dụng</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" name="btndong" data-bs-dismiss="modal" onclick="if (confirm('Thông tin chưa được lưu. Bạn có chắc chắn thoát?') === false) { var modalUpdate = new bootstrap.Modal(document.querySelector('.modalUpdate')); modalUpdate.show();}">Hủy</button>
                        <button type="submit" class="btn btn-primary" name="btnsuakm">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>