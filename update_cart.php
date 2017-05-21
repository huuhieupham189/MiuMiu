<?php
session_start();
if(isset($_SESSION['matk'])){
//tru bot sp
if(isset($_GET['tru'])){
		$id=$_GET['tru'];
		foreach($_SESSION['giohang'] as $cart_item){
			if($id!=$cart_item['id']){
				
				$giohang[]=array('id'=>$cart_item['id'],'soluong'=>$cart_item['soluong']);
				$_SESSION['giohang']=$giohang;
			}else{
				$giam=$cart_item['soluong']-1;
				if($cart_item['soluong']>1){
				$giohang[]=array('id'=>$cart_item['id'],'soluong'=>$giam);
				
				}else{
					$giam=1;
					$giohang[]=array('id'=>$cart_item['id'],'soluong'=>$giam);
				}
				$_SESSION['giohang']=$giohang;
			}
        }
			header('location:index.php?xem=cart');
		}
		
	
	//cong them sp
	if(isset($_GET['cong'])){
		$id=$_GET['cong'];
		foreach($_SESSION['giohang'] as $cart_item){
			if($id!=$cart_item['id']){
				
				$giohang[]=array('id'=>$cart_item['id'],'soluong'=>$cart_item['soluong']);
				$_SESSION['giohang']=$giohang;
			}else{
				$tang=$cart_item['soluong']+1;
				if($cart_item['soluong']<9){
				
				$giohang[]=array('id'=>$cart_item['id'],'soluong'=>$tang);
				
			}else{
				
				$giohang[]=array('id'=>$cart_item['id'],'soluong'=>$cart_item['soluong']);
			}
			$_SESSION['giohang']=$giohang;
			}
        }
			header('location:index.php?xem=cart');
		}

       //xoa san pham
       if(isset($_SESSION['giohang'])&&isset($_GET['xoa'])){
		$id=$_GET['xoa'];
		foreach($_SESSION['giohang'] as $cart_item){
			if($cart_item['id']!= $id){
				$giohang[]=array('id'=>$cart_item['id'],'soluong'=>$cart_item['soluong']);
			}
		$_SESSION['giohang']=$giohang;
		header('location:index.php?xem=cart');
		}
	} 
    //them san pham
	if(isset($_GET['id'])){
		if(isset($_POST['dathang'])){$soluong=$_POST['soluong'];}
		else $soluong=1;
	$id=$_GET['id'];
	if(isset($_SESSION['giohang'])){
		$count=count($_SESSION['giohang']);
		$kiemtra=false;
		for($i=0;$i<$count;$i++)
		{	
			if($_SESSION['giohang'][$i]['id']==$id) {
				$_SESSION['giohang'][$i]['soluong']+=1;
				$kiemtra=true;
				break;
			}		
		}
		if($kiemtra==false)
		{
			$_SESSION['giohang'][$count]['id']=$id;
			$_SESSION['giohang'][$count]['soluong']=$soluong;
		}
	}
	else{
		
		$_SESSION['giohang'][0]['id']=$id;
		$_SESSION['giohang'][0]['soluong']=$soluong;
	}
    header('location:index.php?xem=sanpham');
}}
else header('location:index.php?xem=login');

?>