<?php

session_start();

$sql = "SELECT * FROM `shift`";
$result = $conn->query($sql);
$workShifts = [];
while ($row = $result->fetch_assoc()) {
    $workShifts[] = $row;
}

$userID = $_SESSION['user'][0];
$query = "SELECT es.date, s.shiftName 
          FROM employee_shift es 
          JOIN shift s ON es.shiftID = s.shiftID 
          WHERE es.userID = $userID";
$result = $conn->query($query);
$caDK = [];

while ($row = $result->fetch_assoc()) {
    $caDK[$row['date']][] = $row['shiftName'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['shift']) && !empty($_POST['shift'])) {
        $selectedShifts = $_POST['shift'];
        $totalShifts = 0;

        foreach ($selectedShifts as $date => $shifts) {
            $totalShifts += count($shifts);
        }

        if ($totalShifts >= 4) {
            $deleteQuery = "DELETE FROM `employee_shift` WHERE userID = $userID";
            $conn->query($deleteQuery);

            foreach ($selectedShifts as $date => $shifts) {
                foreach ($shifts as $shiftName) {
                    $query = "SELECT shiftID FROM shift WHERE shiftName = '$shiftName'";
                    $result = $conn->query($query);

                    if ($result && $row = $result->fetch_assoc()) {
                        $shiftID = $row['shiftID'];

                        $dateForDatabase = DateTime::createFromFormat('d-m-Y', $date)->format('Y-m-d');
                        $insertQuery = "INSERT INTO employee_shift (userID, shiftID, date) VALUES ($userID, $shiftID, '$dateForDatabase')";
                        $conn->query($insertQuery);
                    } else {
                        echo "<script>alert('Ca làm không tồn tại: $shiftName');</script>";
                    }
                }
            }
            echo "<script>alert('Đăng ký ca làm thành công!');</script>";

            $query = "SELECT es.date, s.shiftName 
                      FROM `employee_shift` AS es 
                      JOIN `shift` AS s ON es.shiftID = s.shiftID 
                      WHERE es.userID = $userID";
            $result = $conn->query($query);
            $caDK = [];

            while ($row = $result->fetch_assoc()) {
                $caDK[$row['date']][] = $row['shiftName'];
            }
        } else {
            echo "<script>alert('Vui lòng chọn ít nhất 4 ca làm!');</script>";
        }
    } else {
        echo "<script>alert('Chưa chọn ca làm nào!');</script>";
    }
}
?>

<div class="grid grid-cols-1 md:grid-cols-1 gap-6 mt-8">
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <div class="flex justify-center items-center mb-4">
            <h2 class="text-xl font-semibold">Đăng ký ca làm việc</h2>
        </div>
        <div class="h-fit bg-blue-100 rounded-lg p-4">
            <form method="POST" action="">
                <div id="calendar">
                    <?php
                    $currentDate = new DateTime();
                    $startW = clone $currentDate;
                    $startW->modify('next Monday');
                    $endW = clone $startW;
                    $endW->modify('+6 days');

                    $days = [];
                    for ($i = 0; $i < 7; $i++) {
                        $day = clone $startW;
                        $day->modify("+$i days");
                        $days[] = $day;
                    }

                    foreach ($days as $day) {
                        $dateString = $day->format('d-m-Y');
                        echo "<div class='day p-2 border rounded-md mb-2'>";
                        echo "<strong>{$day->format('l')}</strong><br>";
                        echo "{$day->format('d-m-Y')}<br>";

                        foreach ($workShifts as $shift) {
                            $isChecked = isset($caDK[$dateString]) && in_array($shift['shiftName'], $caDK[$dateString]) ? 'checked' : '';
                            echo "<div class='my-2'><label>";
                            echo "<input type='checkbox' name='shift[{$dateString}][]' value='{$shift['shiftName']}' $isChecked> {$shift['shiftName']}";
                            echo "</label><br> </div>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>

                <div id="registerButtonDiv" class="mt-4">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg" name="submitShifts">Đăng
                        ký</button>
                </div>
            </form>
        </div>

        <!-- Hiển thị lịch đã đăng ký nếu có -->
        <?php
        if (!empty($caDK)) {
            echo "<h3 class='mt-6 text-lg font-semibold'>Lịch bạn đã đăng ký:</h3>";
            echo "<div class='mt-4 bg-white p-4 rounded-lg shadow-lg'>";
            echo "<div class='grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4'>";

            foreach ($caDK as $date => $shifts) {
                $dateFormatted = date('d-m-Y', strtotime($date));

                echo "<div class='day p-4 bg-blue-100 border rounded-md'>";
                echo "<strong>{$dateFormatted}</strong><br>";
                echo "<div class='mt-2'>" . implode(", ", $shifts) . "</div>";
                echo "</div>";
            }
            echo "</div>";
            echo "</div>";
        }
        ?>
    </div>
</div>