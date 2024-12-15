<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-4">

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="bg-blue-100 text-blue-500 p-3 rounded-full mr-4">
                <i class="fas fa-eye">
                </i>
            </div>
            <div>
                <p class="text-gray-600 mb-2">Khách hàng</p>
                <p class="text-xl font-semibold">
                    <?php
                    $sql = "SELECT * FROM `customer` AS C JOIN `order` AS O ON C.phoneNumber = O.phoneNumber WHERE O.orderDate >= '$startM' AND O.orderDate <= '$endM' GROUP BY O.phoneNumber";
                    $result = $conn->query($sql);
                    $count = $result->num_rows;

                    echo $count;
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="bg-green-100 text-green-500 p-3 rounded-full mr-4">
                <i class="fas fa-dollar-sign">
                </i>
            </div>
            <div>
                <p class="text-gray-600 mb-2">Doanh thu tháng</p>
                <p class="text-xl font-semibold">
                    <?php
                    $sql = "SELECT * FROM `order` WHERE orderDate >= '$startM' AND orderDate <= '$endM'";
                    $result = $conn->query($sql);
                    $revenue = 0;

                    while ($row = $result->fetch_assoc()) {
                        $revenue += $row["total"];
                    }
                    echo str_replace(".00", "", number_format($revenue, "2", ".", ",")) . " đ";
                    ?>
                </p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="bg-purple-100 text-purple-500 p-3 rounded-full mr-4">
                <i class="fas fa-shopping-cart">
                </i>
            </div>
            <div>
                <p class="text-gray-600 mb-2">Đơn trong tháng</p>
                <p class="text-xl font-semibold">
                    <?php
                    $sql = "SELECT * FROM `order` WHERE orderDate >= '$startM' AND orderDate <= '$endM'";
                    $result = $conn->query($sql);
                    $count = $result->num_rows;

                    echo $count;
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-lg mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">
            Thống kê doanh thu trong tháng
        </h2>
        <div class="currentMonth">
            <form action="" method="post" class="revenueMonth flex items-center my-auto">
                <input type="date" name="startM" id="startM"
                    class="bg-gray-100 border-solid border-2 rounded-lg py-1 px-3" value="<?php echo $startM; ?>"> <span
                    class="mx-2">đến</span>
                <input type="date" name="endM" id="endM"
                    class="bg-gray-100 border-solid border-2 rounded-lg py-1 px-3 mr-1" value="<?php echo $endM; ?>">
                <button type="submit" name="btnxem" class="btn btn-primary ml-1 py-2 px-4 rounded-lg">Xem</button>
            </form>
        </div>
        <div class="flex items-center">
            <button
                class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất
                <i class="fa-solid fa-table"></i></button>
            <button
                class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In <i
                    class="fa-solid fa-print"></i></button>
        </div>
    </div>
    <div class="h-fit bg-gray-100 rounded-lg p-6">
        <canvas id="revenueChart" class="w-full" height="350"></canvas>
        <?php
        $sql = "SELECT DAY(orderDate) AS dates, SUM(total) AS totalOrder FROM `order` WHERE orderDate >= '$startM' AND orderDate <= '$endM' GROUP BY orderDate";
        $result = $conn->query($sql);
        $revenue = 0;
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = [$row["dates"], (float) $row["totalOrder"]];
            $revenue += $row["totalOrder"];
        }

        $jsonData = json_encode($data);
        ?>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow-lg mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Lịch trong tuần</h2>
        <div class="currentWeek">
            <div class="week bg-gray-100 border-solid border-2 px-3 py-1 rounded-lg">
                <?php
                echo date('d-m-Y', strtotime('monday this week')) . " đến " . date('d-m-Y', strtotime('sunday this week'));
                ?>
            </div>
        </div>
        <div class="flex items-center">
            <button
                class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất
                <i class="fa-solid fa-table"></i></button>
            <button
                class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In <i
                    class="fa-solid fa-print"></i></button>
        </div>
    </div>
    <div class="h-fit bg-blue-100 rounded-lg p-4">
        <div id="calendar"></div>

        <div id="info" class="hidden">
            <h2 class="font-bold text-xl py-1">Thông tin ca làm</h2>
            <div id="details"></div>
        </div>

        <?php
        $sql = "SELECT * FROM `employee_shift` AS ES JOIN `user` AS U ON ES.userID = U.userID JOIN `shift` AS S ON S.shiftID = ES.shiftID";
        $result = $conn->query($sql);
        $workShifts = [];

        while ($row = $result->fetch_assoc()) {
            $workShifts[$row["date"]][] = [
                "employee" => $row["userName"],
                "time" => $row["shiftName"]
            ];
        }

        $jsonWorkShifts = json_encode($workShifts);
        ?>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Khách hàng trong tuần</h2>
        <ul>
            <?php
            $sql = "SELECT * FROM `customer` AS C JOIN `order` AS O ON O.phoneNumber = C.phoneNumber WHERE O.orderDate >= '$startW' AND O.orderDate <= '$endW' GROUP BY C.phoneNumber ORDER BY O.orderDate DESC";
            $result = $conn->query($sql);

            if ($result->num_rows != 0) {
                while ($row = $result->fetch_assoc()) {
                    $avt = substr($row["fullName"], 0, 1);
                    echo "
                            <li class='flex items-center py-2'>
                                <div class='bg-blue-500 text-white rounded-full w-10 h-10 flex items-center justify-center mr-4'>" . $avt . "</div>
                                <div>
                                    <p class='text-gray-600'>" . $row["fullName"] . "</p>
                                    <p class='text-sm text-gray-400'>" . $row["email"] . "</p>
                                </div>
                                <div class='ml-auto'>
                                    <button class='bg-blue-100 text-blue-500 py-1 px-2 rounded-lg mr-2'>
                                        <i class='fas fa-envelope'></i>
                                    </button>
                                </div>
                            </li>";
                }
            } else {
                echo "<p class='text-center py-2 font-semibold'>Chưa có dữ liệu!</p>";
            }
            ?>
        </ul>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-lg font-semibold mb-4">Đơn hàng trong tuần</h2>

        <?php
        $ctrl = new cOrders;
        $result = $ctrl->cGetAllOrderRangeOf($startW, $endW);

        if ($result->num_rows != 0) {
            echo "
                <table class='w-full text-sm text-center'>
                <thead>
                    <tr>
                        <th class='text-gray-600 py-2 border-2'>
                            Mã đơn
                        </th>
                        <th class='text-gray-600 py-2 border-2'>
                            Ngày đặt
                        </th>
                        <th class='text-gray-600 py-2 border-2'>
                            Giá trị đơn
                        </th>
                        <th class='text-gray-600 py-2 border-2'>
                            Giảm giá
                        </th>
                        <th class='text-gray-600 py-2 border-2'>
                            Trạng thái
                        </th>
                    </tr>
                </thead>
                <tbody>";
                
            while ($row = $result->fetch_assoc()) {
                switch ($row["status"]) {
                    case 0:
                        $status = "Chờ nhận đơn";
                        break;
                    case 1:
                        $status = "Đang chế biến";
                        break;
                    case 2:
                        $status = "Chế biến xong";
                        break;
                    case 3:
                        $status = "Hoàn thành";
                        break;
                    case 4:
                        $status = "Đã hủy";
                        break;
                }

                echo "
                        <tr>
                            <td class='py-2 border-2'>
                                #" . ($row['orderID'] < 10 ? "0" . $row['orderID'] : $row['orderID']) . "
                            </td>
                            <td class='py-2 border-2'>
                                " . $row['orderDate'] . "
                            </td>
                            <td class='py-2 border-2'>
                                " . ($row["total"] > $row["totalOrder"] ? "<del>" . number_format($row["total"], 0, ",", ".") . "đ</del>" : number_format($row["total"], 0, ",", ".") . "  đ") . " 
                            </td>
                            <td class='py-2 border-2'>
                                " . number_format($row["totalOrder"], 0, ",", ".") . " đ
                            </td>
                            <td class='py-2 border-2'>
                                <span class='bg-" . ($row["status"] != 4 ? 'green' : 'blue') . "-100 text-" . ($row["status"] != 4 ? 'green' : 'blue') . "-500 py-1 px-2 rounded-lg'>
                                    " . $status . "
                                </span>
                            </td>
                        </tr>
                    ";
            }
            echo "</tbody>
                        </table>";
        } else {
            echo "<p class='text-center py-2 font-semibold'>Chưa có dữ liệu!</p>";
        }
        ?>
    </div>

    <script>
        /* Draw chart revenue month */
        const revenueData = <?php echo $jsonData; ?>;
        const labels = revenueData.map(item => item[0]);
        const data = revenueData.map(item => item[1]);

        const dataChart = {
            labels: labels,
            datasets: [{
                label: "Doanh thu tháng",
                data: data,
                borderColor: "rgba(75, 192, 192, 1)",
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderWidth: 1
            }]
        };

        const config = {
            type: "line",
            data: dataChart,
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Ngày"
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: "VND"
                        },
                        beginAtZero: true
                    }
                }
            }
        };

        const revenueChart = new Chart(
            document.getElementById("revenueChart"),
            config
        );

        /* Workshifts */
        const workShifts = <?php echo $jsonWorkShifts; ?>;

        function createCalendar() {
            const calendar = document.getElementById("calendar");

            const startW = new Date("<?php echo $startW; ?>");
            const endW = new Date("<?php echo $endW; ?>");

            for (let day = new Date(startW); day <= endW; day.setDate(day.getDate() + 1)) {
                const dateString = day.toISOString().split('T')[0];

                const dayDiv = document.createElement("div");
                dayDiv.classList.add("day");
                dayDiv.textContent = day.getDate();

                if (workShifts[dateString]) {
                    const dot = document.createElement("div");
                    dot.classList.add("dot");
                    dot.style.display = "block";
                    dayDiv.appendChild(dot);

                    dayDiv.onclick = () => showInfoShift(dateString);
                }

                calendar.appendChild(dayDiv);
            }
        }

        function showInfoShift(date) {
            const infoDiv = document.getElementById("info");
            const detailsDiv = document.getElementById("details");
            const shifts = workShifts[date];

            detailsDiv.innerHTML = `<p><strong>Ngày:</strong> ${date}</p>`;

            if (shifts) {
                shifts.forEach(shift => {
                    detailsDiv.innerHTML += `<p>${shift.employee} (${shift.time})</p>`;
                });
            } else {
                detailsDiv.innerHTML += `<p>Không có thông tin ca làm cho ngày này.</p>`;
            }

            infoDiv.classList.remove("hidden");
        }

        createCalendar();
    </script>