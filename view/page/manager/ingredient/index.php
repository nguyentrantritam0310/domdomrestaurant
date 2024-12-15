<?php
if (isset($_POST["btnLuuNL"])) {
    $totalQuantity = $_POST["TotalQuantity"];
    $ingredient = $_POST["Ingre"];
    $userID = $_SESSION["user"][0];

    $ctrl = new cImportOrder;
   if( $ctrl->cInsertNeedIngredient($userID, $ingredient, $totalQuantity)) {
    header("Location:index.php?i=ingredient");
   }
}
?>
<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
                Danh sách món ăn
            </h2>
            <div class="flex items-center">
                <button class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất <i class="fa-solid fa-table"></i></button>
                <button class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In <i class="fa-solid fa-print"></i></button>
            </div>
        </div>
        <div class="h-fit bg-gray-100 rounded-lg p-6">
            <form action="index.php?i=estimatedResults" method="POST" id="tinhtoannlform">
                <table class="text-base w-full text-center">
                    <thead>
                        <tr>
                            <th class="text-gray-600 border-2 py-2">Mã món</th>
                            <th class="text-gray-600 border-2 py-2">Tên món</th>
                            <th class="text-gray-600 border-2 py-2">Số lượng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       $ctrl = new cDishes;
                       $result = $ctrl->cGetAllDish();
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td class='py-2 border-2'>#MA0" . $row["dishID"] . "</td>
                                    <td class='py-2 border-2'>" . $row["dishName"] . "</td>
                                    <td class='py-2 border-2'><input type='number' name='tinhtoannlinput[]' value='0' class='tinhtoannlinput w-16 py-1 px-3 rounded-md' id='tinhtoannlinput-" . $row["dishID"] . "'></td>
                                </tr>";
                            }
                        ?>
                        <tr>
                            <td colspan="2"></td>
                            <td class='py-2'><button type='submit' class='btn btn-danger' name='btnTinhNL' >Xác nhận</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>