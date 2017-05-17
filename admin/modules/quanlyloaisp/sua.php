<?php
	$sql = "select * from loaisp where MaLoaiSP = '$_GET[id]'";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
?>
<div class="button_themsp">
<a href="index.php?quanly=loaisp&ac=lietke">Liệt kê sp</a> 
</div>
<form action="modules/quanlyloaisp/xuly.php?id=<?php echo $dong['MaLoaiSP']?>" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="200" border="1">
  <tr>
    <td colspan="2" style="text-align:center; font-size:25px">Sửa loại sản phẩm</td>
  </tr>
  <tr>
    <td width="97">Tên loại sp</td>
    <td width="87"><input type="text" name="loaisp" value="<?php echo $dong['TenLoaiSP'] ?>"></td>
  </tr>
  <tr>
    <td width="97">Ghi chú</td>
    <td width="87"><input type="text" name="ghichu" value="<?php echo $dong['GhiChu'] ?>"></td>
  </tr> 
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="sua" value="Sửa">
    </div></td>
  </tr>
</table>
</form>


