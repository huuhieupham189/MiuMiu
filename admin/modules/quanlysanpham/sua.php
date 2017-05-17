
<?php
	$sql = "select * from sanpham where masp='$_GET[id]' ";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
 ?>
<div class="button_themsp">
<a href="index.php?quanly=sanpham&ac=lietke">Liệt kê sp</a> 
</div>
<form action="modules/quanlysanpham/xuly.php?id=<?php echo $dong['MaSP'] ?>" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="600" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Sửa sản phẩm</td>
  </tr>
  <tr>
    <td width="97">Tên sản phẫm</td>
    <td width="87"><input type="text" name="tensp" value="<?php echo $dong['TenSP'] ?>"></td>
  </tr>
  <tr>
    <td>Tên viết tắt</td>
    <td><input type="text" name="tenviettat" value="<?php echo $dong['TenVietTat'] ?>"></td>
  </tr>
  <tr>
    <td>Hình ảnh</td>
    <td><input type="file" name="hinhanh" /><img src="modules/quanlysanpham/uploads/<?php echo $dong['HinhAnh'] ?>" width="80" height="80"></td>
  </tr>
  <tr>
    <td>Giá Nhập</td>
    <td><input type="text" name="gianhap" value="<?php echo $dong['GiaNhap'] ?>"></td>
  </tr>
  <tr>
    <td>Giá Bán</td>
    <td><input type="text" name="giaban" value="<?php echo $dong['GiaBan'] ?>"></td>
  </tr>
  <tr>
    <td>Thông tin chi tiết</td>
    <td><textarea name="ttct" cols="40" rows="10"><?php echo $dong['TTCT'] ?></textarea></td>
  </tr>
  <tr>
    <td>Số lượng</td>
    <td><input type="text" name="slton" value="<?php echo $dong['SLTon'] ?>"></td>
  </tr>
  <tr>
  <?php
  $sql_loaisp = "select * from loaisp";
  $row_loaisp=$conn->query($sql_loaisp);
  ?>
    <td>Loại sản phẩm</td>
    <td><select name="maloaisp">
     <?php
	while($dong_loaisp=$row_loaisp->fetch_array()){
		if($dong['MaLoaiSP']==$dong_loaisp['MaLoaiSP']){
	?>
    	<option selected="selected" value="<?php echo $dong_loaisp['MaLoaiSP'] ?>"><?php echo $dong_loaisp['TenLoaiSP'] ?></option>
        <?php
	}else{
		?>
       <option value="<?php echo $dong_loaisp['MaLoaiSP'] ?>"><?php echo $dong_loaisp['TenLoaiSP'] ?></option>
        <?php
	}
	}
		?>
    </select></td>
  </tr>
  <tr>
      <?php
  $sql_hieusp = "select * from thuonghieu";
  $row_hieusp=$conn->query($sql_hieusp);
  ?>
    <td>Tên nhà sx</td>
    <td><select name="mathuonghieu">
    <?php
	while($dong_hieusp=$row_hieusp->fetch_array()){
		if($dong['MaThuongHieu']==$dong_hieusp['MaThuongHieu']){
	?>
    	<option selected="selected" value="<?php echo $dong_hieusp['MaThuongHieu'] ?>"><?php echo $dong_hieusp['TenThuongHieu'] ?></option>
        <?php
	}else{
		?>
        <option value="<?php echo $dong_hieusp['MaThuongHieu'] ?>"><?php echo $dong_hieusp['TenThuongHieu'] ?></option>
        <?php
	}
	}
		?>
    </select></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="sua" value="Sửa sản phẩm">
    </div></td>
  </tr>
</table>
</form>


