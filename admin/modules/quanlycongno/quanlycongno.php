 <div class="table-responsive">  
    <h2 align="center">Tổng Hợp Công Nợ</h2><br /> 
    <table class="table table-bordered">
     <tr>  
                         <th>Tên Nhà Phân Phối</th>  
                         <th>Tháng Lập</th>  
                            <th>Nợ Đầu</th> 
                         <th>Số Tiền Nhập Hàng</th>  
       <th>Số Tiền Đã Thanh Toán</th>
       <th>Dư Nợ Cuối Kỳ</th>
                    </tr>
     <?php
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
                SELECT TenNPP, month(NgayLap) as ThangLap, IFNULL(sum(SoTien),0) as SoTienChi
from nhaphanphoi , phieuchitien
WHERE nhaphanphoi.MaNPP = phieuchitien.MaNPP
GROUP BY TenNpp, ThangLap";
      
    $conn->query($sql1);
         $sql2="create table Nhap as
        SELECT TenNPP, month(NgayLap) as ThangLap, IFNULL(sum(TongTien),0) as SoTienNhap
        from nhaphanphoi , hoadonnhaphang
        WHERE nhaphanphoi.MaNPP = hoadonnhaphang.MaNPP
      GROUP BY TenNPP, ThangLap";
      
   $conn->query($sql2);

       $sql3="  create table NPP as
              select nhaphanphoi.TenNPP,nhap.ThangLap,SoTienNhap 
             from nhap RIGHT JOIN  (nhaphanphoi)
                 ON (nhaphanphoi.TenNPP=nhap.TenNPP )
            group by nhaphanphoi.TenNPP,nhap.ThangLap ";
      $conn->query($sql3);
      $sql4=" create table CongNo as
        SELECT distinct NPP.TenNPP as Ten,chi.TenNPP, NPP.ThangLap as Thang,chi.ThangLap, SoTienNhap, SoTienChi 
              FROM NPP  LEFT  JOIN (chi) ON (NPP.ThangLap=chi.ThangLap and NPP.TenNPP=chi.TenNPP)
             
       UNION
SELECT distinct NPP.TenNPP as Ten,chi.TenNPP, NPP.ThangLap as Thang,chi.ThangLap, SoTienNhap, SoTienChi
              FROM NPP  RIGHT  JOIN (chi) ON (NPP.ThangLap=chi.ThangLap and NPP.TenNPP=chi.TenNPP)  
        ";
          $conn->query($sql4);
          $sqlup1="    update congno
SET Ten = TenNPP 
WHERE Ten is null ";
        $sqlup2="    update congno
SET  Thang= ThangLap
WHERE Thang is null ";
 
 $conn->query($sqlup1); $conn->query($sqlup2);

        $sql6="  create table BCCongNo
              SELECT  Ten,Thang,SoTienNhap as NoDau, SoTienNhap,SoTienChi, IFNULL(SoTienNhap,0) - IFNULL(SoTienChi,0) as NoCuoi
              FROM CongNo
              group by Ten,Thang
              
            ";
        $conn->query($sql6);
       
      
          
 
        $sqlse="Select * From BCCongNo";
        $resultse=    $conn->query($sqlse);
        $num=$resultse->num_rows;
   
	    if ($resultse->num_rows > 0) {
			while($row = $resultse->fetch_array())

     {  
 
        $thang= $row['Thang'];
        $ten=$row['Ten'];
        $sqlup4="update BCCongNo
                  Set NoDau=  (
                                  Select NoCuoi
                                  From (
                                            Select * 
                                            From BCCongNo
                                            Where Thang < $thang and Ten='$ten'
                                            group by Ten,Thang
                                            order by Thang DESC 
                                            limit 0,1

                                        ) AS T
                               )
                  where Thang=$thang and Ten='$ten'";
          $conn->query($sqlup4);

            $sqlup3="update BCCongNo set NoDau = 0 where NoDau is null";
  $conn->query($sqlup3);
        
          $sqlup5="update BCCongNo
                  Set Nocuoi= NoDau+NoCuoi
                  where Thang=$thang and Ten='$ten'";
          $conn->query($sqlup5);
     
     }}
       $sqlse="Select * From BCCongNo";
        $resultse=    $conn->query($sqlse);
        $num=$resultse->num_rows;
   
	    if ($resultse->num_rows > 0) {
			while($row = $resultse->fetch_array())

     {  
        echo '  
       <tr>  
         <td>'.$row["Ten"].'</td>  
          <td>'.$row["Thang"].'</td> 
              <td>'.$row['NoDau'].'</td> 
            <td>'.$row["SoTienNhap"].'</td>  
           <td>'.$row["SoTienChi"].'</td>  
            <td>'.$row["NoCuoi"].'</td>  
         <td></td>


       
       </tr>  
        '; }}
     ?>
    </table>
    <br />
    <form method="post" action="modules/quanlycongno/export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export" />
    </form>
   </div>  