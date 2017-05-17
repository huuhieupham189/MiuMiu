
<div class="button_themsp">
<a href="index.php?quanly=sanpham&ac=lietke">Liệt kê sp</a> 
</div>
<form action="modules/quanlysanpham/xuly.php" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="600" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Thêm  sản phẩm</td>
  </tr>
  <tr>
    <td width="97">Tên sản phẫm</td>
    <td width="87"><input type="text" name="tensp"></td>
  </tr>
  <tr>
    <td>Tên viết tắt</td>
    <td><input type="text" name="tenviettat"></td>
  </tr>
  <tr>
    <td>Hình ảnh</td>
    <td><input type="file" name="hinhanh" /></td>
  </tr>
  <tr>
    <td>Giá đề xuất</td>
    <td><input type="text" name="gianhap"></td>
  </tr>
  <tr>
    <td>Giá giảm</td>
    <td><input type="text" name="giaban"></td>
  </tr>
  <tr>
    <td>Thông tin chi tiết</td>
    <td><textarea name="ttct" cols="40" rows="10"></textarea></td>
  </tr>
  <tr>
    <td>Số lượng</td>
    <td><input type="text" name="slton"></td>
  </tr>
  <tr>
  <?php
  $sql_loaisp = "select maloaisp,tenloaisp from loaisp";
  $row_loaisp=$conn->query($sql_loaisp);
  ?>
    <td>Loại sản phẩm</td>
    <td><select name="maloaisp">
    <?php
	while($dong_loaisp=$row_loaisp->fetch_array()){
	?>
    	<option value="<?php echo $dong_loaisp['maloaisp'] ?>"><?php echo $dong_loaisp['tenloaisp'] ?></option>
        <?php
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
	?>
    	<option value="<?php echo $dong_hieusp['MaThuongHieu'] ?>"><?php echo $dong_hieusp['TenThuongHieu'] ?></option>
        <?php
	}
		?>
    </select></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="them" value="Thêm sản phẩm">
    </div></td>
  </tr>
</table>
</form>


