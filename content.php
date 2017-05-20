<?php
if(isset($_GET['xem'])){
	$tam=$_GET['xem'];
}
else $tam='';
if ($tam=='cart'){
	if(isset($_SESSION['ten'])) include("cart.php");
	else include ("login.php");
}
else if ($tam=='sanpham') include_once("shop.php");
else if ($tam=='login') include("login.php");
else if($tam=='checkout')include("checkout.php");
else if($tam=='profile')include("profile.php");
else if($tam=='product') include("product-details.php");
else if ($tam=='logout'){
	session_destroy();
	echo "<script>window.location.href='index.php?xem=	'</script>";
}

else include("home.php");
?>