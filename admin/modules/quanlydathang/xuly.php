<?php
include('../config.php');
	session_start();
    if(isset($_POST['thanhtoan']))
    {
        $id = $_GET['id'];
        $tien= $_POST['tien'];
       
       $sql="insert into phieuchitien (manpp,ngaylap,sotien,lydo) value('".$_GET['id']."','".date('Y-m-d')."','".$_POST['tien']."','".$_POST['lydo']."')";
      $conn->query($sql);
      $sqlupdate="update nhaphanphoi set CongNo= CongNo - $tien where MaNPP = $id";
      $conn->query($sqlupdate);

     header('location:../../index.php?quanly=thanhtoan&ac=lietkedh');
    }
?>