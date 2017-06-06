<?php
 header("Content-Type: application/vnd.ms-word");
 header("Expires: 0");
 header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
 header("content-disposition: attachment;filename=Hoadon.doc");
 include("config.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<meta name="description" content="">
    <meta name="author" content="">-->
    <title>Shop Mỹ Phẩm MiuMiu</title>

     
    
</head><!--/head-->
<body >
<h1>HÓA ĐƠN BÁN HÀNG</h1>
<p>Shop mĩ phẩm MIU MIU</p>
<?php


$sqltr="select * from taikhoan where matk='".$_SESSION['matk']."'";
$ketqua1=$conn->query($sqltr);
$dong1=$ketqua1->fetch_array();

echo "<br><p>Tên khách hàng: ".$dong1['HoTen']."<p>";?>

 <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Tên sản phẩm</th>
                      <th>Số lượng</th>
                      <th>Thành Tiền</th>
                      
                    </tr>
                  </thead>
<?php

$sql="select * from hoadon hd,cthd,sanpham sp where hd.mahd=cthd.mahd and sp.masp=cthd.masp and hd.mahd='5'";
$ketqua=$conn->query($sql);

// $sqltr="select * from taikhoan where matk='".$_SESSION['matk']."'";
// $ketqua1=$conn->query($sqltr);
// $dong1=$ketqua->fetch_array();
$i=0;
// echo "<br><p>Tên khách hàng: ".$dong['HoTen']."<p>";
while($dong=$ketqua->fetch_array()){
    $i++;
 echo"<tbody id='items'>
                    <tr>
                      <td>".$i."</td>
                      <td>".$dong['TenSP']."</td>
                      <td>".$dong['SoLuong']."</td>
                      <td>".number_format($dong['ThanhTien'])."VND</td>";
                                    
                                         
                    
                   echo" </tr>";}
                   ?> 
                   
                  </tbody>
                </table>

                <?php 
                $sql="select * from hoadon where mahd='5'";
                $ketqua=$conn->query($sql);
                $dong=$ketqua->fetch_array();
                echo"Tổng cộng: ".number_format($dong['TongTien'])."VND"; ?>
</body>
</html>