<?php
session_start();
$ctrl = new cEmployees;
$ctrlMessage = new cMessage;

$staff = "";

// Thêm biến để theo dõi offset tuần
if (isset($_SESSION['week_offset'])) {
    $week_offset = $_SESSION['week_offset'];
} else {
    $week_offset = 0;
}

// Cập nhật offset nếu có POST request
if (isset($_POST['week_change'])) {
    $week_offset += (int)$_POST['week_change'];
    $_SESSION['week_offset'] = $week_offset;
}

// Tính toán $startW dựa trên offset
$startW = date('Y-m-d', strtotime("monday this week $week_offset weeks"));
$endW = date('Y-m-d', strtotime("sunday this week $week_offset weeks"));

if (isset($_POST["staff"])) {
    $_SESSION["selected_staff"] = $_POST["staff"];
    $staff = $_POST["staff"];
} else {
    $staff = isset($_SESSION["selected_staff"]) ? $_SESSION["selected_staff"] : '';
}

if (isset($_POST["btnxoa"])) {
    $arrE = explode("/", $_POST["btnxoa"]);
    $shiftID = $arrE[0];
    $userID = $arrE[1];
    $date = $arrE[2];
    
    if ($ctrl->cDeleteEmployeeShift($shiftID, $userID, $date)) {
        $ctrlMessage->successMessage("Xóa ca làm nhân viên");

    }
}

if (isset($_POST["btnthemnv"])) {
    $userID = (int)$_POST["user"];
    $shifts = $_POST["shift"];
    $hasError = false;
    $date = $_POST["btnthemnv"];

    if (empty($shifts)) {
        $ctrlMessage->errorMessage("Vui lòng chọn ca làm!");
        $hasError = true;
    }

    // Chỉ thêm nếu không có lỗi
    if (!$hasError) {
        $success = true;
        foreach ($shifts as $shiftID) {
            // Kiểm tra xem ca làm đã tồn tại chưa
            $checkSql = "SELECT COUNT(*) as count FROM employee_shift 
                        WHERE shiftID = $shiftID 
                        AND userID = $userID 
                        AND date = '$date'";
            $checkResult = $conn->query($checkSql);
            $row = $checkResult->fetch_assoc();
            
            if ($row['count'] > 0) {
                $ctrlMessage->errorMessage("Ca làm này đã được phân công cho nhân viên!");
                $success = false;
                break;
            }

            // Nếu chưa tồn tại thì thêm mới
            if (!$ctrl->cInsertEmployeeShift($shiftID, $userID, $date)) {
                $success = false;
                break;
            }
        }
        
        if ($success) {
            $ctrlMessage->successMessage("Thêm ca làm thành công!");
        } else {
            $ctrlMessage->errorMessage("Có lỗi xảy ra khi thêm ca làm!");
        }
    }
}
?>

<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Bảng phân ca</h2>
            <div class="flex items-center gap-4">
                <button onclick="changeWeek(-1)" class="btn bg-gray-100 px-4 py-2 rounded-lg">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <span id="weekDisplay" class="text-sm text-gray-600"></span>
                <button onclick="changeWeek(1)" class="btn bg-gray-100 px-4 py-2 rounded-lg">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            <form action="" method="POST" class="my-auto" id="staffForm">
                <select name="staff" id="" class="form-control w-fit" onchange="document.getElementById('staffForm').submit()">
                    <option value="" >Tất cả nhân viên</option>
                    <option value="3" <?php echo $staff == 3 ? "selected" : ""; ?>>Nhân viên nhận đơn</option>
                    <option value="4" <?php echo $staff == 4 ? "selected" : ""; ?>>Nhân viên bếp</option>
                </select>
            </form>
            <div class="flex items-center">
                <button class="btn bg-green-100 text-green-500 py-2 px-4 rounded-lg mr-1 hover:bg-green-500 hover:text-white">Xuất <i class="fa-solid fa-table"></i></button>
                <button class="btn bg-blue-100 text-blue-500 py-2 px-4 rounded-lg ml-1 hover:bg-blue-500 hover:text-white">In <i class="fa-solid fa-print"></i></button>
            </div>
        </div>

        <div class="h-fit bg-blue-100 rounded-lg p-4">
            <div id="calendar"></div>

            <?php

            $managerStoreID = $_SESSION["user"][1]; 

            if ($staff != "") {
                $sql = "SELECT * FROM `employee_shift` AS ES 
                        JOIN `user` AS U ON ES.userID = U.userID 
                        JOIN `shift` AS S ON S.shiftID = ES.shiftID 
                        WHERE U.roleID = $staff 
                        AND U.storeID = $managerStoreID 
                        AND ES.date BETWEEN '$startW' AND '$endW'";
            } else {
                $sql = "SELECT * FROM `employee_shift` AS ES 
                        JOIN `user` AS U ON ES.userID = U.userID 
                        JOIN `shift` AS S ON S.shiftID = ES.shiftID 
                        WHERE U.storeID = $managerStoreID 
                        AND ES.date BETWEEN '$startW' AND '$endW'";
            }

            $result = $conn->query($sql);
            $workShifts = [];

            while ($row = $result->fetch_assoc()) {
                $workShifts[$row["date"]][] = [
                    "shiftID" => $row["shiftID"],
                    "userID" => $row["userID"],
                    "name" => $row["userName"],
                    "shiftName" => $row["shiftName"],
                    "date" => $row["date"]
                ];
            }

            $jsonWorkShifts = json_encode($workShifts);
            ?>
            <div class="modal modalInsert fade" id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="" class="w-full" method="POST">
                            <div class="modal-header">
                                <h2 class="modal-title fs-5 font-bold text-3xl" id="insertModalLabel" style="color: #E67E22;">Thêm ca làm</h2>
                            </div>
                            <div class="modal-body">
                                <div id="employeeList" class="flex items-center">
                                    <strong class="w-1/3">Chọn nhân viên:</strong>
                                    <?php
                                    if ($staff != "") {
                                        $sql = "SELECT * FROM `user` 
                                                WHERE roleID = $staff 
                                                AND storeID = $managerStoreID";
                                    } else {
                                        $sql = "SELECT * FROM `user` 
                                                WHERE roleID IN (3, 4) 
                                                AND storeID = $managerStoreID";
                                    }
                                    $result = $conn->query($sql);

                                    echo '<select name="user" id="" class="w-2/3 form-control">';
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row["userID"] . '">' . $row["userName"] . '</option>';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                                <div id="shiftOptions" class="mt-4">
                                    <strong>Chọn ca làm:</strong>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="shiftMo" name="shift[]" value="1">
                                        <label for="shiftMo" class="form-check-label">Ca sáng (07:00 - 12:00)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="shiftAf" name="shift[]" value="2">
                                        <label for="shiftAf" class="form-check-label">Ca chiều (12:00 - 17:00)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="shiftEv" name="shift[]" value="3">
                                        <label for="shiftEv" class="form-check-label">Ca tối (17:00 - 22:00)</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-primary" name="btnthemnv" id="btnthem">Thêm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const workShifts = <?php echo $jsonWorkShifts; ?>;
        let currentWeekOffset = 0;

        function changeWeek(offset) {
            // Tạo form ẩn và submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.style.display = 'none';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'week_change';
            input.value = offset;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        function updateCalendar() {
            const calendar = document.getElementById("calendar");
            calendar.innerHTML = ''; // Xóa calendar hiện tại

            const startW = new Date("<?php echo $startW; ?>");
            startW.setDate(startW.getDate() + (currentWeekOffset * 7));
            
            const endW = new Date(startW);
            endW.setDate(startW.getDate() + 6);

            // Hiển thị thông tin tuần
            const weekDisplay = document.getElementById("weekDisplay");
            weekDisplay.textContent = `${startW.toLocaleDateString('vi-VN')} - ${endW.toLocaleDateString('vi-VN')}`;

            for (let day = new Date(startW); day <= endW; day.setDate(day.getDate() + 1)) {
                const dateString = day.toISOString().split('T')[0];
                const dayNumber = day.getDate();

                const dayDiv = document.createElement("div");
                dayDiv.classList.add("day", "bg-white", "p-3", "rounded-lg", "shadow-md", "mb-2", "text-sm", "h-100");
                
                // Thêm header cố định cho ngày
                const headerDiv = document.createElement("div");
                headerDiv.classList.add("sticky", "top-0", "bg-white", "mb-2", "z-10");
                headerDiv.innerHTML = `<h3 class='bg-orange-400 p-2 w-8 rounded-full text-center text-white font-bold'>${dayNumber}</h3>`;
                dayDiv.appendChild(headerDiv);

                // Tạo container có thể scroll cho nội dung
                const contentDiv = document.createElement("div");
                contentDiv.classList.add("overflow-y-auto", "h-48"); 

                const detailsDiv = document.createElement("div");

                if (workShifts[dateString]) {
                    workShifts[dateString].forEach(shift => {
                        const shiftInfo = document.createElement("div");
                        shiftInfo.classList.add("flex", "items-center", "mb-2");
                        shiftInfo.innerHTML = `<form method='POST' class='m-0 w-full'>
                            <button type='submit' name='btnxoa' 
                                value='${shift.shiftID}/${shift.userID}/${shift.date}' 
                                onclick="return confirm('Bạn có chắc chắn muốn xóa ca làm của nhân viên ${shift.name} (${shift.shiftName}) vào ngày ${shift.date}?')"
                                class='bg-gray-300 p-1 text-center mr-2 rounded-full'>
                                <i class="fa-solid fa-minus"></i>
                            </button>
                            <span>${shift.name} (${shift.shiftName})</span>
                        </form>`;
                        detailsDiv.appendChild(shiftInfo);
                    });
                }

                const addEmployeeDiv = document.createElement("div");
                addEmployeeDiv.classList.add("flex", "items-center", "mb-2");
                addEmployeeDiv.innerHTML = `
                    <button class='bg-gray-300 p-1 text-center mr-2 rounded-full' value='${dateString}'  onclick='openModal(this)' data-bs-toggle="modal" data-bs-target="#insertModal">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                    <span class='text-gray-600'>Thêm ca làm</span>
                `;
                detailsDiv.appendChild(addEmployeeDiv);

                contentDiv.appendChild(detailsDiv);
                dayDiv.appendChild(contentDiv);
                calendar.appendChild(dayDiv);
            }
        }

        function openModal(button) {
            document.getElementById("btnthem").value = button.value;
        }

        updateCalendar();

    </script>