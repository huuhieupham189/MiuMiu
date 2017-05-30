
<?php
	$sql = "select * from taikhoan where matk='$_GET[id]' ";
	$row=$conn->query($sql);
	$dong=$row->fetch_array();
 ?>
<div class="button_themsp">
<a href="index.php?quanly=nhansu&ac=lietke">Liệt kê</a> 
</div>
<form action="modules/quanlytaikhoan/xuly.php?id=<?php echo $dong['MaTK'] ?>" method="post" enctype="multipart/form-data">
<h3>&nbsp;</h3>
<table width="600" border="1">
  <tr>
    <td colspan="2" style="text-align:center;font-size:25px;">Sửa Tài Khoản</td>
  </tr>
  <tr>
    <td width="97">Tên tài khoản</td>
    <td width="87"><input type="text" name="tentk" value="<?php echo $dong['TenDangNhap'] ?>"></td>
  </tr>
  <tr>
    <td>Mật Khẩu</td>
    <td><input type="text" name="matkhau" value="<?php echo $dong['MatKhau'] ?>"></td>
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
		if($dong['LoaiTK']==$dong_loaitk['MaLoaiTK']){
	?>
    	<option selected="selected" value="<?php echo $dong_loaitk['MaLoaiTK'] ?>"><?php echo $dong_loaitk['TenLoaiTK'] ?></option>
        <?php
	}else{
		?>
       <option value="<?php echo $dong_loaitk['MaLoaiTK'] ?>"><?php echo $dong_loaitk['TenLoaiTK'] ?></option>
        <?php
	}
	}
		?>
    </select></td>
  </tr>
  <tr>
    <td>Email</td>
    <td><input type="text" name="email" value="<?php echo $dong['Email'] ?>"></td>
  </tr>
  <tr>
    <td>Họ Tên</td>
    <td><input type="text" name="hoten" value="<?php echo $dong['HoTen'] ?>"></td>
  </tr>
  <tr>
    <td>Địa chỉ</td>
    <td><input type="text" name="diachi" value="<?php echo $dong['DiaChi'] ?>"></td>
  </tr>
  <tr>
    <td>Ngày Sinh</td>
    <td><input type="text" name="ngaysinh" value="<?php echo $dong['NgaySinh'] ?>"></td>
  </tr>
  <tr>
    <td>SĐT</td>
    <td><input type="text" name="sdt" value="<?php echo $dong['SDT'] ?>"></td>
  </tr>
  <tr>
    <td>CMND</td>
    <td><input type="text" name="cmnd" value="<?php echo $dong['CMND'] ?>"></td>
  </tr>

  
  
  <tr>
    <td colspan="2"><div align="center">
      <input type="submit" name="sua" value="Sửa tài khoản">
    </div></td>
  </tr>
</table>
</form>


