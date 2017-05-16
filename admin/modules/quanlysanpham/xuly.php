<?php
	include('../config.php');
	$tensp=$_POST['tensp'];
	$masp=$_POST['masp'];
	$hinhanh=$_FILES['hinhanh']['name'];
	$hinhanh_tmp=$_FILES['hinhanh']['tmp_name'];
	move_uploaded_file($hinhanh_tmp,'uploads/'.$hinhanh);
	$giadexuat=$_POST['giadexuat'];
	$giagiam=$_POST['giagiam'];
	$soluong=$_POST['soluong'];
	$noidung=$_POST['noidung'];
	$loaisp=$_POST['loaisp'];
	$nhasx=$_POST['nhasx'];
	$tinhtrang=$_POST['tinhtrang'];
	$trang=$_GET['trang'];
	
	if(isset($_POST['them'])){
		//them
		 $sql_them=("insert into sanpham (tensp,masp,hinhanh,giadexuat,giagiam,soluong,noidung,loaisp,nhasx,tinhtrang) value('$tensp','$masp','$hinhanh','$giadexuat','$giagiam','$soluong','$noidung','$loaisp','$nhasx','$tinhtrang')");
		$conn->query($sql_them);
		header('location:../../index.php?quanly=sanpham&ac=lietke');
	}elseif(isset($_POST['sua'])){
		//sua
		if($hinhanh!=''){
	  $sql_sua = "update sanpham set tensp='$tensp',masp='$masp',hinhanh='$hinhanh',giadexuat='$giadexuat',giagiam='$giagiam',soluong='$soluong',noidung='$noidung',loaisp='$loaisp',nhasx='$nhasx',tinhtrang='$tinhtrang' where idsanpham='$_GET[id]'";
		}else{
			$sql_sua = "update sanpham set tensp='$tensp',masp='$masp',giadexuat='$giadexuat',giagiam='$giagiam',soluong='$soluong',noidung='$noidung',loaisp='$loaisp',nhasx='$nhasx',tinhtrang='$tinhtrang' where idsanpham='$_GET[id]'";
		}
		$conn->query($sql_sua);
		header('location:../../index.php?quanly=sanpham&ac=lietke');
	}else{
		$sql_xoa = "delete from sanpham where idsanpham = $_GET[id]";
		$conn->query($sql_xoa);
		header('location:../../index.php?quanly=sanpham&ac=lietke');
	}
?>
