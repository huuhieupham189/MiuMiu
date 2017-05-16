<?php
	$sql_lietkesp="select * from hieusp order by idhieusp desc ";
	$row_lietkesp=$conn->query($sql_lietkesp);

?>
<div class="button_themsp">
<a href="index.php?quanly=hieusp&ac=them">Thêm Mới</a> 
</div>

<table width="100%" border="1">
  <tr>
    <td>ID</td>
    <td>Tên hiệu sản phẩm</td>
    <td>Tình trạng</td>
    <td colspan="2">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_lietkesp->fetch_array()){

  ?>
  <tr>
    <td><?php  echo $i;?></td>
    <td><?php echo $dong['tenhieusp'] ?></td>
    <td><?php
	if($dong['tinhtrang'] == 1 ){
		echo 'Kích hoạt';
	}else{
		echo 'Không kích hoạt';
	}
    ?></td>
    <td><a href="index.php?quanly=hieusp&ac=sua&id=<?php echo $dong['idhieusp'] ?>"><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlyhieusp/xuly.php?id=<?php echo $dong['idhieusp']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30" /></center></a></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
