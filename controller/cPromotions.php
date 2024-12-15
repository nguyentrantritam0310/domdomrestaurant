<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") == true || strpos($currentPath, "manager") == true 
    || strpos($currentPath, "orderstaff") == true || strpos($currentPath, "kitchenstaff") == true
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mPromotions.php";
else
    $path = "./model/mPromotions.php";

if (!class_exists("mPromotions"))
    require_once($path);

class cPromotions extends mPromotions
{
    public function cGetAllPromotion()
    {
        if ($this->mGetAllPromotion() != 0) {
            $result = $this->mGetAllPromotion();

            return $result;
        }
        return 0;
    }

    public function cGetAllPromotionGoingOn()
    {
        if ($this->mGetAllPromotionGoingOn() != 0) {
            $result = $this->mGetAllPromotionGoingOn();

            return $result;
        }
        return 0;
    }

    public function cGetAllPromotionComming()
    {
        if ($this->mGetAllPromotionComming() != 0) {
            $result = $this->mGetAllPromotionComming();

            return $result;
        }
        return 0;
    }

    public function cGetPromotionNotStatus($status)
    {
        if ($this->mGetPromotionNotStatus($status) != 0) {
            $result = $this->mGetPromotionNotStatus($status);

            return $result;
        }
    }

    public function cGetPromotionById($proID)
    {
        if ($this->mGetPromotionById($proID) != 0) {
            $result = $this->mGetPromotionById($proID);

            return $result->fetch_assoc();
        }
    }

    public function cInsertPromotion($proName, $des, $percent, $start, $end, $image, $status)
    {
        if ($this->mInsertPromotion($proName, $des, $percent, $start, $end, $image, $status) != 0) {
            echo "<script>alert('Thêm khuyến mãi thành công');</script>";
        }
    }

    public function cUpdatePromotion($proID, $proName, $des, $percent, $start, $end, $image, $status)
    {
        if ($this->mUpdatePromotion($proID, $proName, $des, $percent, $start, $end, $image, $status) != 0) {
            echo "<script>alert('Cập nhật khuyến mãi thành công');</script>";
        }
    }

    public function cUpdatePromotionStatus($proID)
    {
        if ($this->mUpdatePromotionStatus($proID) != 0) {
            echo "<script>alert('Khóa khuyến mãi thành công');</script>";
        }
    }

    public function cUpdateQuantityPromotion($promotionID, $quantity)
    {
        return $this->mUpdateQuantityPromotion($promotionID, $quantity);
    }

    public function cLockPromotion($proID)
    {
        if ($this->mLockPromotion($proID) != 0) {
            echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                confirm('Bạn có chắc chắn khóa tài khoản này?');
            });
          </script>";
        }
    }
}