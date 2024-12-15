<head>
  <link rel="shortcut icon" href="images/logo-nobg.png" type="image/x-icon" />
</head>

<?php
error_reporting(1);
session_start();

require_once("model/connect.php");
require_once("controller/cPromotions.php");
require_once("controller/cPartyPackages.php");
require_once("controller/cIngredients.php");
require_once("controller/cCustomers.php");
require_once("controller/cOrders.php");
require_once("controller/cEmployees.php");
require_once("controller/cDishes.php");
require_once("controller/cMessage.php");

$db = new Database();
$conn = $db->connect();

include_once("view/layout/header.php");

$p = "";

if ($_REQUEST["p"] != "")
  $p = $_REQUEST["p"];
else
  $p = "home";

if ($p != "home")
  include_once("view/page/" . $p . "/index.php");
else
  include_once("view/page/home/index.php");

include_once("view/layout/footer.php");

echo "<script src='view/main.js'></script>";
?>