

<div class="button_themsp">
<a href="index.php?quanly=nhansu&ac=lietke">Liệt kê</a> 
</div>
<form action="modules/quanlytaikhoan/xuly.php" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="600" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Thêm Tài Khoản</td>
  </tr>
  <tr>
    <td width="97">Tên tài khoản</td>
    <td width="87"><input type="text" name="tentk" ></td>
  </tr>
  <tr>
    <td>Mật Khẩu</td>
    <td><input type="text" name="matkhau"></td>
  </tr>
  <tr>
    <tr>
  <?php
  $sql_loaitk = "select * from loaitk where maloaitk>=6";
  $row_loaitk=$conn->query($sql_loaitk);
  ?>
    <td>Loại tài khoản</td>
    <td><select name="maloaitk">
     <?php
	while($dong_loaitk=$row_loaitk->fetch_array()){
		
	?>
    	
       <option value="<?php echo $dong_loaitk['MaLoaiTK'] ?>"><?php echo $dong_loaitk['TenLoaiTK'] ?></option>
        <?php
	}
	
		?>
    </select></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="email" ></td>
  </tr>
  <tr>
    <td>Họ Tên</td>
    <td><input type="text" name="hoten" ></td>
  </tr>
  <tr>
    <td>Địa chỉ</td>
    <td><input type="text" name="diachi"></td>
  </tr>
  <tr>
    <td>Ngày Sinh</td>
    <td><input type="text" name="ngaysinh" ></td>
  </tr>
  <tr>
    <td>SĐT</td>
    <td><input type="text" name="sdt" ></td>
  </tr>
  <tr>
    <td>CMND</td>
    <td><input type="text" name="cmnd" ></td>
  </tr>

  
  
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="them" value="Thêm tài khoản">
    </div></td>
  </tr>
</table>
</form>


