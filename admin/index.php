<?php
session_start();
if(!isset($_SESSION['dangnhap'])){
    header('location:login.php');
}else 
echo "Xin chao admin:".$_SESSION['dangnhap'];

?>
