<?php

class mUsers
{
    public function mGetAllUser()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `user` AS U JOIN `role` AS R ON U.roleID = R.roleID WHERE U.roleID != 1";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetUserByID($userID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM user WHERE userID = $userID";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateUser($userID, $userName, $dateBirth, $phoneNumber, $email, $sex, $roleID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `user` SET userName = '$userName', dateBirth = '$dateBirth', phoneNumber = '$phoneNumber', email = '$email', sex = '$sex', roleID = $roleID WHERE userID = $userID";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateStatusUser($userID, $status)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `user` SET status = '$status' WHERE userID = '$userID'";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
    
    public function mInsertUser($userName, $dateBirth, $phoneNumber, $email, $sex, $roleID, $pass, $img, $storeID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO user (userName, dateBirth, phoneNumber, email, sex, roleID, password, image, storeID) 
            VALUES ('$userName', '$dateBirth', '$phoneNumber', '$email', '$sex', '$roleID', '$pass', '$img', $storeID)";
        if ($conn != null) 
            return $conn->query($sql);
        return 0;
    }
}