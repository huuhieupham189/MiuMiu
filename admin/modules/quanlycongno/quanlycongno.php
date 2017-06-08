<div class="col-sm-12"> 
  <form method='post' action='modules/quanlycongno/xulithang.php'>
						  <div class='col-sm-3'>
              <input type='number' class='form-control' name='thang' id='thang' placeholder='Tháng muốn xem' title=''max=12 min=1>
              <input type='number' class='form-control' name='nam' id='nam' placeholder='Năm muốn xem'  value=2017>
              </div>
						  <div class='col-sm-1' >
						 <button type="submit" name='search' class="btn btn-info">
      <span class="glyphicon glyphicon-search"></span> Tra Cứu
    </button> </div></form>
</div>

 <div class="table-responsive col-sm-12">  
    <h2 align="center">Tổng Hợp Công Nợ</h2>

        <?php 
              $thangtim='';
              $namtim= '';
               if(isset($_GET['thang'])){ $thangtim = $_GET['thang'];}
                    if(isset($_GET['nam'])){ $namtim = $_GET['nam'];}
              if ($thangtim != NULL) echo " <h5 align='center'>Tháng $thangtim   </h5><h4 align='center'>Năm $namtim   </h4><br />  "; ?>

    <table class="table table-bordered">
     <tr>  
                         <th>Tên Nhà Phân Phối</th>  
                         <th>Tháng </th>  
                         <th>Năm</th>
                            <th>Nợ Đầu</th> 
                         <th>Số Tiền Nhập Hàng</th>  
       <th>Số Tiền Đã Thanh Toán</th>
       <th>Dư Nợ Cuối Kỳ</th>
                    </tr>
     <?php
      error_reporting(E_ALL ^ E_NOTICE);
     if(isset($_GET['thang']) || (isset($_GET['nam']))){
        $drop1="drop table Chi";
        $conn->query($drop1);
        $drop2="drop table Nhap";
        $conn->query($drop2);
           $drop3="drop table NPP";
        $conn->query($drop3);
             $drop4="drop table congno";
        $conn->query($drop4);
               $drop5="drop table BCCongNo";
        $conn->query($drop5);

        $sql1="   create table Chi as
                SELECT TenNPP, month(NgayLap) as ThangLap,year(NgayLap) as NamLap, IFNULL(sum(SoTien),0) as SoTienChi
from nhaphanphoi , phieuchitien
WHERE nhaphanphoi.MaNPP = phieuchitien.MaNPP
GROUP BY TenNpp, ThangLap";
      
    $conn->query($sql1);
         $sql2="create table Nhap as
        SELECT TenNPP, month(NgayLap) as ThangLap,year(NgayLap) as NamLap, IFNULL(sum(TongTien),0) as SoTienNhap
        from nhaphanphoi , hoadonnhaphang
        WHERE nhaphanphoi.MaNPP = hoadonnhaphang.MaNPP
      GROUP BY TenNPP, ThangLap";
      
   $conn->query($sql2);

       $sql3="  create table NPP as
              select nhaphanphoi.TenNPP,nhap.ThangLap,NamLap,SoTienNhap 
             from nhap RIGHT JOIN  (nhaphanphoi)
                 ON (nhaphanphoi.TenNPP=nhap.TenNPP )
            group by nhaphanphoi.TenNPP,nhap.ThangLap,NamLap ";
      $conn->query($sql3);
      $sql4=" create table CongNo as
        SELECT distinct NPP.TenNPP as Ten,chi.TenNPP, NPP.ThangLap as Thang,chi.ThangLap, NPP.NamLap as nam,chi.NamLap, SoTienNhap, SoTienChi 
              FROM NPP  LEFT  JOIN (chi) ON (NPP.ThangLap=chi.ThangLap and NPP.TenNPP=chi.TenNPP and NPP.NamLap=chi.NamLap)
             
       UNION
  SELECT distinct NPP.TenNPP as Ten,chi.TenNPP, NPP.ThangLap as Thang,chi.ThangLap, NPP.NamLap as nam,chi.NamLap, SoTienNhap, SoTienChi 
              FROM NPP  RIGHT  JOIN (chi) ON (NPP.ThangLap=chi.ThangLap and NPP.TenNPP=chi.TenNPP and NPP.NamLap=chi.NamLap)
        ";
          $conn->query($sql4);
          $sqlup1="    update congno
SET Ten = TenNPP 
WHERE Ten is null ";
        $sqlup2="    update congno
SET  Thang= ThangLap
WHERE Thang is null ";
$sqlup3="    update congno
SET  nam= NamLap
WHERE nam is null ";
 
 $conn->query($sqlup1); $conn->query($sqlup2);$conn->query($sqlup3);

        $sql6="  create table BCCongNo
              SELECT  Ten,Thang,nam,SoTienNhap as NoDau, SoTienNhap,SoTienChi, IFNULL(SoTienNhap,0) - IFNULL(SoTienChi,0) as NoCuoi
              FROM CongNo
              group by Ten,Thang,nam
              
            ";
        $conn->query($sql6);
       
      
          
 
        $sqlse="Select * From BCCongNo";
        $resultse=    $conn->query($sqlse);
        $num=$resultse->num_rows;
        $i=1;
	    if ($resultse->num_rows > 0) {
			while($row = $resultse->fetch_array())

     {  
 
        $thang= $row['Thang'];
        $ten=$row['Ten'];
        $nam=$row['nam'];
        $sqlup4="update BCCongNo
                  Set NoDau=  (
                                  Select NoCuoi
                                  From (
                                            Select * 
                                            From BCCongNo
                                            Where Thang < $thang and Ten='$ten' and nam<=$nam
                                            group by Ten,Thang,nam
                                            order by Thang DESC 
                                            limit 0,1

                                        ) AS T
                               )
                  where Thang=$thang and nam=$nam and Ten='$ten'";
          $conn->query($sqlup4);

            $sqlup3="update BCCongNo set NoDau = 0 where NoDau is null";
  $conn->query($sqlup3);
        
          $sqlup5="update BCCongNo
                  Set Nocuoi= NoDau+NoCuoi
                  where Thang=$thang and Ten='$ten'";
          $conn->query($sqlup5);
           $sqlup3="update BCCongNo set sotiennhap = 0 where sotiennhap is null";
  $conn->query($sqlup3); 
  $sqlup3="update BCCongNo set sotienchi = 0 where sotienchi is null";
  $conn->query($sqlup3);
     }}
       $sqlse="Select * From BCCongNo where thang=".$_GET['thang']." and nam=".$_GET['nam']."";
        $resultse=    $conn->query($sqlse);
        $num=$resultse->num_rows;
   
	    if ($resultse->num_rows > 0) {
			while($row = $resultse->fetch_array())

     {  
        echo '  
       <tr>  
         <td><a data-toggle="modal" data-target="#myModal'.$i.'"   >'.$row["Ten"].'</a></td>  
          <td>'.$row["Thang"].'</td> 
            <td>'.$row["nam"].'</td> 
              <td>'.$row['NoDau'].'</td> 
            <td>'.$row["SoTienNhap"].'</td>  
           <td>'.$row["SoTienChi"].'</td>  
            <td>'.$row["NoCuoi"].'</td>  
     
        

 
       </tr>  
       <div class="modal fade" id="myModal'.$i.'"  role="dialog">
    <div class="modal-dialog modal-lg">
     <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Chi Tiết Công Nợ</h4>
        </div>
        <div class="modal-body">
            <h5 align="center">Công Nợ Tháng Trước :'.$row["NoDau"].' </h5> 
          <h2 align="center">Hóa Đơn Nhập Hàng </h2>
            <div class="col-sm-12">
            <div class="col-sm-4"> <h3>Mã Hóa Đơn </h3> </div>
            <div class="col-sm-4"> <h3>Ngày Lập</h3> </div>
            <div class="col-sm-4"><h3>Số Tiền Nợ</h3></div>
          </div>';
    $tennpp=$row['Ten'];
    $sql= "select  * From nhaphanphoi , hoadonnhaphang where  TenNPP='".$tennpp."' and nhaphanphoi.MaNPP=hoadonnhaphang.MaNPP and month(NgayLap)=".$_GET['thang']." and year(NgayLap)=".$_GET['nam']."";
    $kq=$conn->query($sql);
     if ($kq->num_rows > 0) {
			while($row1 = $kq->fetch_array()){
    echo'
     
          <div class="col-sm-12">
            <div class="col-sm-4"> <h4>'.$row1["MaHDNH"].'</h4></div>
            <div class="col-sm-4"> <h4>'.$row1["NgayLap"].' </h4></div>
            <div class="col-sm-4"><h4>'.$row1["TongTien"].'</h4></div>
          </div>';}}
           else echo'
           <div class="col-sm-12">
            <div class="col-sm-4"> <h4>0</h4></div>
            <div class="col-sm-4"> <h4>0</h4></div>
            <div class="col-sm-4"><h4>0</h4></div>
          </div>
          ';
          echo'
            <br/>
           <h2 align="center">Phiếu Chi Tiền</h2>
            <div class="col-sm-12">
            <div class="col-sm-4"> <h3>Mã Phiếu Chi </h3> </div>
            <div class="col-sm-4"> <h3>Ngày Lập</h3> </div>
            <div class="col-sm-4"><h3>Số Tiền Thanh Toán</h3></div></div>';
     $sqll= "select  * From nhaphanphoi , phieuchitien where  TenNPP='".$tennpp."' and nhaphanphoi.MaNPP=phieuchitien.MaNPP and month(NgayLap)=".$_GET['thang']." and year(NgayLap)=".$_GET['nam']."";
    $kqq=$conn->query($sqll);
     if ($kqq->num_rows > 0) {
			while($row2 = $kqq->fetch_array()){
    echo'
     
          <div class="col-sm-12">
            <div class="col-sm-4"> <h4>'.$row2["MaPC"].'</h4></div>
            <div class="col-sm-4"> <h4>'.$row2["NgayLap"].' </h4></div>
            <div class="col-sm-4"><h4>'.$row2["SoTien"].'</h4></div>
          </div>';
          }}
          else echo'
           <div class="col-sm-12">
            <div class="col-sm-4"> <h4>0</h4></div>
            <div class="col-sm-4"> <h4>0</h4></div>
            <div class="col-sm-4"><h4>0</h4></div>
          </div>
          
          ';
      echo'
     </div>
       
        <div class="modal-footer" style="background-color:white;">
     
      </div>   
       
      </div>
      
    </div>
  </div>
        ';
    $i++;    
        }} 
        else
        echo '  
       <tr>  
         <td></td>  
          <td>0</td> 
              <td>0</td> 
                 <td>0</td> 
            <td>0</td>  
           <td>0</td>  
            <td>0</td>  
         <td></td>


       
       </tr>  
        ';  }
        else   echo '  
       <tr>  
         <td></td>  
          <td>0</td> 
              <td>0</td> 
                      <td>0</td> 
            <td>0</td>  
           <td>0</td>  
            <td>0</td>  
         <td></td>


       
       </tr>  
        '; 

     ?>
    </table>
    <br />


    <form method="post" action="modules/quanlycongno/export.php?thang=<?php echo ''.$_GET['thang'].'&nam='.$_GET['nam'].''; ?> ">
     <button type="submit" name="export" class="btn btn-success" value="Export" <?php   if(!isset($_GET['thang']) || (!isset($_GET['nam']))) echo "disabled" ?> >
           <span class="	glyphicon glyphicon-folder-open"> </span>  Xuất File Excel <button>
    </form>
   </div>  