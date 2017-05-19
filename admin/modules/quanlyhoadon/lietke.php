<?php
	if(isset($_GET['trang'])){
		$trang=$_GET['trang'];
	}else{
		$trang='';
	}
	if($trang =='' || $trang =='1'){
		$trang1=0;
	}else{
		$trang1=($trang*5)-5;
	}
	$sql_lietkehd="select * from hoadon limit $trang1,5";
	$row_lietkehd=$conn->query($sql_lietkehd);

?>
<table width="100%" border="1">
  <tr>
    <td>STT</td>
    <td>MaVC</td>
    <td>MaTT</td>
    <td>MaTK</td>
    <td>Ngày lập</td>
    <td>Tổng tiền</td>
    <td>Địa chỉ</td>
    <td>Tình trạng</td>
    <td>Ghi chú</td>
    <td colspan="3">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_lietkehd->fetch_array()){

  ?>
  <tr>
  	
    <td><?php  echo $i;?></td>
    <td><?php echo $dong['MaVC'] ?></td>
    <td><?php echo $dong['MaTT'] ?></td>
    <td><?php echo $dong['MaTK']?></td>
    <td><?php echo $dong['NgayLap']?></td>
    <td><?php echo number_format($dong['TongTien']) ?></td>
    <td><?php echo $dong['DiaChi'] ?></td>
    <td><?php echo $dong['TinhTrang'] ?></td>
    <td><?php echo $dong['GhiChu'] ?></td>  
    <td><a href="index.php?quanly=hoadon&ac=sua&id=<?php echo $dong['MaHD'] ?>" ><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="index.php?quanlyhoadon/xuly.php?id=<?php echo $dong['MaHD'] ?>" ><center><img src="imgs/confirm.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlyhoadon/xuly.php?id=<?php echo $dong['MaHD']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
  </tr>
  <?php
  $i++;
  }
  ?>
  </table>