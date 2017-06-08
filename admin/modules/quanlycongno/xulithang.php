<?php
session_start();
if(isset($_POST['search'])){
    header('location:../../index.php?quanly=congno&ac=lietke&thang='.$_POST['thang'].'&nam='.$_POST['nam'].'');

}
?>