<?php
include('../config.php');
	session_start();
    if(isset($_POST['thanhtoan']))
    {
        echo $_POST['tien'];
       $sql="insert into phieuchitien (manpp,ngaylap,sotien,lydo) value('".$_GET['id']."','".date('Y-m-d')."','".$_POST['tien']."','".$_POST['lydo']."')";
      $conn->query($sql);
  
       header('location:../../index.php?quanly=thanhtoan&ac=lietkedh');
    }
?>