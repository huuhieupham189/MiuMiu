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
 $thangtim = $_GET['thang'];
  $namtim= $_GET['nam'];
  error_reporting(E_ALL ^ E_NOTICE);
 if (isset($_GET["thang"])) $query = "Select * From BCCongNo where thang=".$_GET['thang']." and nam=".$_GET['nam']."";
 else $query = "Select * From BCCongNo where  nam=".$_GET['nam']."";

 $result=$conn->query($query);
	    if ($result->num_rows > 0) {
  

 

 


   if (isset($_GET["thang"]))
   $output.= ' <h2 align="center">Tổng Hợp Công Nợ</h2>
        <h5 align="center">Tháng '.$thangtim.'  </h5><h4 align="center">Năm '.$namtim.'   </h4><br /> ';
    else $output.= ' <h2 align="center">Tổng Hợp Công Nợ</h2>
      <h4 align="center">Năm '.$namtim.'   </h4><br /> ';



  $output .= '  
              
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Tên Nhà Phân Phối</th>  
                         <th>Tháng Lập</th>  
                         <th>Nợ Đầu</th> 
                         <th>Số Tiền Nhập Hàng</th>  
                         <th>Số Tiền Đã Thanh Toán</th>
                         <th>Dư Nợ Cuối Kỳ</th>
                    </tr>
  ';
  			while($row = $result->fetch_array())
 {
   $output .= '
    <tr>   
            <td>'.$row["Ten"].'</td>  
            <td>'.$row["Thang"].'</td> 
            <td>'.$row['NoDau'].'</td> 
            <td>'.$row["SoTienNhap"].'</td>  
            <td>'.$row["SoTienChi"].'</td>  
            <td>'.$row["NoCuoi"].'</td>  
   </tr>
   ';
  }
  $output .= '</table>';
  $filename="TongHopCongNoThang" .$thangtim.".xls";
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename='. basename($filename));
  echo $output;
 }
}
?>
