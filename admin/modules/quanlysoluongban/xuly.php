<?php
session_start();
if(isset($_POST['search'])){
    header('location:../../index.php?quanly=soluongban&ac=lietke&nam='.$_POST['nam'].'');

}
?>