<?php

class mEmployees
{
    public function mGetAllEmployee()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `user` AS U JOIN `role` AS R ON U.roleID = R.roleID WHERE U.roleID != 1";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllEmployeeForRevenue()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *, COUNT(U.roleID) AS quantityEmployee, SUM(TIMESTAMPDIFF(HOUR, S.startTime, S.endTime)) AS totalHours FROM `user` AS U JOIN `role` AS R ON U.roleID = R.roleID
            JOIN `employee_shift` AS ES ON ES.userID = U.userID JOIN `shift` AS S ON S.shiftID = ES.shiftID WHERE U.roleID IN (3, 4)";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetEmployeeIDByName($name)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT userID FROM `user` WHERE userName = '$name'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetEmployeeByID($id)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `user` WHERE userID = $id";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetManagerByStoreID($storeID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM user WHERE storeID = $storeID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetEmployeeByStoreID($storeID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `user` AS U JOIN `role` AS R ON U.roleID = R.roleID WHERE U.roleID IN (3, 4) AND U.storeID = $storeID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetEmployeeAttendance($storeID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *, ES.status FROM `user` AS U JOIN `role` AS R ON U.roleID = R.roleID JOIN `employee_shift` AS ES ON ES.userID = U.userID JOIN `shift` AS SH ON SH.shiftID = ES.shiftID JOIN `store` AS S ON U.storeID = S.storeID WHERE U.roleID IN (3, 4) AND U.storeID = $storeID AND DATE(ES.date) = CURDATE()";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mDeleteEmployeeShift($shiftID, $userID, $date)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "DELETE FROM `employee_shift` WHERE shiftID = $shiftID AND userID = $userID AND date = '$date'";

        return $conn->query($sql);
    }

    public function mInsertEmployeeShift($shiftID, $userID, $date)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO `employee_shift` (shiftID, userID, date) VALUES ($shiftID, $userID, '$date') ";

        return $conn->query($sql);
    }

    public function mGetEmployeeShiftInfo($userID, $start, $end)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `employee_shift` AS ES JOIN `user` AS U ON ES.userID = U.userID JOIN `shift` AS S ON ES.shiftID = S.shiftID WHERE U.userID = $userID AND ES.date >= '$start' AND ES.date <= '$end' ORDER BY ES.date, S.startTime";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllShift()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `shift`";

        return $conn->query($sql);
    }

    public function mGetShiftIDByName($shiftName)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT shiftID FROM `shift` WHERE shiftName = '$shiftName'";

        return $conn->query($sql);
    }

    public function mGetRevenueEmployeeShiftByStore($storeID, $startM, $endM)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT 
                    u.*,
                    r.*,
                    COUNT(DISTINCT u.userID) AS totalEmployees,
                    SUM(TIMESTAMPDIFF(HOUR, s.startTime, s.endTime)) AS totalHours,
                    CASE 
                        WHEN u.roleID = 3 THEN SUM(TIMESTAMPDIFF(HOUR, s.startTime, s.endTime)) * 25000
                        WHEN u.roleID = 4 THEN SUM(TIMESTAMPDIFF(HOUR, s.startTime, s.endTime)) * 35000
                        ELSE 0
                    END AS totalSalary
                FROM `employee_shift` es
                JOIN User u ON es.userID = u.userID
                JOIN Shift s ON es.shiftID = s.shiftID
                JOIN Role r ON u.roleID = r.roleID
                WHERE u.roleID IN (3, 4) 
                AND u.storeID = $storeID
                AND es.date BETWEEN '$startM' AND '$endM'
                GROUP BY u.roleID, r.roleName";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
}