<?php  
//export.php  ;
	$servername='localhost';
	$username='root';
	$password='';
	$dbname='banhangonline';
	$conn = new mysqli($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, 'UTF8');
if(isset($_POST["export"]))
{
  
 error_reporting(E_ALL ^ E_NOTICE);
 $namtim = $_GET['nam'];
$sql1=" SELECT TenThuongHieu, Year(NgayLap) as Nam , sum(cthd.soluong) as SL
from ThuongHieu , SanPham,HoaDon,CTHD
WHERE thuonghieu.mathuonghieu=sanpham.mathuonghieu and sanpham.masp=cthd.masp and hoadon.mahd=cthd.mahd and year(NgayLap)='$namtim'
GROUP BY TenThuongHieu, Nam";
$result=$conn->query($sql1);

   $output.= ' <h2 align="center">Số Lượng bán theo năm theo thương hiệu</h2>
      <h4 align="center">Năm '.$namtim.'   </h4><br /> ';
  $output .= '  
              
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Tên Thương Hiệu</th>  
                         <th>Năm </th>  
                         <th>Số Lượng Bán</th>
                    </tr>
  ';
  			while($row = $result->fetch_array())
 {
   $output .= '
    <tr>   
             <td>'.$row["TenThuongHieu"].'</td>  
          <td>'.$row["Nam"].'</td> 
            <td>'.$row["SL"].'</td> 
           
   </tr>
   ';
  }
  $output .= '</table>';
  $filename="SoLuongBanNam" .$namtim.".xls";
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename='. basename($filename));
  echo $output;
 }

?>
