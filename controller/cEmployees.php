<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true 
    || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mEmployees.php";
else $path = "./model/mEmployees.php";

if (!class_exists("mEmployees"))
    require_once($path);
    
class cEmployees extends mEmployees
{
    public function cGetAllEmployee()
    {
        if ($this->mGetAllEmployee() != 0) {
            $result = $this->mGetAllEmployee(); 
            return $result;
        }
        return 0;
    }
    
    public function cGetAllEmployeeForRevenue()
    {
        if ($this->mGetAllEmployeeForRevenue() != 0) {
            $result = $this->mGetAllEmployeeForRevenue(); 
            return $result;
        }
        return 0;
    }
    
    public function cGetEmployeeIDByName($name)
    {
        if ($this->mGetEmployeeIDByName($name) != 0) {
            $result = $this->mGetEmployeeIDByName($name); 
            return $result;
        }
        return 0;
    }
    
    public function cGetEmployeeByID($id)
    {
        if ($this->mGetEmployeeByID($id) != 0) {
            $result = $this->mGetEmployeeByID($id); 
            return $result;
        }
        return 0;
    }
    
    public function cGetManagerByStoreID($storeID)
    {
        if ($this->mGetManagerByStoreID($storeID) != 0) {
            $result = $this->mGetManagerByStoreID($storeID); 
            return $result;
        }
        return 0;
    }
    
    public function cGetEmployeeByStoreID($storeID)
    {
        if ($this->mGetEmployeeByStoreID($storeID) != 0) {
            $result = $this->mGetEmployeeByStoreID($storeID); 
            return $result;
        }
        return 0;
    }
    
    public function cGetEmployeeAttendance($storeID) {
        if ($this->mGetEmployeeAttendance($storeID) != 0) {
            $result = $this->mGetEmployeeAttendance($storeID); 
            return $result;
        }
        return 0;
    }
    
    public function cInsertEmployeeShift($shiftID, $userID, $date) {
        return $this->mInsertEmployeeShift($shiftID, $userID, $date); 
    }
    
    public function cGetEmployeeShiftInfo($userID, $start, $end) {
        if ($this->mGetEmployeeShiftInfo($userID, $start, $end) != 0) {
            $result = $this->mGetEmployeeShiftInfo($userID, $start, $end); 
            return $result;
        }
        return 0;
    }
    
    public function cGetAllShift() {
        if ($this->mGetAllShift() != 0) {
            $result = $this->mGetAllShift(); 
            return $result;
        }
        return 0;
    }
    
    public function cGetShiftIDByName($shiftName) {
        if ($this->mGetShiftIDByName($shiftName) != 0) {
            $result = $this->mGetShiftIDByName($shiftName); 
            return $result;
        }
        return 0;
    }
    
    public function cGetRevenueEmployeeShiftByStore($storeID, $startM, $endM) {
        if ($this->mGetRevenueEmployeeShiftByStore($storeID, $startM, $endM) != 0) {
            $result = $this->mGetRevenueEmployeeShiftByStore($storeID, $startM, $endM); 
            return $result;
        }
        return 0;
    }
    
    public function cDeleteEmployeeShift($shiftID, $userID, $date) {
        return $this->mDeleteEmployeeShift($shiftID, $userID, $date); 
    }
}