<?php

class mIngredients
{
    public function mGetAllIngredient()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM ingredient i join needingredient ni on i.ingredientID = ni.ingredientID left join importorder o on o.importOrderID = ni.importOrderID ";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllIngredient1()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM ingredient ";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetUnitIngredient()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM ingredient GROUP BY unitOfcalculation";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllIngredientLiMit($startFrom, $productsPerPage)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM ingredient LIMIT $startFrom, $productsPerPage";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllStoreIngredient($ingredientID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM ingredient i JOIN store_ingredient si ON i.ingredientID = si.ingredientID JOIN store s ON s.storeID = si.storeID WHERE i.ingredientID = $ingredientID";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetIngredientById($ingreID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM ingredient WHERE ingredientID = '$ingreID'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetIngredientNotType($type)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM ingredient WHERE typeIngredient != '$type' GROUP BY typeIngredient";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetIngredientNotUnit($unit)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `ingredient` WHERE unitOfcalculation != '$unit' GROUP BY unitOfcalculation";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetTypeIngre()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM `ingredient` GROUP BY typeIngredient";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetUnit()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT ingredientID, unitOfcalculation FROM ingredient  GROUP BY unitOfcalculation";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetUnitByIngredient($ingredient)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT unitOfcaculation FROM ingredient WHERE ingredientName = $ingredient";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetQuantityFreshIngredient($quantities)
    {
        $db = new Database;
        $conn = $db->connect();
        $dishID = 0;
        $sql_parts = [];
        foreach ($quantities as $dishID => $quantity) {
            $dishID += 1;
            $sql_parts[] = "WHEN di.dishID = $dishID THEN $quantity";
        }
        $sql_case = implode(' ', $sql_parts);
        $sql = "SELECT di.ingredientID, i.ingredientName, i.unitOfcalculation, SUM(di.quantity * CASE $sql_case ELSE 0 END) AS TotalQuantity FROM ingredient i 
            inner join dish_ingredient di on i.ingredientID = di.ingredientID WHERE i.typeIngredient = 'Tươi' GROUP BY i.ingredientID HAVING TotalQuantity != 0";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetQuantityDryIngredient($quantities, $userID)
    {
        $db = new Database;
        $conn = $db->connect();
        $dishID = 0;
        $sql_parts = [];
        foreach ($quantities as $dishID => $quantity) {
            $dishID += 1;
            $sql_parts[] = "WHEN di.dishID = $dishID THEN $quantity";
        }
        $sql_case = implode(' ', $sql_parts);
        $sql = "SELECT *, SUM(di.quantity * CASE $sql_case ELSE 0 END) AS TotalQuantity FROM ingredient i inner join dish_ingredient di on i.ingredientID = di.ingredientID 
            inner join store_ingredient si on i.ingredientID = si.ingredientID inner join user u on u.storeID = si.storeID WHERE i.typeIngredient = 'Khô' AND u.userID = $userID GROUP BY i.ingredientID HAVING TotalQuantity != 0";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }



    public function mGetTotalIngredient()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT COUNT(*) as total FROM ingredient";
        if ($conn != null) {
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalProducts = $row['total'];
            return $totalProducts;
        } else {
            return 0;
        }
    }

    public function mDecreaseIngredient($dishID, $quantity)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `dish_ingredient` SET quantity = quantity - $quantity WHERE dishID = $dishID";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mInsertIngredient($ingreName, $unit, $price, $type)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO ingredient (ingredientName, unitOfcalculation, price, typeIngredient) VALUES ('$ingreName', '$unit', $price, '$type')";

        if ($conn->query($sql))
            return $conn->insert_id;
        else
            return -1;
    }

    public function mInsertStoreIngredient($ingredientID)
    {
        $db = new Database;
        $conn = $db->connect();
        $i = 1;
        $isSuccess = false;
        while ($i != 6) {
            $sql = "INSERT INTO store_ingredient (ingredientID, storeID, quantityInStock) VALUES ('$ingredientID', '$i', '0')";
            if ($conn != null) {
                if ($conn->query($sql)) {
                    $isSuccess = true;
                    $i++;
                } else {
                    $isSuccess = false;
                    break;
                }
            }
        }
        return $isSuccess;
    }

    public function mUpdateIngredient($ingreName, $unit, $price, $type, $ingreID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `ingredient` SET ingredientName = '$ingreName', unitOfcalculation = '$unit', price = $price, typeIngredient = '$type' WHERE ingredientID = $ingreID";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mUpdateStoreThuaIngredient($storeThua, $soLuongChuyen)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `store_ingredient` SET quantityInStock = quantityInStock - $soLuongChuyen WHERE storeID = $storeThua";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mUpdateStoreThieuIngredient($storeThieu, $soLuongChuyen)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `store_ingredient` SET quantityInStock = quantityInStock + $soLuongChuyen WHERE storeID = $storeThieu";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mLockIngredient($status, $ingredientID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE ingredient SET status = $status WHERE ingredientID = '$ingredientID'";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetRevenueIngredientByStore($storeID, $startDate, $endDate)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT 
                    i.ingredientName, 
                    i.unitOfcalculation, 
                    si.quantityInStock, 
                    SUM(ni.quantity) AS quantityImported, 
                    i.price
                FROM 
                    needIngredient ni
                JOIN 
                    importOrder io ON ni.importOrderID = io.importOrderID
                JOIN 
                    ingredient i ON ni.ingredientID  = i.ingredientID 
                JOIN 
                    store_Ingredient si ON si.ingredientID  = i.ingredientID  AND si.storeID = $storeID
                WHERE 
                    io.importOrderDate BETWEEN '$startDate' AND '$endDate'
                GROUP BY 
                    i.ingredientID
            ";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllNeedIngredientByStore($storeID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM needingredient ni 
                JOIN ingredient i ON i.ingredientID = ni.ingredientID 
                JOIN importorder io ON io.importOrderID = ni.importOrderID 
                JOIN user u ON u.userID = io.userID 
                WHERE u.storeID = $storeID GROUP BY ni.ingredientID";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mUpdateNeedIngredientQuantity($ingredientID, $quantity, $storeID)
    {
        $db = new Database;
        $conn = $db->connect();

        $sql1 = "UPDATE needingredient SET quantity = $quantity 
                 WHERE ingredientID = $ingredientID";

        $sql2 = "UPDATE store_ingredient 
                 SET quantityInStock = quantityInStock + $quantity 
                 WHERE ingredientID = $ingredientID AND storeID = $storeID";

        if ($conn != null) {
            return $conn->query($sql1) && $conn->query($sql2);
        }
        return 0;
    }
}
