
<form action="xulykigui.php" method="post" enctype="multipart/form-data">
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
    <td>Giá sản phâm</td>
    <td><input type="text" name="gia"></td>
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
    <td colspan="2"><div align="center">
      <input type="submit" name="them" value="Thêm sản phẩm">
    </div></td>
  </tr>
</table>
</form>