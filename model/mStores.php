<?php

class mStores
{
    public function mGetAllStore()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `store`";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetStoreByID($storeID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `store` WHERE storeID = $storeID";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateStore($storeID, $storeName, $address, $contact)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `store` SET storeName='$storeName', address='$address', contact='$contact' WHERE storeID = $storeID";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateStatusStore($storeID, $status)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE store SET status = '$status' WHERE storeID = '$storeID'";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mInsertStore($storeName, $address, $contact)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO store (storeName, address, contact) VALUES ('$storeName', '$address', '$contact')";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
}