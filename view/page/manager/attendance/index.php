<?php

$ctrlMessage = new cMessage;

if (isset($_POST["btndd"])) {
    list($shiftID, $date) = explode("/", $_POST["btndd"]);

    $sql = "UPDATE `employee_shift` SET status = 1 WHERE shiftID = $shiftID AND date = '$date'";
    $result = $conn->query($sql);

    if ($result)
        $ctrlMessage->successMessage("Đã chấm công ");
    else
        $ctrlMessage->errorMessage("Đã chấm công ");
}

?>

<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
                Danh sách nhân viên
            </h2>
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
            <form action="" method="POST">
                <table class="text-sm w-full text-center" id="table">
                    <thead>
                        <tr>
                            <th class="text-gray-600 border-2 py-2">Mã NV</th>
                            <th class="text-gray-600 border-2 py-2">Họ tên</th>
                            <th class="text-gray-600 border-2 py-2">Ca làm việc</th>
                            <th class="text-gray-600 border-2 py-2">Trạng thái</th>
                            <th class="text-gray-600 border-2 py-2">Chức năng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ctrl = new cEmployees;
                        $storeID = $_SESSION["user"][1];
                        $attendanceData = [];

                        if ($ctrl->cGetEmployeeAttendance($storeID)->num_rows > 0) {
                            $result = $ctrl->cGetEmployeeAttendance($storeID);

                            while ($row = $result->fetch_assoc()) {
                                echo "
                                    <tr>
                                        <td class='py-2 border-2'>#NV0" . ($row["userID"] < 10 ? "0" . $row["userID"] : $row["userID"]) . "</td>
                                        <td class='py-2 border-2'>" . $row["userName"] . "</td>
                                        <td class='py-2 border-2'>" . $row["shiftName"] . "</td>
                                        <td class='py-2 border-2'><span class='bg-" . ($row["status"] == 0 ? "red" : "green") . "-100 text-" . ($row["status"] == 0 ? "red" : "green") . "-500 px-3 py-1 rounded-lg'>" . ($row["status"] == 0 ? "Chưa chấm công" : "Đã chấm công") . "</span></td>
                                        <td class='py-2 border-2'><button type='submit' value='" . $row["shiftID"] . "/" . $row["date"] . "' name='btndd' ".($row["status"] == 0 ? "":"disabled")." class='btn btn-danger'>Chấm công</button></td>
                                    </tr>
                                    ";
                                $attendanceData[] = [
                                    "Mã nhân viên" => $row["userID"],
                                    "Tên nhân viên" => $row["userName"],
                                    "Ca làm" => $row["shiftName"],
                                    "Cửa hàng làm việc" => $row["storeName"]
                                ];

                            }

                            $data = json_encode($attendanceData);
                        } else
                            echo "<tr><td colspan='5'>Chưa có dữ liệu cho hôm nay!</td></tr>";
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
    <script>
        /* Xuất */
        document.getElementById("export").addEventListener("click", function () {
            let data = <?php echo $data; ?>;

            let worksheet = XLSX.utils.json_to_sheet(data);

            let workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Bảng chấm công");

            XLSX.writeFile(workbook, "Bảng chấm công.xlsx");
        });

        /* In  */
        document.getElementById("print").addEventListener("click", () => {
            var actionColumn = document.querySelectorAll("#table tr td:last-child, #table tr th:last-child");

            actionColumn.forEach(function (cell) {
                cell.style.display = "none";
            });

            var content = document.getElementById("table").outerHTML;

            var printWindow = window.open("", "", "height=500,width=800");

            printWindow.document.write("<html><head><title>In bảng chấm công</title>");
            printWindow.document.write("<style>table {width: 100%; border-collapse: collapse;} table, th, td {border: 1px solid black; padding: 10px;} </style>");
            printWindow.document.write("</head><body>");
            printWindow.document.write("<h1>Bảng chấm công</h1>");
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