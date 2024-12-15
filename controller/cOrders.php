<?php
$currentPath = $_SERVER["REQUEST_URI"];
$path = "";
if (strpos($currentPath, "admin") || strpos($currentPath, "manager") 
    || strpos($currentPath, "orderstaff") || strpos($currentPath, "kitchenstaff")
    || strpos($currentPath, "/dish") == true)
    $path = "../../../model/mOrders.php";
else $path = "./model/mOrders.php";

if (!class_exists("mOrders"))
    require_once($path);

class cOrders extends mOrders
{
    public function cGetAllOrder() {
        if ($this->mGetAllOrder() != 0) {
            $result = $this->mGetAllOrder();
            
            return $result;
        } return 0;
    }

    public function cGetAllOrderByID($orderID) {
        $result = [];
        $orderData = $this->mGetAllOrderByID($orderID);
        if ($orderData != 0 && $orderData->num_rows > 0) {
            $order = $orderData->fetch_assoc();
            if (!is_null($order['partyPackageID'])) {
                $packageData = $this->mGetOrderPackage($orderID);
                if ($packageData != 0 && $packageData->num_rows > 0) {
                    $result['type'] = 'package';
                    $result['data'] = $packageData->fetch_all(MYSQLI_ASSOC);
                    return $result;
                }else {
                    return 0;
                }
            } else {
                $dishData = $this->mGetOrderDishes($orderID);
                if ($dishData != 0 && $dishData->num_rows > 0) {
                    $result['type'] = 'dishes';
                    $result['data'] = $dishData->fetch_all(MYSQLI_ASSOC);
                    return $result;
                } else {
                    return 0;
                }
            }
        }
    }

    public function cGetAllOrderDishByID($orrderID) {
        if ($this->mGetOrderDishes($orrderID) != 0) {
            $result = $this->mGetOrderDishes($orrderID);
            
            return $result;
        } return 0;
    }

    public function cGetAllOrderPackageByID($orrderID) {
        if ($this->mGetOrderDishes($orrderID) != 0) {
            $result = $this->mGetOrderPackage($orrderID);
            
            return $result;
        } return 0;
    }
    
    public function cGetRevenueOrderByStore($storeID, $start, $end) {
        if ($this->mGetRevenueOrderByStore($storeID, $start, $end) != 0) {
            $result = $this->mGetRevenueOrderByStore($storeID, $start, $end);
            
            return $result;
        } return 0;
    }
    
    public function cGetAllOrderRangeOf($start, $end) {
        if ($this->mGetAllOrderRangeOf($start, $end) != 0) {
            $result = $this->mGetAllOrderRangeOf($start, $end);
            
            return $result;
        } return 0;
    }
    
    /* public function cUpdateOrder($orderID, $note, $total) {
        return $this->mUpdateOrder($orderID, $note, $total);
    } */
    
    public function cUpdateOrderDish($orderID, $quantityUpdate, $notes, $total, $dishID) {
        if ($this->mUpdateOrderDish($orderID, $quantityUpdate, $notes, $total, $dishID)) {
            return true;
        }else 
        return false;
    }

    
    public function cUpdateStatusOrder($orderID, $status, $storeID) {
        return $this->mUpdateStatusOrder($orderID, $status, $storeID);
    }
    
    public function cUpdateOrderPartyPackage($orderID, $note) {
        return $this->mUpdateOrderPartyPackage($orderID, $note);
    }
    
    public function cInsertOrder($phoneNumber, $total, $sumOfQuantity, $promotionID, $paymentMethod, $storeID) {
        return $this->mInsertOrder($phoneNumber, $total, $sumOfQuantity, $promotionID, $paymentMethod, $storeID);
    }
    
    public function cInsertOrderPartyPackage($phoneNumber, $total, $sumOfQuantity, $promotionID, $paymentMethod, $storeID, $partyPackageID) {
        return $this->mInsertOrderPartyPackage($phoneNumber, $total, $sumOfQuantity, $promotionID, $paymentMethod, $storeID, $partyPackageID);
    }
    
    public function cInsertOrderDish($orderID, $dishID, $quantity) {
        return $this->mInsertOrderDish($orderID, $dishID, $quantity);
    }
    
    public function cGetAllOrderFully($storeID) {
        if ($this->mGetAllOrderFully($storeID) != 0) {
            $result = $this->mGetAllOrderFully($storeID);
            
            return $result;
        } return 0;
    } 
    
    public function cGetOrderIDNew() {
        if ($this->mGetOrderIDNew() != 0) {
            $result = $this->mGetOrderIDNew();
            
            return $result;
        } return 0;
    }  
}