<?php
	include('../config.php');
	$tensp=$_POST['tensp'];
	$tenviettat=$_POST['tenviettat'];
	$hinhanh=$_FILES['hinhanh']['name'];
	$hinhanh_tmp=$_FILES['hinhanh']['tmp_name'];
	move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
	$gianhap=$_POST['gianhap'];
	$giaban=$_POST['giaban'];
	$slton=$_POST['slton'];
	$ttct=$_POST['ttct'];
	$maloaisp=$_POST['maloaisp'];
	$mathuonghieu=$_POST['mathuonghieu'];
	$trang=$_GET['trang'];
	
	if(isset($_POST['them'])){
		//them
		 $sql_them=("insert into sanpham (tensp,tenviettat,hinhanh,gianhap,giaban,slton,ttct,MaLoaiSP,MaThuongHieu) values('$tensp','$tenviettat','$hinhanh','$gianhap','$giaban','$slton','$ttct','$maloaisp','$mathuonghieu')");
		$conn->query($sql_them);
		header('location:../../index.php?quanly=sanpham&ac=lietke');
	}elseif(isset($_POST['sua'])){
		//sua
		echo $maloaisp.$mathuonghieu;
		if($hinhanh!=''){
	  $sql_sua = "update sanpham set tensp='$tensp',tenviettat='$tenviettat',hinhanh='$hinhanh',gianhap='$gianhap',giaban='$giaban',slton='$slton',ttct='$ttct',maloaisp='$maloaisp',mathuonghieu='$mathuonghieu' where masp='$_GET[id]'";
		}else{
			$sql_sua = "update sanpham set tensp='$tensp',tenviettat='$tenviettat',gianhap='$gianhap',giaban='$giaban',slton='$slton',ttct='$ttct',maloaisp='$maloaisp',mathuonghieu='$mathuonghieu' where masp='$_GET[id]'";
		}
		$conn->query($sql_sua);
		header('location:../../index.php?quanly=sanpham&ac=lietke');
	}else{
		$sql_xoa = "delete from sanpham where Masp = $_GET[id]";
		$conn->query($sql_xoa);
		header('location:../../index.php?quanly=sanpham&ac=lietke');
	}
?>
