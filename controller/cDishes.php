<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true 
    || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mDishes.php";
else
    $path = "./model/mDishes.php";

if (!class_exists("mDishes"))
    require_once($path);

class cDishes extends mDishes
{
    public function cGetAllCategory()
    {
        if ($this->mGetAllCategory() != 0) {
            $result = $this->mGetAllCategory();

            return $result;
        }
        return 0;
    }

    public function cSearchDish($input)
    {
        if ($this->mSearchDish($input) != 0) {
            $result = $this->mSearchDish($input);

            return $result;
        }
        return 0;
    }

    public function cGetCategoryNotId($category)
    {
        if ($this->mGetCategoryNotId($category) != 0) {
            $result = $this->mGetCategoryNotId($category);

            return $result;
        }
    }

    public function cGetAllDish()
    {
        if ($this->mGetAllDish() != 0) {
            $result = $this->mGetAllDish();

            return $result;
        }
        return 0;
    }

    public function cGetAllDishIngredientByID($dishID)
    {
        if ($this->mGetAllDishIngredientByID($dishID) != 0) {
            $result = $this->mGetAllDishIngredientByID($dishID);

            return $result;
        }
        return 0;
    }

    public function cGetAllDishLimit($startFrom, $productsPerPage)
    {
        if ($this->mGetAllDishLimit($startFrom, $productsPerPage) != 0) {
            $result = $this->mGetAllDishLimit($startFrom, $productsPerPage);

            return $result;
        }
        return 0;
    }

    public function cGetDishTop()
    {
        if ($this->mGetDishTop() != 0) {
            $result = $this->mGetDishTop();

            return $result;
        }
        return 0;
    }

    public function cGetDishById($dishID)
    {
        if ($this->mGetDishById($dishID) != 0) {
            $result = $this->mGetDishById($dishID);

            return $result;
        }
        return 0;
    }

    public function cGetDishByName($name)
    {
        if ($this->mGetDishByName($name) != 0) {
            $result = $this->mGetDishByName($name);

            return $result;
        }
        return 0;
    }

    public function cGetDishByCategory($category)
    {
        if ($this->mGetDishByCategory($category) != 0) {
            $result = $this->mGetDishByCategory($category);
            return $result;
        }
        return 0;
    }

    public function cInsertDish($dishName, $dishCategory, $price, $prepare, $image, $description, $ingredient, $quantity)
    {
        $dishId = $this->mInsertDish($dishName, $dishCategory, $price, $prepare, $image, $description);
        if ($dishId != -1) {
            if ($this->mInsertDishIngredients($dishId, $ingredient, $quantity)) {
                return true;
            } else {
                return false;
            }
        } else
            return 0;

    }

    public function cUpdateDish($dishName, $dishCategory, $price, $prepare, $image, $dishID, $imgName, $description, $ingredient, $ingredient_old, $quantity)
    {
        $success = true;

        $result = $this->mUpdateDish($dishName, $dishCategory, $price, $prepare, $imgName, $dishID, $description);
        if ($result) {
            // echo "<script>alert('1')</script>";
            if ($this->mUpdateDishIngredient($dishID, $ingredient, $ingredient_old, $quantity)) {
                $success = true;
            } else {
                $success = false;
            }
        } else {
            $success = false;
        }
        return $success;
    }

    public function cUpdateDishAvailabilityStatus($availability, $dishID)
    {
        if ($this->mUpdateDishAvailabilityStatus($availability, $dishID) != 0) {
            echo "<script>alert('Cập nhật món ăn thành công!')</script>";
        }
    }

    public function cLockDish($status, $dishID)
    {
        if ($this->mLockDish($status, $dishID) != 0) {
            echo "<script>alert('" . ($status == 1 ? "Mở khóa" : "Khóa") . " món ăn thành công!')</script>";
        }
    }

    public function cGetTotalDish()
    {
        if ($this->mGetTotalDish() != 0) {
            $result = $this->mGetTotalDish();

            return $result;
        }
        return 0;
    }
}
