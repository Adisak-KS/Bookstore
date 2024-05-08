<?php
ob_start();
session_start();

if (isset($_GET["Line"])) {
	$Line = $_GET["Line"];
	// $_SESSION["strProductID"][$Line] = "";
	// $_SESSION["strQty"][$Line] = "";
	unset($_SESSION["strProductID"][$Line]);
	unset($_SESSION["strQty"][$Line]);
}
//$_SESSION['total_items'] = array_sum($_SESSION["strQty"]);
$uniqueItems = count(array_unique($_SESSION["strProductID"]));

// เก็บผลลัพธ์ใน $_SESSION['total_items']
if (isset($_SESSION["strProductID"])) {
	$uniqueItems = count(array_unique($_SESSION["strProductID"]));

	// เก็บผลลัพธ์ใน $_SESSION['total_items']
	$_SESSION['total_items'] = $uniqueItems;
} else {
	$_SESSION['total_items'] = 0;
}
header("location:cart.php");
