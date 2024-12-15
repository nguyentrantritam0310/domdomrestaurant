<?php

class mPartyPackages
{
    public function mGetAllPartyPackage()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *, PP.image, GROUP_CONCAT(CONCAT(D.dishName) SEPARATOR ', ') AS Name FROM `partypackage` AS PP JOIN `partypackage_dish` AS PPD ON PP.partyPackageID = PPD.partyPackageID JOIN `dish` AS D ON D.dishID = PPD.dishID GROUP BY PPD.partyPackageID";
        
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetPartPackageByName($name) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `partypackage` WHERE partyPackageName LIKE '%".$name."%'";
        
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetPartyPackageByID($partyPackageID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *, COUNT(PPD.quantity) AS sumQuantity FROM `partypackage` AS PP JOIN `partypackage_dish` AS PPD ON PP.partyPackageID = PPD.partyPackageID WHERE PP.partyPackageID = $partyPackageID GROUP BY PPD.partyPackageID";
        
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetDishFromPartyPackage($partyPackageID) {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `partypackage` AS PP JOIN `partypackage_dish` AS PPD ON PP.partyPackageID = PPD.partyPackageID WHERE PPD.partyPackageID = $partyPackageID";
        
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
}