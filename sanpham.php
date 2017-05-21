
<?php
			if(!isset($_GET['id'])){
            echo"<h2 class='title text-center'> Sản Phẩm Bán Chạy Nhất</h2>";
            	$sql='SELECT sp.MaSP,HinhAnh,GiaBan,TenSP,TenCT,sum(SoLuong) as SoLuongBan
							  from cthd ct,sanpham sp
								where ct.masp=sp.masp
								group by sp.masp 
								ORDER BY ct.SoLuong  DESC limit 6';
				$result=$conn->query($sql);
				if ($result->num_rows > 0) {
				while($row = $result->fetch_array()){        		
					echo"<div class='col-sm-4'>
							<div class='product-image-wrapper'>
								<div class='single-products'>
									<div class='productinfo text-center'>
										<img  src='admin/modules/quanlysanpham/uploads/".$row['HinhAnh']."' width='250' height='250'/>
										<h2>".number_format($row['GiaBan'])."VND"."</h2>
										<p><strong>".$row['TenSP']."<strong></p>
										<p>".$row['TenCT']."</p>
										
										<a href='index.php?xem=product&id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
										<a href='update_cart.php?id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Đặt Mua</a>
									</div>
								</div>
							</div>
						</div>";
    			}
				}} else 
                {
                     echo"<h2 class='title text-center'>THƯƠNG HIỆU ".$_GET['ten']."</h2>";
            	if(isset($_GET['trang'])){
					$trang=$_GET['trang'];
					}else{
					$trang='';
					}
				if($trang =='' || $trang =='1'){
					$trang1=0;
					}else{
					$trang1=($trang*5)-5;
					}
					$id=$_GET['id'];
					
				$sql="SELECT * from sanpham where mathuonghieu='".$id."' order by masp desc limit $trang1,6";
				$result=$conn->query($sql);
				
				while($row = $result->fetch_array()){        		
					echo"<div class='col-sm-4'>
							<div class='product-image-wrapper'>
								<div class='single-products'>
									<div class='productinfo text-center'>
										<img  src='admin/modules/quanlysanpham/uploads/".$row['HinhAnh']."' width='250' height='250'/>
										<h2>".number_format($row['GiaBan'])."VND"."</h2>
										<p><strong>".$row['TenSP']."<strong></p>
										<p>".$row['TenCT']."</p>
										
										<a href='index.php?xem=product&id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
										<a href='update_cart.php?id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Đặt Mua</a>
									</div>
								</div>
							</div>
						</div>";
                
						
				}
					echo'	<div class="trang">
	Trang :';
    
	$sql_trang=$conn->query("SELECT * from sanpham where mathuonghieu='".$id."'");
	$count_trang=$sql_trang->num_rows;
    
	$a=ceil($count_trang/6);
	for($b=1;$b<=$a;$b++){
		
		if($trang==$b){
		
		echo '<a href="index.php?xem=sanpham&id='.$_GET['id'].'&ten='.$_GET['ten'].'&trang='.$b.'" style="text-decoration:underline;color:red;">'.$b.' ' .'</a>';
        
	}else{
		echo '<a href="index.php?xem=sanpham&id='.$_GET['id'].'&ten='.$_GET['ten'].'&trang='.$b.'" style="text-decoration:none;color:#000;">'.$b.' ' .'</a>';
	}
	}
echo'
</div>';
				}

				$conn->close();

				?>
