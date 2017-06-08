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
	$sql_lietkesp="select distinct sp.masp,TenSP,HinhAnh,NgayBD,NgayKT,TiSo,MaKM from khuyenmai km,sanpham sp where km.masp=sp.masp limit $trang1,10";
	$row_lietkesp=$conn->query($sql_lietkesp);

?>


<div class="button_themsp">
<a href="index.php?quanly=khuyenmai&ac=tao">Tạo KM</a> 
</div>
<div>

<table  border="1">
  <tr>
    <td>STT</td>
    <td>Tên sản phẩm</td>    
    <td>Hình ảnh</td>
    <td>Ngày bắt đầu khuyến mãi</td>
    <td>Ngày kết thúc khuyến mãi</td>
    <td>Phần trăm khuyến mãi</td>
    <td colspan="1">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_lietkesp->fetch_array()){

  ?>
  <tr>
  	
    <td><?php  echo $i;?></td>
    <td><?php echo $dong['TenSP'] ?></td>
   
    <td><img src="modules/quanlysanpham/uploads/<?php echo $dong['HinhAnh'] ?>" width="80" height="80" />
    
    </td>
    <td><?php echo $dong['NgayBD'] ?></td>
    <td><?php echo $dong['NgayKT'] ?></td>
    <td><?php echo $dong['TiSo']*100 ?>%</td>
      
    <td><a href="modules/quanlykhuyenmai/xuly.php?id=<?php echo $dong['MaKM']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
    
  </tr>
 

  <?php
  $i++;
  }
  ?>
</table>
<div class="trang">
	Trang :
    <?php
	$sql_trang=$conn->query("select distinct sp.masp,TenSP,hinhanh,ngaybd,ngaykt,tiso,makm from khuyenmai km,sanpham sp where km.masp=sp.masp");
	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=khuyenmai&ac=lietke&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=khuyenmai&ac=lietke&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>