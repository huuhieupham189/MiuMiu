<?php
	include('../config.php');
	session_start();
    if(isset($_POST['datmua']))
    {
       
    $sql="select * from sanpham where masp=".$_GET['id']."";
     $dt=$conn->query($sql);
     while($dong=$dt->fetch_array()) {$gianhap=$dong['GiaNhap']; $thanhtien=$gianhap*$_POST["soluong"];}

     if(isset($_SESSION['sanphamnhap'])){
     $count=count($_SESSION['sanphamnhap']);
    $_SESSION['sanphamnhap'][$count]['id']=$_GET['id'];
    $_SESSION['sanphamnhap'][$count]['thanhtien']=$thanhtien;
    $_SESSION['sanphamnhap'][$count]['manpp']=$_POST['manpp'];
    $_SESSION['sanphamnhap'][$count]['soluong']=$_POST["soluong"];
    }else {
        $_SESSION['sanphamnhap'][0]['id']=$_GET['id'];
   $_SESSION['sanphamnhap'][0]['thanhtien']=$thanhtien;
    $_SESSION['sanphamnhap'][0]['manpp']=$_POST['manpp'];
    $_SESSION['sanphamnhap'][0]['soluong']=$_POST["soluong"];
    }
    
    header("location:../../index.php?quanly=nhapkho&ac=lietke");
    
    }
   
	
	if(isset($_POST['nhap'])){
	$k=0;
       $count=count($_SESSION['sanphamnhap']);           
            for($j=0;$j<$count;$j++){
                $kiemtra=1;
               for($i=0;$i<$k;$i++) {
                 if($a[$i]==$_SESSION['sanphamnhap'][$j]['manpp'])  $kiemtra=0;}
                 if($kiemtra==1) {$a[$k]=$_SESSION['sanphamnhap'][$j]['manpp'];$k++;}
        }
        $countnpp=count($a);
    for($i=0;$i<$countnpp;$i++){
	$max=0;
    for($j=$i;$j<$countnpp;$j++){
	if($a[$j]>=$max) {
		$max=$a[$j];
		$vitri=$j;
            }
        }
        $tam=$a[$i];
        $a[$i]=$a[$vitri];
        $a[$vitri]=$tam;
        }

echo $countnpp;

         for($i=0;$i<$countnpp;$i++)
         {
             $tongtien=0;
             for($j=0;$j<$count;$j++)
             {if($_SESSION['sanphamnhap'][$j]['manpp']==$a[$i]){
                 $tongtien=$tongtien + $_SESSION['sanphamnhap'][$j]['thanhtien'];
                 $manpp=$_SESSION['sanphamnhap'][$j]['manpp'];
                echo " ".$tongtien;
                }             
             }
             $sql="insert into hoadonnhaphang (manpp,ngaylap,tongtien) value('".$manpp."','".date('Y-m-d')."','".$tongtien."')";
             $conn->query($sql);
             $id=$conn->insert_id;
              for($j=0;$j<$count;$j++)
             {if($_SESSION['sanphamnhap'][$j]['manpp']==$a[$i]){
                 
                 $sql="insert into phieunhaphang (masp,soluong,thanhtien,mahdnh) value('".$_SESSION['sanphamnhap'][$j]['id']."','".$_SESSION['sanphamnhap'][$j]['soluong']."','".$_SESSION['sanphamnhap'][$j]['thanhtien']."','".$id."')";
             $conn->query($sql);
                }             
             }
         }
       for($i=0;$i<$count;$i++)
       {
           $sql="update sanpham set slton=slton+".$_SESSION['sanphamnhap'][$i]['soluong']." where masp=".$_SESSION['sanphamnhap'][$i]['id']."";
           $conn->query($sql);
       }
		
	 	header('location:../../index.php?quanly=nhapkho&ac=lietke');
         unset($_SESSION['sanphamnhap']);
	
    }
?>
