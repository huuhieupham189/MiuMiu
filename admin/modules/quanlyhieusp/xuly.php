<?php
	include('../config.php');
	$tenhieusp=$_POST['hieusp'];
	$tinhtrang=$_POST['tinhtrang'];
	
	if(isset($_POST['them'])){
		//them
		$sql_them=("insert into hieusp (tenhieusp,tinhtrang) value('$tenhieusp','$tinhtrang')");
		$conn->query($sql_them);
		header('location:../../index.php?quanly=hieusp&ac=lietke');
	}elseif(isset($_POST['sua'])){
		//sua
		$sql_sua = "update hieusp set tenhieusp='$tenhieusp',tinhtrang='$tinhtrang' where idhieusp='$_GET[id]'";
		$conn->query($sql_sua);
		header('location:../../index.php?quanly=hieusp&ac=lietke');
	}else{
		$sql_xoa = "delete from hieusp where idhieusp = $_GET[id]";
		$conn->query($sql_xoa);
		header('location:../../index.php?quanly=hieusp&ac=lietke');
	}
?>
