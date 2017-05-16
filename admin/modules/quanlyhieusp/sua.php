<?php
	$sql = "select * from hieusp where idhieusp = '$_GET[id]'";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
?>
<div class="button_themsp">
<a href="index.php?quanly=hieusp&ac=lietke">Liệt kê sp</a> 
</div>
<form action="modules/quanlyhieusp/xuly.php?id=<?php echo $dong['idhieusp']?>" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="200" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Sửa hiệu sản phẩm</td>
  </tr>
  <tr>
    <td width="97">Tên loại sp</td>
    <td width="87"><input type="text" name="hieusp" value="<?php echo $dong['tenhieusp'] ?>"></td>
  </tr>
  <tr>
    <td>Tình trạng</td>
    <td><select name="tinhtrang">
      <?php
	if($dong['tinhtrang'] == 1){
	?>
      <option value="1" selected="selected">Kích hoạt</option>
      <option value="2">Không kích hoạt</option>
      <?php
	}else{
	?>
      <option value="1">Kích hoạt</option>
      <option value="2" selected="selected">Không kích hoạt</option>
      <?php
	}
	 ?>
      </select></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="sua" value="Sửa">
    </div></td>
  </tr>
</table>
</form>


