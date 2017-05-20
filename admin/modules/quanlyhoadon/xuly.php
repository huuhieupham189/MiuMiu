<?php
include("../config.php");
   $id=$_GET['id'];
    if(isset($_POST['sua'])){
         $mavc=$_POST['mavc'];
	$matt=$_POST['matt'];
	$ngaylap=$_POST['ngaylap'];
	$tongtien=$_POST['tongtien'];
	$diachi=$_POST['diachi'];
	$tinhtrang=$_POST['tinhtrang'];
	$ghichu=$_POST['ghichu'];
	
		//echo $mavc." ".$matt." ".$ngaylap." ".$tongtien." ".$diachi." ".$tinhtrang." ".$ghichu;
		$sql_sua = "update hoadon set mavc='$mavc',matt='$matt',ngaylap='$ngaylap',tongtien='$tongtien',diachi='$diachi',tinhtrang='$tinhtrang',ghichu='$ghichu' where mahd='$id'";
		$conn->query($sql_sua);
		header('location:../../index.php?quanly=hoadon&ac=lietke');
        }
     if($_GET['value']==1)
     {
        
         $sql="update hoadon set tinhtrang='Đã duyệt' where mahd='$id'";
         $conn->query($sql);
         header('location:../../index.php?quanly=hoadon&ac=lietke');
     }  else 
     {
        
         $sql="delete from hoadon where mahd='$id'";$sql1="delete from cthd where mahd='$id'";
         $conn->query($sql);
         $conn->query($sql1);
       header('location:../../index.php?quanly=hoadon&ac=lietke');
     } 
?>