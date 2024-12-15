<?php

class mDishes
{
    public function mGetAllCategory()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish GROUP BY dishCategory";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mSearchDish($input)
    {
        $db = new Database;
        $conn = $db->connect();

        if (is_numeric($input))
            $sql = "SELECT * FROM dish WHERE price = $input";
        else
            $sql = "SELECT * FROM dish WHERE dishName LIKE '%" . $input . "%'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetCategoryNotId($category)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish WHERE dishCategory != '$category' GROUP BY dishCategory";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    public function mGetAllDish()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    // Thêm nguyên liệu vào bảng dish_ingredient
    public function mInsertDishIngredients($dishId, $ingredients, $quantities)
    {
        $db = new Database;
        $conn = $db->connect();
        $demm = 0;
        // Lặp qua các nguyên liệu và chèn vào bảng dish_ingredient
        foreach ($ingredients as $index => $ingredientId) {
            $quantity = $quantities[$index];
            $sql = "INSERT INTO dish_ingredient (dishId, ingredientId, quantity) VALUES ($dishId, '$ingredientId', $quantity)";

            if ($conn != null) {
                if ($conn->query($sql))
                    $demm++;
            }
        }
        if ($demm > 0)
            return true;
        else
            return false;
    }

    public function mGetDishTop()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT *, SUM(OD.quantity) AS MaxQuantity FROM `order` AS O JOIN `order_dish` AS OD ON O.orderID = OD.orderID JOIN `dish` AS D ON D.dishID = OD.dishID GROUP BY OD.dishID ORDER BY MaxQuantity DESC LIMIT 4";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    public function mGetDishById($dishID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT d.*, di.*, i.ingredientName, i.unitOfcalculation FROM dish d INNER JOIN dish_ingredient di ON d.dishID = di.dishID INNER JOIN ingredient i ON di.ingredientID = i.ingredientID WHERE d.dishID = '" . $dishID . "'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetDishByName($name)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish WHERE dishName LIKE '%" . $name . "%'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateDishIngredient($dishID, $ingredients, $ingredient_old, $quantity)
    {
        $db = new Database;
        $conn = $db->connect();
        $success = true;
        $toDelete = array_diff($ingredient_old, $ingredients);
        foreach ($toDelete as $ingredientID) {
            $sql = "DELETE FROM dish_ingredient WHERE dishID = $dishID AND ingredientID = $ingredientID;";
            if (!$conn->query($sql))
                $success = false;
        }

        foreach ($ingredients as $index => $ingredientID) {
            $quantityItem = $quantity[$index];

            // Kiểm tra nếu ingredientID đã tồn tại
            $checkSQL = "SELECT COUNT(*) AS count FROM dish_ingredient WHERE dishID = $dishID AND ingredientID = $ingredientID;";
            $result = $conn->query($checkSQL);
            $row = $result->fetch_assoc();

            if ($row['count'] > 0) {
                // Cập nhật số lượng nếu đã tồn tại
                $updateSQL = "UPDATE dish_ingredient SET quantity = $quantityItem WHERE dishID = $dishID AND ingredientID = $ingredientID;";
                if (!$conn->query($updateSQL))
                    $success = false;
            } else {
                // Thêm mới nếu không tồn tại
                $insertSQL = "INSERT INTO dish_ingredient (dishID, ingredientID, quantity) VALUES ($dishID, $ingredientID, $quantityItem);";
                if (!$conn->query($insertSQL))
                    $success = false;
            }
        }
        return $success;
    }
    
    public function mGetAllDishIngredientByID($dishID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish_ingredient WHERE dishID = '$dishID'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mGetAllDishLimit($startFrom, $productsPerPage)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish LIMIT $startFrom, $productsPerPage";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
    
    public function mUpdateDishNoImg($dishName, $dishCategory, $price, $prepare, $dishID, $description)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE dish SET dishName = '$dishName', dishCategory = '$dishCategory', price = $price, preparationProcess = '$prepare', description = '$description' WHERE dishID = $dishID";
        if ($conn != null)
            if ($conn->query($sql)) {
                return true;
            }else {
                return false;
            }
    }

    public function mGetDishByCategory($category)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM dish WHERE dishCategory = '$category'";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }


    public function mInsertDish($dishName, $dishCategory, $price, $prepare, $image, $description)
    {
        $db = new Database();
        $conn = $db->connect();
        $sql = "INSERT INTO dish (dishName, dishCategory, price, preparationProcess, image, description) VALUES ('$dishName', '$dishCategory', $price, '$prepare', '$image', '$description')";
        if ($conn) {
            if ($conn->query($sql)) {
                // Lấy ID của món ăn vừa được thêm vào
                return $conn->insert_id;
            } else {
                return -1;
            }
        } else {
            return false;
        }
    }

    public function mUpdateDish($dishName, $dishCategory, $price, $prepare, $image, $dishID, $description)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE dish SET dishName = '$dishName', dishCategory = '$dishCategory', price = $price, preparationProcess = '$prepare', image = '$image', description = '$description' WHERE dishID = $dishID";
        if ($conn != null) {
            if ($conn->query($sql)) {
                return true;
            } else {
                
                return false;
            }
        }
    }

    public function mUpdateDishAvailabilityStatus($availability, $dishID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE dish SET availabilityStatus = $availability WHERE dishID = $dishID";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mLockDish($status, $dishID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE dish SET businessStatus = $status WHERE dishID = $dishID";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetTotalDish()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT COUNT(*) as total FROM dish";
        if ($conn != null) {
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $totalProducts = $row['total'];
            return $totalProducts;
        } else {
            return 0;
        }
    }
}