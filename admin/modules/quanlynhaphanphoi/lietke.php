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
	$sql_lietke=" select * from nhaphanphoi,thuonghieu where nhaphanphoi.mathuonghieu=thuonghieu.mathuonghieu order by manpp desc limit $trang1,10 ";
	$row_lietke=$conn->query($sql_lietke);
$i=0;
?>

<div class="button_themsp">
<a href="index.php?quanly=nhaphanphoi&ac=them">Thêm Mới</a> 
</div>

<table width="100%" border="1">
  <tr>
    <td>STT</td>
    <td>Tên nhà phân phối</td>
    <td>Tên thương hiệu</td>
    <td>Công nợ</td>
    <td>Địa chỉ</td>
    <td colspan="2">Quản lý</td>
  </tr>
  <?php

  while($dong=$row_lietke->fetch_array()){
$i++;
  ?>
  <tr>
  	
    
    <td><?php echo $i ?></td>
    <td><?php echo $dong['TenNPP'] ?></td>
    <td><?php echo $dong['TenThuongHieu'] ?></td>     
    <td><?php echo $dong['CongNo'] ?></td>
    <td><?php echo $dong['DiaChi'] ?></td>
       
    <td><a href="index.php?quanly=nhaphanphoi&ac=sua&id=<?php echo $dong['MaNPP'] ?>" ><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlynhaphanphoi/xuly.php?id=<?php echo $dong['MaNPP']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
  </tr>
  <?php

  }
  ?>
</table>
<div class="trang">
	Trang :
    <?php
	$sql_trang=$conn->query("select * from nhaphanphoi");
	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=nhaphanphoi&ac=lietke&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=nhaphanphoi&ac=lietke&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>
</div>