
<?php
include('config.php');
	$sql = 'select * from hoadon where mahd='$_GET[id]' ';
	$row=$conn->query($sql);
	$dong1=$row->fetch_array();
 ?>

<form action='xuly.php?id=<?php echo $dong1['MaHD']; ?>' method='post' enctype='multipart/form-data'>

<table width='600' border='1'>
  <tr>
    <td colspan='2' style='text-align:center;font-size:25px;'>Sửa hóa đơn</td>
  </tr>
  <tr>
    <td width='97'>MaVC</td>
    <td width='87'><input type='text' name='mavc' value='<?php echo $dong1['MaVC'] ?>'></td>
  </tr>
  <tr>
    <td>MaTT</td>
    <td><input type='text' name='matt' value='<?php echo $dong1['MaTT'] ?>'></td>
  </tr>
  <tr>
    <td>Ngày lập</td>
    <td><input type='text' name='ngaylap' value='<?php echo $dong1['NgayLap'] ?>' ></td>
  </tr>
  <tr>
    <td>Tổng tiền</td>
    <td><input type='text' name='tongtien' value='<?php echo $dong1['TongTien'] ?>'></td>
  </tr>
  <tr>
    <td>Địa chỉ</td>
    <td><input type='text' name='diachi' value='<?php echo $dong1['DiaChi'] ?>'></td>
  </tr>  
  <tr>
    <td>Tình trạng</td>
    <td><input type='text' name='tinhtrang' value='<?php echo $dong1['TinhTrang'] ?>'></td>
  </tr>
  <tr>
    <td>Ghi chú</td>
    <td><textarea name='ghichu' cols='40' rows='10'><?php echo $dong1['GhiChu'] ?></textarea></td>
  </tr>
  
  </tr>  
  <tr>
    <td colspan='2'><div align='center'>
      <input type='submit' name='sua' value='Sửa hóa đơn'>
    </div></td>
  </tr>
</table>
</form>



































