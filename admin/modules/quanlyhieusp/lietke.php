<?php
	$sql_lietkesp="select * from thuonghieu order by MaThuongHieu desc ";
	$row_lietkesp=$conn->query($sql_lietkesp);

?>
<div class="button_themsp">
<a href="index.php?quanly=hieusp&ac=them">Thêm Mới</a> 
</div>

<table width="100%" border="1">
  <tr>
    <td>ID</td>
    <td>Tên hiệu sản phẩm</td>
    <td>Xuất xứ</td>
    <td>Ghi chú</td>
    <td colspan="2">Quản lý</td>
  </tr>
  <?php
  $i=1;
  while($dong=$row_lietkesp->fetch_array()){

  ?>
  <tr>
    <td><?php  echo $i;?></td>
    <td><?php echo $dong['TenThuongHieu'] ?></td>
    <td><?php echo $dong['XuatXu'] ?></td>
    <td><?php echo $dong['GhiChu'] ?></td>
    <td><a href="index.php?quanly=hieusp&ac=sua&id=<?php echo $dong['MaThuongHieu'] ?>"><center><img src="imgs/edit.png" width="30" height="30" /></center></a></td>
    <td><a href="modules/quanlyhieusp/xuly.php?id=<?php echo $dong['MaThuongHieu']?>" class="delete_link"><center><img src="imgs/delete.png" width="30" height="30" /></center></a></td>
  </tr>
  <?php
  $i++;
  }
  ?>
</table>
