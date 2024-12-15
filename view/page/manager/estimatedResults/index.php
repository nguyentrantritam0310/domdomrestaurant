<?php
if (isset($_POST["btnTinhNL"])) {
    $_SESSION["soluong"] = $_POST["tinhtoannlinput"];
}
?>

<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
                Danh sách nguyên liệu cần mua
            </h2>
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
            <form action="index.php?i=ingredient" method="POST" id="ketquanlform">
                <h2 class="text-xl font-semibold">
                    Nguyên liệu tươi
                </h2>
                <table class="text-base w-full text-center">
                    <thead>
                        <tr>
                            <th class="text-gray-600 border-2 py-2">Mã nguyên liệu</th>
                            <th class="text-gray-600 border-2 py-2">Tên nguyên liệu</th>
                            <th class="text-gray-600 border-2 py-2">Số lượng cần mua</th>
                            <th class="text-gray-600 border-2 py-2">Đơn vị tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ctrl = new cIngredients;
                        $result = $ctrl->cGetQuantityFreshIngredient($_SESSION["soluong"]);
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td class='py-2 border-2'><input readonly style='border: none; background: none;' type='number' name='Ingre[]' value='" . $row["ingredientID"] . "' class='w-20 py-1 px-3 rounded-md'></td>
                                    <td class='py-2 border-2'>" . $row["ingredientName"] . "</td>
                                    <td class='py-2 border-2'><input readonly style='border: none; background: none;' type='number' name='TotalQuantity[]' value='" . $row["TotalQuantity"] . "' class='w-24 text-center py-1 px-3 rounded-md' id='tinhtoannlinput-" . $row["dishID"] . "'></td>

                                    <td class='py-2 border-2'>" . $row["unitOfcalculation"] . "</td>
                                   
                                </tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
                <h2 class="text-xl font-semibold mt-3">
                    Nguyên liệu khô
                </h2>

                <table class="text-base w-full text-center">
                    <thead>
                        <tr>
                            <th class="text-gray-600 border-2 py-2">Mã nguyên liệu</th>
                            <th class="text-gray-600 border-2 py-2">Tên nguyên liệu</th>
                            <th class="text-gray-600 border-2 py-2">Số lượng ước tính</th>
                            <th class="text-gray-600 border-2 py-2">Số lượng cần mua</th>
                            <th class="text-gray-600 border-2 py-2">Đơn vị tính</th>
                            <th class="text-gray-600 border-2 py-2">Số lượng tồn</th>
                            <th class="text-gray-600 border-2 py-2">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ctrl = new cIngredients;
                            $result = $ctrl->cGetQuantityDryIngredient($_SESSION["soluong"], (int)$_SESSION["user"][0]);
                            $nlkID = 0;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td class='py-2 border-2'><input readonly style='border: none; background: none;' type='number' name='' value='" . $row["ingredientID"] . "' class='w-20 py-1 px-3 rounded-md'></td>
                                    <td class='py-2 border-2'>" . $row["ingredientName"] . "</td>
                                    <td class='py-2 border-2'><input readonly style='border: none; background: none;' type='number' name='' value='" . $row["TotalQuantity"] . "' class='w-20 py-1 px-3 rounded-md' id='tinhtoannlinput-" . $row["dishID"] . "'></td>";
                                if ($row["TotalQuantity"] - $row["quantityInStock"] > 0) {
                                    echo "<td class='py-2 border-2'><input type='number' name='' value='" . $row["TotalQuantity"] - $row["quantityInStock"] . "' class='w-20 py-1 px-3 rounded-md tinhtoannlinputcls' id='tinhtoannlinputt-" . $nlkID . "'></td>";
                                } else {
                                    echo "<td class='py-2 border-2'>Đã đủ</td>";
                                }
                                echo "
                                    <td class='py-2 border-2'>" . $row["unitOfcalculation"] . "</td>
                                    <td class='py-2 border-2'>" . $row["quantityInStock"] . "</td>";
                                if ($row["TotalQuantity"] - $row["quantityInStock"] > 0) {
                                    echo "<td class='py-2 border-2'><button type='button' name='btnNhapNL' class='btnNhapNLKho btn btn-danger'>Nhập</button></td>";
                                } else {
                                    echo "<td class='py-2 border-2'><button disabled type='button' class='btn btn-secondary'>Nhập</button></td>";
                                }

                                echo "</tr>";
                                $nlkID++;
                            }
                        ?>
                        <tr>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
                <button type='submit' class='btn btn-danger mt-3' name='btnLuuNL'>Lưu</button>
            </form>
        </div>
    </div>
</div>