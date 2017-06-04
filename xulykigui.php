<?php
	include('config.php');
    Session_start();
	$tensp=$_POST['tensp'];
	$tenviettat=$_POST['tenviettat'];
	$hinhanh=$_FILES['hinhanh']['name'];
	$hinhanh_tmp=$_FILES['hinhanh']['tmp_name'];
	move_uploaded_file($hinhanh_tmp,'admin/modules/quanlysanpham/uploads/'.$hinhanh);
	$gia=$_POST['gia'];
    $slton=$_POST['slton'];
	$ttct=$_POST['ttct'];
	
	
	
	if(isset($_POST['them'])){
			$giaban=$gia*1.3;
           
		 $sql_them=("insert into sanpham (tensp,tenviettat,hinhanh,gianhap,giaban,slton,ttct,maloaisp) values('$tensp','$tenviettat','$hinhanh','$gia','$giaban','$slton','$ttct','13')");
		if($conn->query($sql_them)){
            $id=$conn->insert_id;
            $sql="insert into kigui (matk,masp) values('".$_SESSION['matk']."','$id')";
            if($conn->query($sql))
            header('location:index.php');
        }
		 
	}elseif(isset($_POST['sua'])){
		$giaban=$gia*1.3;
		
		if($hinhanh!=''){
	  $sql_sua = "update sanpham set tensp='$tensp',tenviettat='$tenviettat',hinhanh='$hinhanh',gianhap='$gia',giaban='$giaban',slton=slton+$slton,ttct='$ttct',maloaisp='13' where masp='$_GET[id]'";
		}else{
			$sql_sua = "update sanpham set tensp='$tensp',tenviettat='$tenviettat',gianhap='$gia',giaban='$giaban',slton=slton+$slton,ttct='$ttct',maloaisp='13' where masp='$_GET[id]'";
		}
		if($conn->query($sql_sua)) 
		header('location:index.php?xem=profile&id='.$_SESSION['matk'].'');
		
	}else{
		 $sql_xoa = "delete from sanpham where Masp = $_GET[id]";
		 $conn->query($sql_xoa);
		  $sql_xoa = "delete from kigui where Masp = $_GET[id]";
		 $conn->query($sql_xoa);
		 header('location:index.php?xem=profile&id='.$_SESSION['matk'].'');
	}
?>
