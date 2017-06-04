



<div class="col-sm-9">
          
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#slt" data-toggle="tab">Thanh toán</a></li>
            <li><a href="#muanhieu" data-toggle="tab">Phiếu chi tiền</a></li>
            
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
	$sql_lietkesp=" select * from nhaphanphoi where congno>0 limit $trang1,10";
	$row_lietkesp=$conn->query($sql_lietkesp);



echo'
<table >
  <tr>
    <td>STT</td>
    <td><center>Tên nhà phân phối</center></td>    
    <td><center>Công nợ</center></td>
    <td><center>Thanh toán</center></td>
  </tr>';


  while($dong=$row_lietkesp->fetch_array()){
  
  echo'
  <tr>
  
    <td> '.$i.'</td>
    <td><center>'.$dong['TenNPP'].'<center></td>
    <td>  <center>'.number_format($dong['CongNo']) .' VND</center></td>';
      $i++;
    echo'<td><center><button type="button"  data-toggle="modal" data-target="#myModal'.$i.'"><img src="imgs/images.png" width="30" height="30" /></button><center></td>
   
  </tr>
<div id="myModal'.$i.'" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">';

   
  echo'
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Thông tin thanh toán</h4>
      </div>
      <div class="modal-body">

        <form  method="post" action="modules/quanlydathang/xuly.php?id='.$dong['MaNPP'].'" enctype="multipart/form-data">
        <div> Số tiền thanh toán:<input type="number" name="tien"  value="'.$dong['CongNo'].'" ></div>
        <div> Lý do thanh toán:     <input type="text" name="lydo"  value="thanh toán" ></div>
        </div>
      <div class="modal-footer">
        <button type="submit" name="thanhtoan" class="btn btn-primary" >Thanh toán</button>
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
	$sql_trang=$conn->query("select * from nhaphanphoi where congno>0  limit $trang1,10");
	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=thanhtoan&ac=lietkedh&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=thanhtoan&ac=lietkedh&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
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
	$sql_lietkesp="select * from phieuchitien,nhaphanphoi where phieuchitien.MaNPP=nhaphanphoi.MaNPP limit $trang1,10 ";
	$row_lietkesp=$conn->query($sql_lietkesp);


echo'
<table >
  <tr>
    <td>STT</td>
    <td>Tên nhà phân phối</td>    
    <td>Ngày Lập</td>
    <td>Số tiền</td>
    <td>Lý Do thanh toán</td>
  </tr>';
   

  while($dong=$row_lietkesp->fetch_array()){
  
  echo'
  <tr>
  
    <td> '.$i.'</td>
    <td>'.$dong['TenNPP'].'</td>
     <td> '. $dong['NgayLap'] .'</td>
    <td>  '.number_format($dong['SoTien']) .'</td>   
    <td> '. $dong['LyDo'] .'</td>';
     $i++;
    
 

   
  

  }
  ?>
</table>
<div class="trang">
	Trang :
    <?php
	$sql_trang=$conn->query("select * from phieuchitien,nhaphanphoi where phieuchitien.MaNPP=nhaphanphoi.MaNPP limit $trang1,10");
               
               	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/10);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?quanly=thanhtoan&ac=lietkedh&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?quanly=thanhtoan&ac=lietkedh&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
	?>
             </div><!--/tab-pane-->
            
          </div><!--/tab-content-->

        </div><!--/col-9-->