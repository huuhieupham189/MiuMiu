<?php
	include('../config.php');
	$tenloaisp=$_POST['loaisp'];
	$ghichu=$_POST['ghichu'];
	
	if(isset($_POST['them'])){
		//them
		$sql_them=("insert into loaisp (tenloaisp,ghichu) value('$tenloaisp','$ghichu')");
		$conn->query($sql_them);
		header('location:../../index.php?quanly=loaisp&ac=lietke');
	}elseif(isset($_POST['sua'])){
		//sua
		$sql_sua = "update loaisp set tenloaisp='$tenloaisp',ghichu='$ghichu' where MaLoaiSP='$_GET[id]'";
		$conn->query($sql_sua);
		header('location:../../index.php?quanly=loaisp&ac=lietke');
	}else{
		$sql_xoa = "delete from loaisp where MaLoaiSP = $_GET[id]";
		$conn->query($sql_xoa);
		header('location:../../index.php?quanly=loaisp&ac=lietke');
	}
?>
