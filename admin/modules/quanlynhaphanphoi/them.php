

<div class="button_themsp">
<a href="index.php?quanly=nhaphanphoi&ac=lietke">Liệt kê NPP</a> 
</div>
<form action="modules/quanlynhaphanphoi/xuly.php" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="600" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Thêm NPP</td>
  </tr>
  <tr>
    <td width="97">Tên nhà phân phối</td>
    <td width="87"><input type="text" name="TenNPP" ></td>
  </tr>
  
  
  <tr>
    <td>Công nợ</td>
    <td><input type="text" name="CongNo" ></td>
  </tr>  
  <tr>
      <?php
  $sql_hieusp = "select * from thuonghieu";
  $row_hieusp=$conn->query($sql_hieusp);
  ?>
    <td>Tên thương hiệu</td>
    <td><select name="MaThuongHieu">
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
    <td>Địa chỉ</td>
    <td><input type="text" name="DiaChi" ></td>
  </tr>  
  
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="them" value="Thêm sản phẩm">
    </div></td>
  </tr>
</table>
</form>


