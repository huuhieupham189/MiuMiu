



<div class="col-sm-9">
          
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#slt" data-toggle="tab">Sản phẩm sắp hết</a></li>
            <li><a href="#muanhieu" data-toggle="tab">Sản phẩm mua nhiều</a></li>
            
          </ul>
              
          <div class="tab-content">
            <div class="tab-pane fade in active" id="slt">
    
              
                  
<?php
 $i=1;
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
	$sql_lietkesp=" select thuonghieu.MaThuongHieu,TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP
from sanpham,thuonghieu,loaisp
where loaisp.maloaisp=sanpham.maloaisp and thuonghieu.mathuonghieu=sanpham.mathuonghieu and slton<=10
order by slton limit $trang1,10";
	$row_lietkesp=$conn->query($sql_lietkesp);

if(isset($_SESSION['sanphamnhap']))
echo'

<div class="button_themsp">
<a href="index.php?quanly=nhapkho&ac=nhap">Đặt hàng</a> 
</div>
';
echo'
<table >
  <tr>
    <td>STT</td>
    <td>Tên sản phẩm</td>    
    <td>Hình ảnh</td>
    <td>Giá nhập</td>
    <td>Số lượng tồn</td>
    <td>Loại hàng</td>
    <td>Thương hiệu</td>
    <td colspan="2">Quản lý</td>
  </tr>';


  while($dong=$row_lietkesp->fetch_array()){
  
  echo'
  <tr>
  
    <td> '.$i.'</td>
    <td>'.$dong['TenSP'].'</td>
   
    <td><img src="modules/quanlysanpham/uploads/'.$dong['HinhAnh'].'" width="80" height="80" />
 
    </td>
    <td>  '.number_format($dong['GiaNhap']) .'</td>
    <td> '. $dong['SLTon'] .'</td>
    <td> '. $dong['TenLoaiSP'] .'</td>
    <td> '. $dong['TenThuongHieu'] .'</td>  ';
      $i++;
    $kiemtra=0;
    if(isset($_SESSION['sanphamnhap'])){
   
      $count=count($_SESSION['sanphamnhap']);
      for($t=0;$t<$count;$t++){
        if($dong['MaSP']==$_SESSION['sanphamnhap'][$t]['id']) $kiemtra=1;
      }
    }
      // if($kiemtra==0){
    echo'<td><button type="button"  data-toggle="modal" data-target="#myModal'.$i.'"';if($kiemtra==0)echo '><img src="imgs/images.png" width="30" height="30" /></button></td>';else echo'width="30" height="30">';
    echo'<td><a href="modules/quanlynhapkho/xuly.php?id='.$dong['MaSP'].'"class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
  </tr>
<div id="myModal'.$i.'" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">';

    $sql_hieusp = "select * from nhaphanphoi where mathuonghieu='".$dong['MaThuongHieu']."'";
  $row_hieusp=$conn->query($sql_hieusp);
  echo'
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Thông tin đặt hàng</h4>
      </div>
      <div class="modal-body">

        <form  method="post" action="modules/quanlynhapkho/xuly.php?id='.$dong['MaSP'].'" enctype="multipart/form-data">
        <div> Tên sản phẩm: <input type="text"  value="'.$dong['TenSP'].'" disabled></div>
       <div> Số lượng: <input type="number" name="soluong" value="0"></div>';


  echo'<div>Tên nhà phân phối: <select name="manpp">  ';
  	while($dong_hieusp=$row_hieusp->fetch_array()){
	
    echo'	<option value="'.$dong_hieusp['MaNPP'].'">'.$dong_hieusp['TenNPP'].'</option>';
        
	}
 echo' </select></td>';
   
  
 echo' </div>

        
      </div>
      <div class="modal-footer">
        <button type="submit" name="datmua" class="btn btn-primary" >Đặt mua</button>
      </div>
      </form>
    </div>

  </div>
</div>';
  

  }
  ?>
</table>
<div class="trang">
	Trang :
    <?php
	$sql_trang=$conn->query("select TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP
from sanpham,thuonghieu,loaisp
where loaisp.maloaisp=sanpham.maloaisp and thuonghieu.mathuonghieu=sanpham.mathuonghieu and slton<=10
order by slton");
	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=nhapkho&ac=lietke&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=nhapkho&ac=lietke&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>
</div>


              
              
             </div><!--/tab-pane-->
             <div class="tab-pane" id="muanhieu">
               <?php
 $i=1;
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
	$sql_lietkesp=" select thuonghieu.MaThuongHieu,TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP,sum(cthd.SoLuong) as soluong
from sanpham left join cthd on sanpham.MaSP=cthd.MaSP ,thuonghieu,loaisp
where loaisp.maloaisp=sanpham.maloaisp and thuonghieu.mathuonghieu=sanpham.mathuonghieu 
GROUP by TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP
order by soluong DESC limit $trang1,10";
	$row_lietkesp=$conn->query($sql_lietkesp);

if(isset($_SESSION['sanphamnhap']))
echo'

<div class="button_themsp">
<a href="index.php?quanly=nhapkho&ac=nhap">Đặt hàng</a> 
</div>
';
echo'
<table >
  <tr>
    <td>STT</td>
    <td>Tên sản phẩm</td>    
    <td>Hình ảnh</td>
    <td>Giá nhập</td>
    <td>Số lượng tồn</td>
    <td>Loại hàng</td>
    <td>Thương hiệu</td>
    <td colspan="2">Quản lý</td>
  </tr>';
   $k=1000;

  while($dong=$row_lietkesp->fetch_array()){
  $k--;
  echo'
  <tr>
  
    <td> '.$i.'</td>
    <td>'.$dong['TenSP'].'</td>
   
    <td><img src="modules/quanlysanpham/uploads/'.$dong['HinhAnh'].'" width="80" height="80" />
 
    </td>
    <td>  '.number_format($dong['GiaNhap']) .'</td>
    <td> '. $dong['SLTon'] .'</td>
    <td> '. $dong['TenLoaiSP'] .'</td>
    <td> '. $dong['TenThuongHieu'] .'</td>  ';
      $i++;
    $kiemtra=0;
    if(isset($_SESSION['sanphamnhap'])){
   
      $count=count($_SESSION['sanphamnhap']);
      for($t=0;$t<$count;$t++){
        if($dong['MaSP']==$_SESSION['sanphamnhap'][$t]['id']) $kiemtra=1;
      }
    }
 

      // if($kiemtra==0){
    echo'<td><button type="button"  data-toggle="modal" data-target="#myModal'.$k.'"';if($kiemtra==0)echo '><img src="imgs/images.png" width="30" height="30" /></button></td>';else echo'width="30" height="30">';
    echo'<td><a href="modules/quanlynhapkho/xuly.php?id='.$dong['MaSP'].'"class="delete_link"><center><img src="imgs/delete.png" width="30" height="30"   /></center></a></td>
  </tr>
<div id="myModal'.$k.'" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">';

    $sql_hieusp = "select * from nhaphanphoi where mathuonghieu='".$dong['MaThuongHieu']."'";
  $row_hieusp=$conn->query($sql_hieusp);
  echo'
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Thông tin đặt hàng</h4>
      </div>
      <div class="modal-body">

        <form  method="post" action="modules/quanlynhapkho/xuly.php?id='.$dong['MaSP'].'" enctype="multipart/form-data">
        <div> Tên sản phẩm: <input type="text"  value="'.$dong['TenSP'].'" disabled></div>
       <div> Số lượng: <input type="number" name="soluong" value="0"></div>';


  echo'<div>Tên nhà phân phối: <select name="manpp">  ';
  	while($dong_hieusp=$row_hieusp->fetch_array()){
	
    echo'	<option value="'.$dong_hieusp['MaNPP'].'">'.$dong_hieusp['TenNPP'].'</option>';
        
	}
 echo' </select></td>';
   
  
 echo' </div>

        
      </div>
      <div class="modal-footer">
        <button type="submit" name="datmua" class="btn btn-primary" >Đặt mua</button>
      </div>
      </form>
    </div>

  </div>
</div>';
  

  }
  ?>
</table>
<div class="trang">
	Trang :
    <?php
	$sql_trang=$conn->query("select thuonghieu.MaThuongHieu,TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP,sum(cthd.SoLuong) as soluong
from sanpham left join cthd on sanpham.MaSP=cthd.MaSP ,thuonghieu,loaisp
where loaisp.maloaisp=sanpham.maloaisp and thuonghieu.mathuonghieu=sanpham.mathuonghieu 
GROUP by TenSP,sanpham.MaSP,HinhAnh,GiaNhap,GiaBan,SLTon,thuonghieu.TenThuongHieu,loaisp.TenLoaiSP
order by soluong DESC limit $trang1,10");
               
               	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=nhapkho&ac=lietke&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=nhapkho&ac=lietke&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>
             </div><!--/tab-pane-->
            
          </div><!--/tab-content-->

        </div><!--/col-9-->