<?php

class mPromotions
{
    public function mGetAllPromotion()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllPromotionGoingOn()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion WHERE status = 1";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetAllPromotionComming()
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion WHERE status = 2";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetPromotionNotStatus($status)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion WHERE status != $status GROUP BY status";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mGetPromotionById($proID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "SELECT * FROM promotion WHERE promotionID = $proID";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mInsertPromotion($proName, $des, $percent, $start, $end, $image, $status)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "INSERT INTO promotion(promotionName, description, discountPercentage, startDate, endDate, image, status) VALUES ('$proName', '$des', $percent, '$start', '$end', '$image', '$status')";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mUpdateQuantityPromotion($promotionID, $quantity)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE `promotion` SET quantity = quantity - $quantity WHERE promotionID = $promotionID AND quantity > 0";
        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mLockPromotion($proID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE promotion SET status = 0 WHERE promotionID = $proID";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mUpdatePromotion($proID, $proName, $des, $percent, $start, $end, $image, $status)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE promotion SET promotionName = '$proName', description = '$des', discountPercentage = '$percent', startDate = '$start', endDate = '$end', image = '$image', status = '$status' WHERE promotionID = '$proID'";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }

    public function mUpdatePromotionStatus($proID)
    {
        $db = new Database;
        $conn = $db->connect();
        $sql = "UPDATE promotion SET status = 0 WHERE promotionID = '$proID'";

        if ($conn != null)
            return $conn->query($sql);
        return 0;
    }
}