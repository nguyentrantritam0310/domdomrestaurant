<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true 
    || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mUsers.php";
else
    $path = "./model/mUsers.php";

if (!class_exists("mUsers"))
    require_once($path);

class cUsers extends mUsers
{
    public function cGetAllUser()
    {
        if ($this->mGetAllUser() != 0)
            return $this->mGetAllUser();
        else
            return 0;
    }

    public function cGetUserByID($userID)
    {
        if ($this->mGetUserByID($userID) != 0)
            return $this->mGetUserByID($userID);
        else
            return 0;
    }

    public function cUpdateUser($userID, $userName, $dateBirth, $phoneNumber, $email, $sex, $roleID)
    {
        if ($this->mUpdateUser($userID, $userName, $dateBirth, $phoneNumber, $email, $sex, $roleID) != 0)
            return $this->mUpdateUser($userID, $userName, $dateBirth, $phoneNumber, $email, $sex, $roleID);
        else
            return 0;

    }

    public function cUpdateStatusUser($userID, $status)
    {
        if ($this->mUpdateStatusUser($userID, $status) != 0)
            return $this->mUpdateStatusUser($userID, $status);
        else
            return 0;

    }
    
    public function cInsertUser($userName, $dateBirth, $phoneNumber, $email, $sex, $roleID, $pass, $img, $storeID)
    {
        return $this->mInsertUser($userName, $dateBirth, $phoneNumber, $email, $sex, $roleID, $pass, $img, $storeID);

    }
}
