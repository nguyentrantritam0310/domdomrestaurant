<?php
session_start();
?>
<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center w-fit">
                <select name="" id="" class="form-control" onchange="window.location.href = this.value;">
                    <option value="#0">Tất cả</option>
                    <option value="#DT">Doanh thu</option>
                    <option value="#NV">Nhân viên</option>
                    <option value="#NL">Nguyên liệu</option>
                </select>
            </div>
            <div class="currentMonth">
                <form action="" method="post" class="revenueMonth flex items-center my-auto">
                    <input type="date" name="startM" id="startM"
                        class="bg-gray-100 border-solid border-2 rounded-lg py-1 px-3" value="<?php echo $startM; ?>">
                    <span class="mx-2">đến</span>
                    <input type="date" name="endM" id="endM"
                        class="bg-gray-100 border-solid border-2 rounded-lg py-1 px-3 mr-1"
                        value="<?php echo $endM; ?>">
                    <button type="submit" name="btnxem" id="btnxem" class="btn btn-primary ml-1 py-2 px-4 rounded-lg">Xem</button>
                </form>
            </div>
        </div>

        <hr>

        <div class="flex justify-between items-center my-4 w-full" id="DT">
            <h2 class="text-xl font-semibold">Doanhh thu bán hàng</h2>
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
            <table class="text-base w-full text-center">
                <thead>
                    <tr>
                        <th class="text-gray-600 border-2 py-2">Ngày</th>
                        <th class="text-gray-600 border-2 py-2">Món ăn</th>
                        <th class="text-gray-600 border-2 py-2">Tổng số lượng</th>
                        <th class="text-gray-600 border-2 py-2">Tồng hóa đơn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ctrl = new cOrders;
                    $storeID = $_SESSION["user"][1];

                    if ($ctrl->cGetRevenueOrderByStore($storeID, start: $startM, end: $endM)->num_rows > 0) {
                        $result = $ctrl->cGetRevenueOrderByStore($storeID, $startM, $endM);
                        $revenue = 0;
                        while ($row = $result->fetch_assoc()) {
                            echo "
                                        <tr>
                                            <td class='py-2 border-2'>" . date("d-m-Y", strtotime($row["orderDate"])) . "</td>
                                            <td class='py-2 border-2'>" . $row["dishes"] . "</td>
                                            <td class='py-2 border-2'>" . $row["sumOfQuantity"] . "</td>
                                            <td class='py-2 border-2'>" . str_replace(".00", "", number_format($row["total"], "2", ".", ",")) . "</td>
                                        </tr>
                                        ";

                            $revenue += $row["total"];
                        }

                    } else
                        echo "<tr>
                                    <td colspan='4' class='py-2 border-2'>Không có dữ liệu trong thời gian này!</td>
                                </tr>";

                    $_SESSION["revenue"] = $revenue;
                    echo "</tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan='3' class='font-bold text-lg text-left p-2 border-2'>
                                                    <p>Tổng doanh thu:</p>
                                                </td>
                                                <td class='text-center border-2'>
                                                    " . str_replace(".00", "", number_format($_SESSION["revenue"], 0, ".", ",")) . " đồng
                                                </td>
                                            </tr>
                                        </tfoot>"
                        ?>
            </table>
        </div>
        <!-- //////////////////// -->
        <div class="flex justify-between items-center my-4 w-full" id="NV">
            <h2 class="text-xl font-semibold">Chi phí nhân công</h2>
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
            <table class="text-base w-full text-center">
                <thead>
                    <tr>
                        <th class="text-gray-600 border-2 py-2">Vai trò</th>
                        <th class="text-gray-600 border-2 py-2">Tổng nhân viên</th>
                        <th class="text-gray-600 border-2 py-2">Tổng giờ công</th>
                        <th class="text-gray-600 border-2 py-2">Lương</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $ctrl = new cEmployees;
                    if ($ctrl->cGetRevenueEmployeeShiftByStore($storeID, $startM, $endM)->num_rows > 0) {
                        $result = $ctrl->cGetRevenueEmployeeShiftByStore($storeID, $startM, $endM);
                        $totalCostEmployee = 0;
                        while ($row = $result->fetch_assoc()) {
                            $totalCostEmployee += $row['totalSalary'];
                            echo "<tr>
                            <td class='border-2 py-2'>{$row['roleName']}</td>
                            <td class='border-2 py-2'>{$row['totalEmployees']}</td>
                            <td class='border-2 py-2'>{$row['totalHours']}</td>
                            <td class='border-2 py-2'>" . number_format($row['totalSalary'], 0, ',', '.') . "</td>
                        </tr>";
                        }
                    } else {
                        echo "<tr>
                            <td colspan='7' class='border-2 py-2'>Không có dữ liệu trong thời gian này!</td>
                        </tr>";
                    }

                    $_SESSION["totalCostEmployee"] = $totalCostEmployee;
                    echo '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="font-bold text-lg text-left p-2 border-2">
                            <p>Tổng chi phí:</p>
                        </td>
                        <td class="text-center border-2">' . number_format($_SESSION["totalCostEmployee"], 0, '.', ',') . ' đồng</td>
                    </tr>
                </tfoot>';
                    ?>
            </table>
        </div>

        <!-- ////////////////////Thống kê nvl -->
        <div class="flex justify-between items-center my-4 w-full" id="NL">
            <h2 class="text-xl font-semibold">Chi phí nguyên liệu</h2>
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
            <table class="text-base w-full text-center">
                <thead>
                    <tr>
                        <th class="text-gray-600 border-2 py-2">Nguyên liệu</th>
                        <th class="text-gray-600 border-2 py-2">Đơn vị tính</th>
                        <th class="text-gray-600 border-2 py-2">Số lượng tồn</th>
                        <th class="text-gray-600 border-2 py-2">Số lượng nhập</th>
                        <th class="text-gray-600 border-2 py-2">Số lượng xuất</th>
                        <th class="text-gray-600 border-2 py-2">Giá</th>
                        <th class="text-gray-600 border-2 py-2">Tổng chi phí</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ctrl = new cIngredients;
                    if ($ctrl->cGetRevenueIngredientByStore($storeID, $startM, $endM)->num_rows > 0) {
                        $result = $ctrl->cGetRevenueIngredientByStore($storeID, $startM, $endM);
                        while ($row = $result->fetch_assoc()) {
                            $exportQuantity = ($row['quantityImported'] - $row['quantityInStock'] < 0 ? 0 : $row['quantityImported'] - $row['quantityInStock']); // Tính sl xuất
                            $totalCost = $row['price'] * $row['quantityImported']; // Tính tổng chi phí
                            echo "<tr>
                                    <td class='border-2 py-2'>" . $row['ingredientName'] . "</td>
                                    <td class='border-2 py-2'>" . $row['unitOfcalculation'] . "</td>
                                    <td class='border-2 py-2'>" . $row['quantityInStock'] . "</td>
                                    <td class='border-2 py-2'>" . $row['quantityImported'] . "</td>
                                    <td class='border-2 py-2'>" . $exportQuantity . "</td>
                                    <td class='border-2 py-2'>" . number_format($row['price'], 0, ',', '.') . "</td>
                                    <td class='border-0 py-2'>" . number_format($totalCost, 0, ',', '.') . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='7' class='border-2 py-2'>Không có dữ liệu trong thời gian này!</td>
                            </tr>";
                    }

                    $_SESSION["totalCost"] = $totalCost;
                    echo '</tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="font-bold text-lg text-left p-2 border-2">
                            <p>Tổng chi phí:</p>
                        </td>
                        <td class="text-center border-2">' . number_format($_SESSION["totalCost"], 0, ',', '.') . ' đồng</td>
                    </tr>
                </tfoot>';
                    ?>
            </table>
        </div>
        <div class="flex justify-between items-center my-4 w-full">
            <h2 class="text-xl font-semibold">Lợi nhuận (đồng)</h2>
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
            <table class="text-base w-full text-center">
                <thead>
                    <tr>
                        <th class="text-gray-600 border-2 py-2">Doanh thu bán hàng</th>
                        <th class="text-gray-600 border-2 py-2">Chi phí nhân công</th>
                        <th class="text-gray-600 border-2 py-2">Chi phí nguyên liệu</th>
                        <th class="text-gray-600 border-2 py-2">Lợi nhuận</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $_SESSION["profit"] = $_SESSION["revenue"] - $_SESSION["totalCostEmplyee"] - $_SESSION["totalCost"];

                    echo '<tr>
                    <td class="border-2 py-2">' . number_format($_SESSION["revenue"], 0, ',', '.') . '</td>
                    <td class="border-2 py-2">' . number_format($_SESSION["totalCostEmployee"], 0, ',', '.') . '</td>
                    <td class="border-2 py-2">' . number_format($_SESSION["totalCost"], 0, ',', '.') . '</td>
                    <td class="border-2 py-2">' . number_format($_SESSION["profit"], 0, ',', '.') . '</td>
                    </tr>'
                        ?>
                </tbody>
            </table>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const startDate = document.getElementById("startM");
                const endDate = document.getElementById("endM");
                const btnXem = document.getElementById("btnxem");

                // Sự kiện thay đổi giá trị
                startDate.addEventListener("change", () => {
                    // Giới hạn giá trị tối thiểu của ngày kết thúc
                    endDate.min = startDate.value;
                });

                endDate.addEventListener("change", () => {
                    // Giới hạn giá trị tối đa của ngày bắt đầu
                    startDate.max = endDate.value;
                });

                // Kiểm tra trước khi submit
                btnXem.addEventListener("click", (e) => {
                    if (new Date(startDate.value) > new Date(endDate.value)) {
                        e.preventDefault(); // Ngăn submit form
                        alert("Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc!");
                    }
                });
            });
        </script>