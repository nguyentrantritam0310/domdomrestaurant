<?php

?>
<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-center items-center mb-4">
            <h2 class="text-xl font-semibold">
                Thông tin công việc trong tháng
            </h2>
        </div>
        <div class="h-fit bg-gray-100 rounded-lg p-6">
        <form action="" method="POST">
    <div class="mt-4">
        <!-- Input chọn tháng -->
        <label for="selectedMonth" class="text-gray-700 font-bold">Chọn tháng:</label>
        <input type="month" name="selectedMonth" id="selectedMonth" class="px-3 py-1 rounded-lg"
            value="<?php echo isset($_POST['selectedMonth']) ? $_POST['selectedMonth'] : date('Y-m'); ?>" 
            onchange="this.form.submit()">
    </div>

    <table class="text-base w-full text-center mt-4">
        <thead>
            <tr>
                <th class="text-gray-600 border-2 py-2">Thứ</th>
                <th class="text-gray-600 border-2 py-2">Ngày</th>
                <th class="text-gray-600 border-2 py-2">Ca làm việc</th>
                <th class="text-gray-600 border-2 py-2">Thời gian</th>
                <th class="text-gray-600 border-2 py-2">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Kiểm tra nếu có tháng được chọn từ form
            if (isset($_POST['selectedMonth'])) {
                $selectedMonth = $_POST['selectedMonth']; // Tháng người dùng đã chọn
            } else {
                // Nếu không có tháng được chọn, mặc định là tháng hiện tại
                $selectedMonth = date('Y-m');
            }

            $userID = $_SESSION["user"][0];
            $startMonth = $selectedMonth . "-01";  // Lấy ngày đầu tháng
            $endMonth = date("Y-m-t", strtotime($startMonth));  // Lấy ngày cuối tháng

            // Lấy thông tin ca làm việc trong tháng đã chọn
            $sql = "SELECT ES.date, S.shiftName, S.startTime, S.endTime, ES.status 
                    FROM `employee_shift` AS ES 
                    JOIN `shift` AS S ON ES.shiftID = S.shiftID 
                    WHERE ES.userID = $userID AND ES.date BETWEEN '$startMonth' AND '$endMonth'
                    ORDER BY ES.date";

            $result = $conn->query($sql);
            $totalHours = 0;
            $salary = 0;

            // Lọc thông tin cho tháng
            $shiftData = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $shiftData[$row["date"]] = $row;
                }
            }

            // Mảng ánh xạ các ngày trong tuần sang tiếng Việt
            $dayNames = [
                "Monday" => "Thứ 2", "Tuesday" => "Thứ 3", "Wednesday" => "Thứ 4", 
                "Thursday" => "Thứ 5", "Friday" => "Thứ 6", "Saturday" => "Thứ 7", 
                "Sunday" => "Chủ nhật"
            ];

            // Lặp qua tất cả các ngày trong tháng (từ 1 đến ngày cuối cùng của tháng)
            $currentDay = strtotime($startMonth);
            while (date("Y-m-d", $currentDay) <= $endMonth) {
                $dayStr = date("Y-m-d", $currentDay);
                $dayName = $dayNames[date("l", $currentDay)]; // Lấy tên thứ bằng tiếng Việt
                $shiftName = $startTime = $endTime = $status = "";

                // Kiểm tra nếu có ca làm việc trong ngày này
                if (isset($shiftData[$dayStr])) {
                    $row = $shiftData[$dayStr];
                    $shiftName = $row["shiftName"];
                    $startTime = substr($row["startTime"], 0, -3);
                    $endTime = substr($row["endTime"], 0, -3);
                    $status = ($row["status"] == 1) ? "Có mặt" : "Vắng mặt";

                    if ($row["status"] == 1) {
                        $start = DateTime::createFromFormat("H:i:s", $row["startTime"]);
                        $end = DateTime::createFromFormat("H:i:s", $row["endTime"]);
                        $interval = $start->diff($end);
                        $hoursWorked = $interval->h + ($interval->i / 60);
                        $totalHours += $hoursWorked;
                    }
                } else {
                    // Không có ca làm việc trong ngày này
                    $status = "Không có ca";
                }

                // Kiểm tra nếu ngày hiện tại là ngày trong bảng
                $isToday = ($dayStr == date("Y-m-d")); // So sánh ngày hiện tại

                // Thêm class highlight nếu là ngày hiện tại hoặc có mặt hoặc vắng mặt
                if ($status == "Có mặt") {
                    $highlightClass = "bg-green-300";  // Màu xanh lá cho có mặt
                } elseif ($status == "Vắng mặt") {
                    $highlightClass = "bg-red-300";  // Màu đỏ cho vắng mặt
                } elseif ($isToday) {
                    $highlightClass = "bg-yellow-300";  // Màu vàng cho ngày hiện tại
                } else {
                    $highlightClass = "";
                }

                // Hiển thị thông tin trong bảng
                echo "<tr class='$highlightClass'>
                    <td class='border-2 py-2'>" . $dayName . "</td>
                    <td class='border-2 py-2'>" . date("d-m-Y", strtotime($dayStr)) . "</td>
                    <td class='border-2 py-2'>" . $shiftName . "</td>
                    <td class='border-2 py-2'>" . $startTime . " - " . $endTime . "</td>
                    <td class='border-2 py-2'>" . $status . "</td>
                </tr>";

                // Chuyển sang ngày tiếp theo
                $currentDay = strtotime("+1 day", $currentDay);
            }

            // Tính lương dự kiến cho tổng giờ công trong tháng
            $salary = $totalHours * 23000;
            ?>
        </tbody>
    </table>

    <!-- Hiển thị tổng giờ công và lương -->
    <div class="mt-4">
        <p class="text-gray-700">Tổng giờ công trong tháng:
            <span class="font-semibold">
                <?php echo number_format($totalHours, 0); ?> giờ
            </span>
        </p>
        <p class="text-gray-700">Lương dự kiến trong tháng:
            <span class="font-semibold">
                <?php echo number_format($salary, 0, '', ','); ?> đồng
            </span>
        </p>
    </div>
</form>


        </div>
    </div>
</div>