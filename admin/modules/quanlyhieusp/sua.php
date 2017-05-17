<?php
	$sql = "select * from thuonghieu where mathuonghieu = '$_GET[id]'";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
?>
<div class="button_themsp">
<a href="index.php?quanly=hieusp&ac=lietke">Liệt kê sp</a> 
</div>
<form action="modules/quanlyhieusp/xuly.php?id=<?php echo $dong['MaThuongHieu']?>" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="200" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Sửa hiệu sản phẩm</td>
  </tr>
  <tr>
    <td width="97">Tên hieu sp</td>
    <td width="87"><input type="text" name="hieusp" value="<?php echo $dong['TenThuongHieu'] ?>"></td>
  </tr>
  <tr>
    <td width="97">Xuất xứ</td>
    <td width="87"><input type="text" name="XuatXu" value="<?php echo $dong['XuatXu'] ?>"></td>
  </tr>
  <tr>
    <td width="97">Ghi chú</td>
    <td width="87"><input type="text" name="GhiChu" value="<?php echo $dong['GhiChu'] ?>"></td>
  </tr>
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="sua" value="Sửa">
    </div></td>
  </tr>
</table>
</form>


