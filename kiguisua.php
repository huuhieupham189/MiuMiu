
<?php
	$sql = "select * from sanpham where masp='$_GET[id]' ";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
 ?>

<form action="xulykigui.php?id=<?php echo $dong['MaSP'] ?>" method="post" enctype="multipart/form-data">
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
    <td><input type="file" name="hinhanh" /><img src="admin/modules/quanlysanpham/uploads/<?php echo $dong['HinhAnh'] ?>" width="80" height="80"></td>
  </tr>
  <tr>
    <td>Giá Nhập</td>
    <td><input type="text" name="gia" value="<?php echo $dong['GiaNhap'] ?>"></td>
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
    <td colspan="2"><div align="center">
      <input type="submit" name="sua" value="Sửa sản phẩm">
    </div></td>
  </tr>
</table>
</form>


