<?php
include("../config.php");
   $id=$_GET['id'];
    if(isset($_POST['sua'])){
         $mavc=$_POST['mavc'];
	$matt=$_POST['matt'];
	$ngaylap=$_POST['ngaylap'];
	$tongtien=$_POST['tongtien'];
	$diachi=$_POST['diachi'];
	$tinhtrang=$_POST['tinhtrang'];
	$ghichu=$_POST['ghichu'];
	
		//echo $mavc." ".$matt." ".$ngaylap." ".$tongtien." ".$diachi." ".$tinhtrang." ".$ghichu;
		$sql_sua = "update hoadon set mavc='$mavc',matt='$matt',ngaylap='$ngaylap',tongtien='$tongtien',diachi='$diachi',tinhtrang='$tinhtrang',ghichu='$ghichu' where mahd='$id'";
		$conn->query($sql_sua);
		header('location:../../index.php?quanly=hoadon&ac=lietke');
        }
     if($_GET['value']==1)
     {
         
         // Update Trang Thai = Da Duyet
         $sql="update hoadon set tinhtrang='Đã duyệt' where MaHD='$id'";
         $conn->query($sql);
         // Update diem thuong cua user
         $sqlgetdiemthuong="select * from hoadon where MaHD='$id'";
          $dt=$conn->query($sqlgetdiemthuong);
         while($d=$dt->fetch_array()){
         $diem=$d['TongTien']/100000;
         $ma = $d['MaTK'];}

		$sqlupdate="update taikhoan set DiemThuong= DiemThuong + $diem where taikhoan.MaTK=$ma";
		$kq=$conn->query($sqlupdate);
        // update so luong ton cua san pham

        $sqlslt="select * from cthd where MaHD=$id";
        $slt=$conn->query($sqlslt);
        while ($sp =$slt->fetch_array())
        {
            $masp= $sp['MaSP'];
            $soluong= $sp['SoLuong'];
            
        }

            $sqlupdateslt="update sanpham set SLTon= SLTon- $soluong where MaSP=$masp";
            $conn->query($sqlupdateslt);
        




         header('location:../../index.php?quanly=hoadon&ac=lietke');
     }  else 
     {
        
         $sql="delete from hoadon where mahd='$id'";$sql1="delete from cthd where mahd='$id'";
         $conn->query($sql);
         $conn->query($sql1);
       header('location:../../index.php?quanly=hoadon&ac=lietke');
     } 
?>