<?php

class mCustomers
{
    public function mGetAllCustomer()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `customer`";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mInsertCustomer($phone, $name, $address, $email)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO customer(phoneNumber, fullName, address, email) VALUES ('$phone', '$name', '$address', '$email')";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
}