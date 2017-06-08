<?php
include("../config.php");
if(isset($_POST['submit1'])) {
$sql="select * from sanpham where maloaisp=".$_POST['maloaisp']."";
$ketqua=$conn->query($sql);
if($ketqua->num_rows>0)
{
    while($dong=$ketqua->fetch_array()){
        $sql1="insert into khuyenmai(tenkm,masp,tiso,ngaybd,ngaykt,ghichu) values('".$_POST['tenkm']."','".$dong['MaSP']."','".$_POST['khuyenmai']."','".date('Y-m-d')."','".$_POST['ngayketthuc']."','".$_POST['ghichu']."')";
        $conn->query($sql1);
    }
}
header('location:../../index.php?quanly=khuyenmai&ac=tao');
}
elseif(isset($_POST['submit2'])) {

 $sql="select * from sanpham where mathuonghieu=".$_POST['mathuonghieu']."";
$ketqua=$conn->query($sql);
if($ketqua->num_rows>0)
{
    while($dong=$ketqua->fetch_array()){
        $sql1="insert into khuyenmai(tenkm,masp,tiso,ngaybd,ngaykt,ghichu) values('".$_POST['tenkm']."','".$dong['MaSP']."','".$_POST['khuyenmai']."','".date('Y-m-d')."','".$_POST['ngayketthuc']."','".$_POST['ghichu']."')";
        $conn->query($sql1);
    }
}
header('location:../../index.php?quanly=khuyenmai&ac=tao');
}else{
{
    $sql1="insert into khuyenmai(tenkm,masp,tiso,ngaybd,ngaykt,ghichu) values('".$_POST['tenkm']."','".$_POST['masp']."','".$_POST['khuyenmai']."','".date('Y-m-d')."','".$_POST['ngayketthuc']."','".$_POST['ghichu']."')";
        $conn->query($sql1);
}
header('location:../../index.php?quanly=khuyenmai&ac=tao');
}
?>