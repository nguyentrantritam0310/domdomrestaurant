<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true 
    || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mStores.php";
else $path = "./model/mStores.php";

if (!class_exists("mStores"))
    require_once($path);

class cStores extends mStores
{
    public function cGetAllStore()
    {
        if ($this->mGetAllStore() != 0) {
            $result = $this->mGetAllStore();

            return $result;
        }
        return 0;
    }
    
    public function cGetStoreByID($storeID)
    {
        if ($this->mGetStoreByID($storeID) != 0) {
            $result = $this->mGetStoreByID($storeID);

            return $result;
        }
        return 0;
    }
    
    public function cUpdateStore($storeID, $storeName, $address, $contact)
    {
        return $this->mUpdateStore($storeID, $storeName, $address, $contact);
    }
    
    public function cUpdateStatusStore($storeID, $status)
    {
        return $this->mUpdateStatusStore($storeID, $status);
    }
    
    public function cInsertStore($storeName, $address, $contact)
    {
        return $this->mInsertStore($storeName, $address, $contact);

    }
}
