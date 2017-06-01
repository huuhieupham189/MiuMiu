<?php
session_start();
include('config.php');
if(isset($_POST['save']))
{
  $hoten=$_POST['hoten'];
  $ngaysinh=$_POST['ngaysinh'];
  $id=$_SESSION['matk'];
  $sdt=$_POST['sdt'];
  $diachi=$_POST['diachi'];
  $email=$_POST['email'];
  $cmnd=$_POST['cmnd'];
  $sql="update taikhoan set hoten='$hoten',ngaysinh='$ngaysinh',sdt='$sdt',diachi='$diachi',email='$email',cmnd='$cmnd' where matk='$id'";
  $conn->query($sql);
  header("location:index.php?xem=profile&id=".$id."");
}
?>