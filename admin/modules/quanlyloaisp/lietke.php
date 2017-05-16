<?php
	$sql_lietkesp="select * from loaisp order by idloaisp desc ";
	$row_lietkesp=$conn->query($sql_lietkesp);

?>
<div class="button_themsp">
<a href="index.php?quanly=loaisp&ac=them">Thêm Mới</a> 
</div>

<table width="100%" border="1">
  <tr>
    <td>ID</td>
    <td>Tên loại sản phẩm</td>
    <td>Tình trạng</td>
    <td colspan="2">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_lietkesp->fetch_array()){

  ?>
  <tr>
    <td><?php  echo $i;?></td>
    <td><?php echo $dong['tenloaisp'] ?></td>
    <td><?php
	if($dong['tinhtrang'] == 1 ){
		echo 'Kích hoạt';
	}else{
		echo 'Không kích hoạt';
	}
    ?></td>
    <td><a href="index.php?quanly=loaisp&ac=sua&id=<?php echo $dong['idloaisp'] ?>"><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlyloaisp/xuly.php?id=<?php echo $dong['idloaisp']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30" /></center></a></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
