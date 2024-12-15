<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true 
    || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mCustomers.php";
else $path = "./model/mCustomers.php";

if (!class_exists("mCustomers"))
    require_once($path);

class cCustomers extends mCustomers
{
    public function cGetAllCustomer() {
        if ($this->mGetAllCustomer() != 0) {
            $result = $this->mGetAllCustomer();
            
            return $result;
        } return 0;
    }
    
    public function cInsertCustomer($phone, $name, $address, $email) {
        return $this->mInsertCustomer($phone, $name, $address, $email);
    }
}