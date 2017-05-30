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
	$sql_lietkesp=" select TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP,sum(cthd.SoLuong) as soluong
from sanpham left join cthd on sanpham.MaSP=cthd.MaSP ,thuonghieu,loaisp
where loaisp.maloaisp=sanpham.maloaisp and thuonghieu.mathuonghieu=sanpham.mathuonghieu 
GROUP by TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP
order by soluong DESC limit $trang1,10";
	$row_lietkesp=$conn->query($sql_lietkesp);

?>

<div class="button_themsp">
<a href="index.php?quanly=sanpham&ac=them">Thêm Mới</a> 
<div>


<table  border="1">
  <tr>
    <td>STT</td>
    <td>Tên sản phẩm</td>    
    <td>Hình ảnh</td>
    <td>Giá nhập</td>
    <td>Giá bán</td>
    <td>Số lượng tồn</td>
    <td>Loại hàng</td>
    <td>Thương hiệu</td>
    <td colspan="2">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_lietkesp->fetch_array()){

  ?>
  <tr>
  	
    <td><?php  echo $i;?></td>
    <td><?php echo $dong['TenSP'] ?></td>
   
    <td><img src="modules/quanlysanpham/uploads/<?php echo $dong['HinhAnh'] ?>" width="80" height="80" />
    <a href="index.php?quanly=gallery&ac=lietke&id=<?php echo $dong['MaSP'] ?>" style="text-align:center;text-decoration:none; font-size:18px;color:#06F;">Gallery</a>
    </td>
    <td><?php echo number_format($dong['GiaNhap']) ?></td>
    <td><?php echo number_format($dong['GiaBan']) ?></td>
    <td><?php echo $dong['SLTon'] ?></td>
    <td><?php echo $dong['TenLoaiSP'] ?></td>
    <td><?php echo $dong['TenThuongHieu'] ?></td>    
    <td><a href="index.php?quanly=sanpham&ac=sua&id=<?php echo $dong['MaSP'] ?>" ><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlysanpham/xuly.php?id=<?php echo $dong['MaSP']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
<div class="trang">
	Trang :
    <?php
	$sql_trang=$conn->query("select * from sanpham");
	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=sanpham&ac=lietke&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=sanpham&ac=lietke&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>
</div></div>