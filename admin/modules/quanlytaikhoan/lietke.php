<?php
	if(isset($_GET['trang'])){
		$trang=$_GET['trang'];
	}else{
		$trang='';
	}
	if($trang =='' || $trang =='1'){
		$trang1=0;
	}else{
		$trang1=($trang*10)-10;
	}
	$sql_lietkesp=" select * from taikhoan,loaitk where taikhoan.loaitk=loaitk.maloaitk and loaitk>=6 order by matk desc limit $trang1,10";
	$row_lietkesp=$conn->query($sql_lietkesp);

?>

<div class="button_themsp">
<a href="index.php?quanly=nhansu&ac=them">Thêm Mới</a> 
</div>

<table width="100%" border="1">
  <tr>
    <td>STT</td>
    <td>Tên đăng nhập</td>
    <td>Mật khẩu</td>
    <td>Loại tài khoản</td>
    <td>Email</td>
    <td>Họ tên</td>
    <td>Số điện thoại</td>
    <td>Địa chỉ</td>
    <td>Ngày Sinh</td>
    <td>CMND</td>
    <td colspan="2">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_lietkesp->fetch_array()){

  ?>
  <tr>
  	
    
    <td><?php echo $i ?></td>
    <td><?php echo $dong['TenDangNhap'] ?></td>
    <td><?php echo $dong['MatKhau'] ?></td>
    <td><?php echo $dong['TenLoaiTK'] ?></td>
    <td><?php echo $dong['Email'] ?></td>
    <td><?php echo $dong['HoTen'] ?></td> 
    <td><?php echo $dong['SDT'] ?></td>     
    <td><?php echo $dong['DiaChi'] ?></td> 
    <td><?php echo $dong['NgaySinh'] ?></td>     
    <td><?php echo $dong['CMND'] ?></td>      
    <td><a href="index.php?quanly=nhansu&ac=sua&id=<?php echo $dong['MaTK'] ?>" ><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlytaikhoan/xuly.php?id=<?php echo $dong['MaTK']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<div class="trang">
	Trang :
    <?php
	$sql_trang=$conn->query("select * from taikhoan where loaitk>=6");
	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=nhansu&ac=lietke&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=nhansu&ac=lietke&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>
</div>
