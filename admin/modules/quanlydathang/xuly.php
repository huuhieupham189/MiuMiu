<?php
include('../config.php');
	session_start();
    if(isset($_POST['thanhtoan']))
    {
        echo $_POST['tien'];
       $sql="insert into phieuchitien (manpp,ngaylap,sotien,lydo) value('".$_GET['id']."','".date('Y-m-d')."','".$_POST['tien']."','".$_POST['lydo']."')";
       if($conn->query($sql))
       {
           $id=$conn->insert_id;
           $sql="select * from  hoadonnhaphang where mahdnh='".$_GET['mahdnh']."'";
           $ketqua=$conn->query($sql);
           $dong=$ketqua->fetch_array();
           if($dong['TongTien']>$_POST['tien'])
           {
               $tien=$dong['TongTien']-$_POST['tien'];
               $sqltr="update hoadonnhaphang set tongtien='$tien' where mahdnh='".$_GET['mahdnh']."'";
               $conn->query($sqltr);
           }
           else 
           {
               
               $sqltr="update hoadonnhaphang set tongtien='0',tinhtrang='đã thanh toán' where mahdnh='".$_GET['mahdnh']."'";
               $conn->query($sqltr);
           }
       }
       header('location:../../index.php?quanly=thanhtoan&ac=lietkedh');
    }
?>