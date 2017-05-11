<?php
if(isset($_GET['xem'])){
	$tam=$_GET['xem'];
}
else $tam='';
if ($tam=='') include("home.php");
else if ($tam=='login') include("login.php");
else if($tam=='checkout')include("checkout.php");
else include("cart.php");
?>