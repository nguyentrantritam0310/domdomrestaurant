<?php

class mImportOrder
{
    public function mGetAllImportOrder()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM importorder";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mInsertImportOrder($userID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO importorder (importOrderDate, userID) VALUES (NOW(), '$userID')";
        $importOrderID = $conn->insert_id;
        $autoincrement = "ALTER TABLE importorder AUTO_INCREMENT =  $importOrderID";
        $conn->query($autoincrement);

        if ($conn){
            if ($conn->query($sql)) {
                    return $conn->insert_id;
            }else {
                return -1;
            }
        } else {
            return -1;;
        }
    }

    public function mInsertNeedIngredient($importOrderId, $ingredients, $quantities)
    {
        $db = new Database;
        $conn = $db->connect();
        $demso = 0;
        // Lặp qua các nguyên liệu và chèn vào bảng dish_ingredient
        foreach ($ingredients as $index => $ingredientId) {
            $quantity = $quantities[$index];
            $sql = "INSERT INTO needingredient (importOrderID, ingredientID, quantity) VALUES ($importOrderId, '$ingredientId', $quantity)";
                $conn->query($sql);
                $demso+=1;
                $demso++;
    }
    if($demso > 0) {
        return true;
    }else {
        return false;
    }
    }

    public function checkAndDeleteInvalidImportOrder()
    {
        $db = new Database;
        $conn = $db->connect();
        // Truy vấn để tìm các importOrderID có trong bảng importorder nhưng không có trong bảng needingredient
        $sql = "SELECT io.importOrderID
                FROM importorder io
                LEFT JOIN needingredient ni ON io.importOrderID = ni.importOrderID
                WHERE ni.importOrderID IS NULL";
    
        // Thực thi truy vấn
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // Nếu có importOrderID không có trong needingredient, xóa chúng khỏi bảng importorder
            while ($row = $result->fetch_assoc()) {
                $importOrderIdToDelete = $row['importOrderID'];
    
                // Xóa các importOrderId không có trong needingredient
                $deleteSql = "DELETE FROM importorder WHERE importOrderID = $importOrderIdToDelete";
                if (!$conn->query($deleteSql)) {
                    throw new Exception("Không thể xóa importOrderID: " . $importOrderIdToDelete);
                }
            }
        }
    }
}
