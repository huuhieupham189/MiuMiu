

<div class="button_themsp">
<a href="index.php?quanly=nhapkho&ac=lietke">Liệt kê</a> 
</div>
<form action="modules/quanlynhapkho/xuly.php" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table >
  <tr>
    <td colspan="6" style="text-align:center;font-size:25px;">Nhập kho sản phẩm</td>
  </tr>
<tr>
<td>Tên sản phẩm</td>
<td>Hình ảnh</td>
<td>Giá nhập</td>
<td>Số lượng</td>
<td>Tên nhà phân phối</td>
<td>Thành tiền</td>
</tr>
  <?php
  $count=count($_SESSION['sanphamnhap']);
      for($i=0;$i<$count;$i++){
        $id=$_SESSION['sanphamnhap'][$i]['id'];
      $tien=$_SESSION['sanphamnhap'][$i]['thanhtien'];
      $npp=$_SESSION['sanphamnhap'][$i]['manpp'];
	$sql = "select * from sanpham where masp='$id' ";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
echo'
  <tr>
    <td> '.$dong["TenSP"].' </td>
    <td><center><img src="modules/quanlysanpham/uploads/'.$dong['HinhAnh'].'" width="80" height="80"></center></td>
    <td><center>'. number_format($dong['GiaNhap']).' VND</center></td>
    <td><center>'.$_SESSION['sanphamnhap'][$i]['soluong'].'</center></td>';
      $sql_hieusp = "select * from nhaphanphoi where manpp='".$npp."'";
  $row_hieusp=$conn->query($sql_hieusp);
    $dong=$row_hieusp->fetch_array();
    echo'<td><center>'.$dong['TenNPP'].'</center></td>
          <td><center>'.number_format($tien).' VND</center></td>
    ';

  echo' </tr>';
 }?>
  
   
  <tr>
    <td colspan="6"><div align="center">
      <button type="submit" name="nhap" class="btn btn-primary" >Nhập kho</button>
    </div></td>
  </tr>
</table>
</form>


