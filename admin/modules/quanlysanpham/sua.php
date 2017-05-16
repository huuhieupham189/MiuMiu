
<?php
	$sql = "select * from sanpham where idsanpham='$_GET[id]' ";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
 ?>
<div class="button_themsp">
<a href="index.php?quanly=sanpham&ac=lietke">Liệt kê sp</a> 
</div>
<form action="modules/quanlysanpham/xuly.php?id=<?php echo $dong['idsanpham'] ?>" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="600" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Sửa sản phẩm</td>
  </tr>
  <tr>
    <td width="97">Tên sản phẫm</td>
    <td width="87"><input type="text" name="tensp" value="<?php echo $dong['tensp'] ?>"></td>
  </tr>
  <tr>
    <td>Mã SP</td>
    <td><input type="text" name="masp" value="<?php echo $dong['masp'] ?>"></td>
  </tr>
  <tr>
    <td>Hình ảnh</td>
    <td><input type="file" name="hinhanh" /><img src="modules/quanlysanpham/uploads/<?php echo $dong['hinhanh'] ?>" width="80" height="80"></td>
  </tr>
  <tr>
    <td>Giá đề xuất</td>
    <td><input type="text" name="giadexuat" value="<?php echo $dong['giadexuat'] ?>"></td>
  </tr>
  <tr>
    <td>Giá giảm</td>
    <td><input type="text" name="giagiam" value="<?php echo $dong['giagiam'] ?>"></td>
  </tr>
  <tr>
    <td>Nội dung</td>
    <td><textarea name="noidung" cols="40" rows="10"><?php echo $dong['noidung'] ?></textarea></td>
  </tr>
  <tr>
    <td>Số lượng</td>
    <td><input type="text" name="soluong" value="<?php echo $dong['soluong'] ?>"></td>
  </tr>
  <tr>
  <?php
  $sql_loaisp = "select * from loaisp";
  $row_loaisp=$conn->query($sql_loaisp);
  ?>
    <td>Loại sản phẩm</td>
    <td><select name="loaisp">
     <?php
	while($dong_loaisp=$row_loaisp->fetch_array()){
		if($dong['loaisp']==$dong_loaisp['idloaisp']){
	?>
    	<option selected="selected" value="<?php echo $dong_loaisp['idloaisp'] ?>"><?php echo $dong_loaisp['tenloaisp'] ?></option>
        <?php
	}else{
		?>
       <option value="<?php echo $dong_loaisp['idloaisp'] ?>"><?php echo $dong_loaisp['tenloaisp'] ?></option>
        <?php
	}
	}
		?>
    </select></td>
  </tr>
  <tr>
      <?php
  $sql_hieusp = "select * from hieusp";
  $row_hieusp=$conn->query($sql_hieusp);
  ?>
    <td>Tên nhà sx</td>
    <td><select name="nhasx">
    <?php
	while($dong_hieusp=$row_hieusp->fetch_array()){
		if($dong['nhasx']==$dong_hieusp['idhieusp']){
	?>
    	<option selected="selected" value="<?php echo $dong_hieusp['idhieusp'] ?>"><?php echo $dong_hieusp['tenhieusp'] ?></option>
        <?php
	}else{
		?>
        <option value="<?php echo $dong_hieusp['idhieusp'] ?>"><?php echo $dong_hieusp['tenhieusp'] ?></option>
        <?php
	}
	}
		?>
    </select></td>
  </tr>
  <tr>
    <td>Tình trạng</td>
    <td><select name="tinhtrang">
   
    <option value="1">Kích hoạt</option>
     <option value="2">Không kích hoạt</option>
    </select></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="sua" value="Sửa sản phẩm">
    </div></td>
  </tr>
</table>
</form>


