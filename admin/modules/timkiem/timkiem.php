
<?php
	if(isset($_POST['timkiem'])){
	$search=$_POST['masp'];
	echo 'Mã tìm kiếm :<strong>'.' '.$search.'</strong><br/>';
	$sql_timkiem="select * from sanpham,thuonghieu,loaisp where sanpham.maloaisp=loaisp.maloaisp and sanpham.mathuonghieu=thuonghieu.mathuonghieu and  tenviettat='".$search."'";
	$row_timkiem=$conn->query($sql_timkiem);
	$count=$row_timkiem->num_rows;
	if($count>0){
	
?>
<h3>Kết quả tìm kiếm</h3>

<table width="100%" border="1">
  <tr>
    <td>ID</td>
    <td>Tên sản phẩm</td>
    <td>Mã sp</td>
    <td>Hình ảnh</td>
    <td>Giá nhập</td>
    <td>Giá bán</td>
    <td>Số lượng tồn</td>
    <td>Loại hàng</td>
    <td>Thương hiệu</td>
    <td colspan="2">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_timkiem->fetch_array()){

  ?>
  <tr>
    <td><?php  echo $i;?></td>
    <td><?php echo $dong['TenSP'] ?></td>
    <td><?php echo $dong['MaSP'] ?></td>
    <td><img src="modules/quanlysanpham/uploads/<?php echo $dong['HinhAnh'] ?>" width="80" height="80" /></td>
    <td><?php echo number_format($dong['GiaNhap']) ?></td>
    <td><?php echo number_format($dong['GiaBan']) ?></td>
    <td><?php echo $dong['SLTon'] ?></td>
    <td><?php echo $dong['TenLoaiSP'] ?></td>
    <td><?php echo $dong['TenThuongHieu'] ?></td>    
  <td><a href="index.php?quanly=sanpham&ac=sua&id=<?php echo $dong['MaSP'] ?>" ><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlysanpham/xuly.php?id=<?php echo $dong['MaSP']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
  </tr>
  <?php
  $i++;
  }
	}else{
	  echo 'Không tìm thấy kết quả';
  }
  }
  ?>
</table>
