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
 $query = "SELECT * FROM taikhoan";
 $result=$conn->query($query);
	    if ($result->num_rows > 0) {

  $output .= '  
   <table class="table" bordered="1">  
                    <tr>  
                         <th>Name</th>  
                         <th>Address</th>  
                         <th>City</th>  
       <th>Postal Code</th>
       <th>Country</th>
                    </tr>
  ';
  			while($row = $result->fetch_array())
 {
   $output .= '
    <tr>  
                         <td>'.$row["MaTK"].'</td>  
                         <td>'.$row["TenDangNhap"].'</td>  
                         <td>'.$row["MatKhau"].'</td>  
       <td>'.$row["LoaiTK"].'</td>  
       <td>'.$row["DiemThuong"].'</td>
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
  echo $output;
 }
}
?>
