<?php
include('../config.php');
$sql_xoa = "delete from sanpham where Masp = $_GET[id]";
		$conn->query($sql_xoa);
		header('location:../../index.php?quanly=kigui&ac=lietke');
?>