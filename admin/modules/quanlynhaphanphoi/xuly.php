<?php
	include('../config.php');
	$TenNPP=$_POST['TenNPP'];
	$MaThuongHieu=$_POST['MaThuongHieu'];
	$CongNo=$_POST['CongNo'];
	$DiaChi=$_POST['DiaChi'];


	if(isset($_POST['them'])){
		//them
		 $sql_them=("insert into nhaphanphoi (MaThuongHieu,DiaChi,Tennpp,congno) values('$MaThuongHieu','$DiaChi','$TenNPP','$CongNo')");
		$conn->query($sql_them);
		header('location:../../index.php?quanly=nhaphanphoi&ac=lietke');
	}elseif(isset($_POST['sua'])){
		//sua
		
		
	    $sql_sua = "update nhaphanphoi set tennpp='$TenNPP',MaThuongHieu='$MaThuongHieu',DiaChi='$DiaChi',congno='$CongNo' where manpp='$_GET[id]'";
		
	    if($conn->query($sql_sua)) 
		header('location:../../index.php?quanly=nhaphanphoi&ac=lietke');
	}else{
		$sql_xoa = "delete from nhaphanphoi where Manpp = $_GET[id]";
		$conn->query($sql_xoa);
        
		header('location:../../index.php?quanly=nhaphanphoi&ac=lietke');
	}
?>
