<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true 
    || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mPartyPackages.php";
else $path = "./model/mPartyPackages.php";

if (!class_exists("mPartyPackages"))
    require_once($path);

class cPartyPackages extends mPartyPackages
{
    public function cGetAllPartyPackage()
    {
        if ($this->mGetAllPartyPackage() != 0) {
            $result = $this->mGetAllPartyPackage();

            return $result;
        } return 0;
    }
    
    public function cGetPartyPackageByName($name) {
        if ($this->mGetPartPackageByName($name) != 0) {
            $result = $this->mGetPartPackageByName($name);
            
            return $result;
        } return 0; 
    }
    
    public function cGetPartyPackageByID($partyPackageID) {
        if ($this->mGetPartyPackageByID($partyPackageID) != 0) {
            $result = $this->mGetPartyPackageByID($partyPackageID);
            
            return $result;
        } return 0; 
    }
    
    public function cGetDishFromPartyPacakge($partyPackageID) {
        if ($this->mGetDishFromPartyPackage($partyPackageID) != 0) {
            $result = $this->mGetDishFromPartyPackage($partyPackageID);
            
            return $result;
        } return 0; 
    }
}
