<div class="col-sm-12"> 
  <form method='post' action='modules/quanlysoluongban/xuly.php'>
						  <div class='col-sm-3'>
              <input type='number' class='form-control' name='nam' id='nam' placeholder='Năm muốn xem'  value=2017>
              </div>
						  <div class='col-sm-1' >
						 <button type="submit" name='search' class="btn btn-info">
      <span class="glyphicon glyphicon-search"></span> Tra Cứu
    </button> </div></form>
</div>

 <div class="table-responsive col-sm-12">  
    <h2 align="center">Số Lượng bán theo năm theo thương hiệu</h2>

        <?php 
           
              $namtim= '';
               
                    if(isset($_GET['nam'])){ $namtim = $_GET['nam'];}
      echo " <h4 align='center'>Năm $namtim   </h4><br />  "; ?>

    <table class="table table-bordered">
     <tr>  
                         <th>Tên Thương Hiệu</th>  
                         <th>Năm </th>  
                         <th>Số Lượng Bán</th>
         
                    </tr>
     <?php
      error_reporting(E_ALL ^ E_NOTICE);
    

        $sql1=" SELECT TenThuongHieu, Year(NgayLap) as Nam , sum(cthd.soluong) as SL
from ThuongHieu , SanPham,HoaDon,CTHD
WHERE thuonghieu.mathuonghieu=sanpham.mathuonghieu and sanpham.masp=cthd.masp and hoadon.mahd=cthd.mahd and year(NgayLap)='$namtim'
GROUP BY TenThuongHieu, Nam";
      
   
        $resultse=    $conn->query($sql1);
        $num=$resultse->num_rows;
	    if ($resultse->num_rows > 0) {
			while($row = $resultse->fetch_array())

     {  
 
        echo '  
       <tr>  
         <td>'.$row["TenThuongHieu"].'</td>  
          <td>'.$row["Nam"].'</td> 
            <td>'.$row["SL"].'</td> ';
           
        

 }}
        
        else
        echo '  
       <tr>  
         <td></td>  
          <td>0</td> 
              <td>0</td> 
             


       
       </tr>  
        '; 

     ?>
    </table>
    <br />


    <form method="post" action="modules/quanlysoluongban/xuatexcel.php?nam=<?php echo ''.$_GET['nam'].''; ?> ">
     <button type="submit" name="export" class="btn btn-success" value="Export" <?php   if( (!isset($_GET['nam']))) echo "disabled" ?> >
           <span class="	glyphicon glyphicon-folder-open"> </span>  Xuất File Excel <button>
    </form>
   </div>  