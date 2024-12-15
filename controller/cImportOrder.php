<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true)
    $path = "../../../model/mImportOrder.php";
else $path = "./model/mImportOrder.php";

if (!class_exists("mImportOrder"))
    require_once($path);

class cImportOrder extends mImportOrder
{
    public function cGetAllIngredient()
    {
        if ($this->mGetAllImportOrder() != 0) {
            $result = $this->mGetAllImportOrder();
            
            return $result;
        } return 0;
    }

    public function cInsertNeedIngredient($userID, $ingredient, $quantity)
    {
        $importOrderId = $this->mInsertImportOrder($userID);
            if ($importOrderId != -1) {
                if($this->mInsertNeedIngredient($importOrderId, $ingredient, $quantity)){
                    echo "<script>alert('Lưu nguyên liệu cần mua thành công')</script>";
                    return true;
                }else {
                    $this->checkAndDeleteInvalidImportOrder();
                    echo "<script>alert('Lưu nguyên liệu cần mua thất bại')</script>";
                    return false;
                }
            }
            else
                return false;
            
    }


}