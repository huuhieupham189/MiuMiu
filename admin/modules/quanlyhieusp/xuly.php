<?php
	include('../config.php');
	$tenhieusp=$_POST['hieusp'];
	$xuatxu=$_POST['XuatXu'];
	$ghichu=$_POST['GhiChu'];
	if(isset($_POST['them'])){
		//them
		$sql_them=("insert into thuonghieu (tenthuonghieu,XuatXu,ghichu) values('$tenhieusp','$xuatxu','$ghichu')");
		$conn->query($sql_them);
		header('location:../../index.php?quanly=hieusp&ac=lietke');
	}elseif(isset($_POST['sua'])){
		//sua
		$sql_sua = "update thuonghieu set tenthuonghieu='$tenhieusp',XuatXu='$xuatxu',ghichu='$ghichu' where mathuonghieu='$_GET[id]'";
		$conn->query($sql_sua);
		header('location:../../index.php?quanly=hieusp&ac=lietke');
	}else{
		$sql_xoa = "delete from thuonghieu where mathuonghieu = $_GET[id]";
		$conn->query($sql_xoa);
		header('location:../../index.php?quanly=hieusp&ac=lietke');
	}
?>
