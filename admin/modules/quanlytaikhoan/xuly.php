<?php
	include('../config.php');
	$tentk=$_POST['tentk'];
	$matkhau=$_POST['matkhau'];
	$maloaitk=$_POST['maloaitk'];
	$email=$_POST['email'];
	$hoten=$_POST['hoten'];
	$diachi=$_POST['diachi'];
	$ngaysinh=$_POST['ngaysinh'];
	$sdt=$_POST['sdt'];
    $cmnd=$_POST['cmnd'];
	

	if(isset($_POST['them'])){
		//them
		 $sql_them=("insert into taikhoan (tendangnhap,matkhau,loaitk,email,hoten,diachi,ngaysinh,sdt,cmnd) values('$tentk','$matkhau','$maloaitk','$email','$hoten','$diachi','$ngaysinh','$sdt','$cmnd')");
		$conn->query($sql_them);
		header('location:../../index.php?quanly=nhansu&ac=lietke');
	}elseif(isset($_POST['sua'])){
		//sua
		
		
	    $sql_sua = "update taikhoan set tendangnhap='$tentk',matkhau='$matkhau',LoaiTK='".number_format($maloaitk)."',email='$email',hoten='$hoten',diachi='$diachi',ngaysinh='$ngaysinh',sdt='$sdt' where matk='$_GET[id]'";
		
	    if($conn->query($sql_sua)) 
		header('location:../../index.php?quanly=nhansu&ac=lietke');
	}else{
		$sql_xoa = "delete from taikhoan where Matk = $_GET[id]";
		$conn->query($sql_xoa);
        
		header('location:../../index.php?quanly=nhansu&ac=lietke');
	}
?>
