	<?php
    include("../config.php");
    ?>
    <div class="col-sm-9">
          
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#QLDH" data-toggle="tab">Khuyến mãi loại sản phẩm</a></li>
            <li><a href="#settings" data-toggle="tab">Khuyến mãi theo thương hiệu </a></li>
            <li><a href="#b" data-toggle="tab">Khuyến mãi sản phẩm </a></li>
          </ul>
          <div class="tab-content">
           <div class="tab-pane active" id="QLDH">
            <form method="post" action="modules/quanlykhuyenmai/xuly.php">
    <table>
            <tr>
  <?php
  $sql_loaisp = "select maloaisp,tenloaisp from loaisp";
  $row_loaisp=$conn->query($sql_loaisp);
  ?>
   
    <td>Loại sản phẩm</td>
    <td><select name="maloaisp">
    <?php
	while($dong_loaisp=$row_loaisp->fetch_array()){
	?>
    	<option value="<?php echo $dong_loaisp['maloaisp'] ?>"><?php echo $dong_loaisp['tenloaisp'] ?></option>
        <?php
	}
		?>
    </select></td>
  </tr>
  <tr>
    <td>Tên khuyến mãi</td>
    <td><input type="text" name="tenkm"></td>
  </tr>
  <tr>
    <td>Tỉ lệ khuyến mãi</td>
    <td><input type="number" step="0.1" name="khuyenmai"min=0 max=1></td>
  </tr>
<tr>
    <td>Ngày bắt đầu khuyến mãi</td>
    <td><input type="text" name="ngaybatdau" value="<?php echo date('d/m/Y'); ?>" disabled></td>
  </tr>
  <tr>
    <td>Ngày kết thúc khuyến mãi</td>
    <td><input type="date" name="ngayketthuc"></td>
  </tr>
  <tr>
    <td>Ghi chú</td>
    <td><input type="text" name="ghichu"></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center">
      <button class="btn btn-primary" type="submit" name="submit1"  >Tạo khuyến mãi</button>
    </div></td>
  </tr>
  </table>
  </form>
              </div>

              
               <div class="tab-pane" id="settings">
               <form method="post" action="modules/quanlykhuyenmai/xuly.php">
    <table>
            <tr>
      <?php
  $sql_hieusp = "select * from thuonghieu";
  $row_hieusp=$conn->query($sql_hieusp);
  ?>
    <td>Thương hiệu</td>
    <td><select name="mathuonghieu">
    <?php
	while($dong_hieusp=$row_hieusp->fetch_array()){
	?>
    	<option value="<?php echo $dong_hieusp['MaThuongHieu'] ?>"><?php echo $dong_hieusp['TenThuongHieu'] ?></option>
        <?php
	}
		?>
    </select></td>
  </tr>
   <tr>
    <td>Tên khuyến mãi</td>
    <td><input type="text" name="tenkm"></td>
  </tr>
  <tr>
    <td>Tỉ lệ khuyến mãi</td>
    <td><input type="number" step="0.1" name="khuyenmai"min=0 max=1></td>
  </tr>
<tr>
    <td>Ngày bắt đầu khuyến mãi</td>
    <td><input type="text" name="" value="<?php echo date('d/m/Y'); ?>" disabled></td>
  </tr>
  <tr>
    <td>Ngày kết thúc khuyến mãi</td>
    <td><input type="date" name="ngayketthuc"></td>
  </tr>
   <tr>
    <td>Ghi chú</td>
    <td><input type="text" name="ghichu"></td>
  </tr>
  
  <tr>
    <td colspan="2"><div align="center">
      <button class="btn btn-primary" type="submit" name="submit2"  >Tạo khuyến mãi</button>
    </div></td>
  </tr>
  </table>
  </form>
              </div>
              <div class="tab-pane" id="b">
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




<table  border="1">
  <tr>
    <td>STT</td>
    <td>Tên sản phẩm</td>    
    <td>Hình ảnh</td>
    <td>Số lượng tồn</td>
    <td>Loại hàng</td>
    <td>Thương hiệu</td>
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
    <a href="index.php?quanly=gallery&ac=lietke&id=<?php echo $dong['MaSP'] ?>" style="text-align:center;text-decoration:none; font-size:18px;color:#06F;">Gallery</a>
    </td>
    <td><?php echo $dong['SLTon'] ?></td>
    <td><?php echo $dong['TenLoaiSP'] ?></td>
    <td><?php echo $dong['TenThuongHieu'] ?></td>    
    <!--<td><a href="modules/quanlykhuyenmai/xuly.php?id=<?php echo $dong['MaSP']?>" class="delete_link"><center><img src="imgs/km.png" width="30" height="30"   /></center></a></td>-->
    <td>  
  <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal<?php echo $i;?>"><img src="imgs/km.png" width="50" height="50"   /></button>
</td>
  </tr>
  <div class="modal fade" id="myModal<?php echo $i;?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Thông tin khuyến mãi</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="modules/quanlykhuyenmai/xuly.php">
    <p>Mã sản phẩm<p>
    <p><input type="text" name="masp" value="<?php echo $dong['MaSP']; ?>" readonly="readonly"><p>  
          
    <p>Tên khuyến mãi<p>
    <p><input type="text" name="tenkm"><p>
  
  
    <p>Tỉ lệ khuyến mãi<p>
    <p><input type="number" step="0.1" name="khuyenmai"min=0 max=1><p>
  

    <p>Ngày bắt đầu khuyến mãi<p>
    <p><input type="text" name="ngaybatdau" value="<?php echo date('d/m/Y'); ?>" disabled><p>
  
  
    <p>Ngày kết thúc khuyến mãi<p>
    <p><input type="date" name="ngayketthuc"><p>
  
  
    <p>Ghi chú<p>
    <p><input type="text" name="ghichu"><p>
  <center><button type="submit" name="submit3" class="btn btn-primary" >Tạo khuyến mãi</button></center>
        
          </form>
        </div>
       
          
       
      </div>
      
    </div>
  </div>
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
		
		echo '<a href="index.php?quanly=khuyenmai&ac=tao&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=khuyenmai&ac=tao&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>
</div></div>
              </div>
              </div>
              </div>
                