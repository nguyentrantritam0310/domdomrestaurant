<?php

class mOrders
{
    public function mGetAllOrder()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `order` ORDER BY orderDate DESC";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllOrderByID($orderID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `order` WHERE orderID = $orderID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetOrderPackage($orderID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *
                FROM `order` o
                JOIN `partypackage` p ON o.partyPackageID = p.partyPackageID
                WHERE o.orderID = '$orderID' and o.status != '4'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetRevenueOrderByStore($storeID, $start, $end)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *, GROUP_CONCAT(CONCAT(D.dishName, ' (x', OD.quantity, ')') SEPARATOR ', ') AS dishes FROM `order` AS O JOIN `order_dish` AS OD ON OD.orderID = O.orderID JOIN `dish` AS D ON D.dishID = OD.dishID WHERE O.orderDate >= '$start' AND O.orderDate <= '$end' AND O.storeID = $storeID GROUP BY O.orderID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllOrderRangeOf($start, $end)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT O.orderID, O.orderDate, SUM(D.price * OD.quantity) AS totalOrder, O.total FROM `order` AS O JOIN `order_dish` AS OD ON O.orderID = OD.orderID 
            JOIN `dish` AS D ON D.dishID = OD.dishID WHERE O.orderDate BETWEEN '$start' AND '$end' GROUP BY O.orderID LIMIT 10";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    /* public function mUpdateOrder($orderID, $note, $total)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `order` SET note = '$note', total = $total WHERE orderID = $orderID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    } */

    public function mUpdateOrderDish($orderID, $quantityUpdate, $notes, $total, $dishID)
    {
        $db = new Database;
        $conn = $db->connect();
        $dem = 0;
        $sumOfQuantity = 0;
        foreach ($quantityUpdate as $index => $quantity) {
            $sumOfQuantity += $quantity;
            $sql = "UPDATE `order` o
                JOIN `order_dish` od ON o.orderID = od.orderID
                SET o.total = $total, 
                    od.quantity = $quantity, 
                    o.note = '$notes',
                    o.sumOfQuantity = $sumOfQuantity
                WHERE o.orderID = $orderID AND od.dishID = $dishID[$index]";

            if ($conn->query($sql))
                $dem++;
        }
        if ($dem > 0)
            return true;
        else {
            return false;
        }
    }

    public function mUpdateStatusOrder($orderID, $status, $storeID = null)
    {
        $db = new Database;
        $conn = $db->connect();
        if ($storeID == null)
            $sql = "UPDATE `order` SET status = $status WHERE orderID = $orderID";
        else
            $sql = "UPDATE `order` SET status = $status WHERE orderID = $orderID AND storeID = $storeID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mUpdateOrderPartyPackage($orderID, $note)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `order` SET note = '$note' WHERE orderID = $orderID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mInsertOrder($phoneNumber, $total, $sumOfQuantity, $promotionID, $paymentMethod, $storeID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO `order` (phoneNumber, total, sumOfQuantity, promotionID, paymentMethod, storeID) VALUES ('$phoneNumber', $total, $sumOfQuantity, $promotionID, '$paymentMethod', $storeID)";

        return $conn->query($sql);
    }

    public function mInsertOrderPartyPackage($phoneNumber, $total, $sumOfQuantity, $promotionID, $paymentMethod, $storeID, $partyPackageID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO `order` (phoneNumber, total, sumOfQuantity, promotionID, paymentMethod, storeID, partyPackageID) VALUES ('$phoneNumber', $total, $sumOfQuantity, $promotionID, '$paymentMethod', $storeID, $partyPackageID)";

        return $conn->query($sql);
    }

    public function mInsertOrderDish($orderID, $dishID, $quantity)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO `order_dish` (orderID, dishID, quantity) VALUES ($orderID, $dishID, $quantity)";

        return $conn->query($sql);
    }

    public function mGetAllOrderFully($storeID)
    {
        $db = new Database;
        $conn = $db->connect();
            $sql = "SELECT O.*, C.fullName, CONCAT('[', GROUP_CONCAT(CONCAT('{\"name\": \"', REPLACE(D.dishName, '\"', '\\\"'), '\"', ', \"quantity\": ', OD.quantity, '}') SEPARATOR ',' ), ']') AS dishes FROM `order` AS O JOIN `customer` AS C ON O.phoneNumber = C.phoneNumber JOIN `order_dish` AS OD ON OD.orderID = O.orderID JOIN `dish` AS D ON D.dishID = OD.dishID WHERE O.storeID = $storeID GROUP BY OD.orderID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetOrderDishes($orderID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *
                FROM `order` o
                JOIN `order_dish` od ON od.orderID = o.orderID
                JOIN `dish` d ON od.dishID = d.dishID
                WHERE o.orderID = $orderID and o.status != 4";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetOrderIDNew()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT orderID FROM `order` ORDER BY orderID DESC LIMIT 1";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mDeleteOrderDish($orderID, $dishID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "DELETE FROM order_dish WHERE orderID = $orderID AND dishID = $dishID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
}