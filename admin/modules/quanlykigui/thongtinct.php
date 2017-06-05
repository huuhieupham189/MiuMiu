<?php
$sql="select * from cthd,sanpham where cthd.masp='".$_GET['id']."' and cthd.masp=sanpham.masp";
$kq=$conn->query($sql);
$tien=0;
while($dong=$kq->fetch_array())
{
 $tien=$tien+ $dong['ThanhTien']-$dong['GiaNhap'];
}
?>
<section>
		<div class="container">
			<div class="row">
				
				<!--<div class="col-sm-1"></div>-->
				<div class="col-sm-12 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-4">
						<?php 
						$sqll="select TiSo from khuyenmai where MaSP=".$_GET['id']." and NgayKT >= CURDATE()";
						$kq=$conn->query($sqll);
						$km=0;
						while ($d=$kq->fetch_array()) {
							   $km=$d['TiSo'];}
						if(isset($_GET['id'])){
							$sql="select * from sanpham sp, thuonghieu th where th.mathuonghieu=sp.mathuonghieu and masp='".$_GET['id']."'";
							$ketqua=$conn->query($sql);
							while($dong=$ketqua->fetch_array()){
								$giakm=$dong['GiaBan'];
							$tile = $km*100;
							if ($km > 0)
							echo"
								
								<div class='view-product'>
								<img style='border-style: none;width:100px; height:auto; position:absolute;margin-left:250px;'src='images/icon/sale.ico'>
								<img src='modules/quanlysanpham/uploads/".$dong['HinhAnh']."' alt='' />								
							</div>							
						</div>
						<div class='col-sm-8'>
							<div class='product-information'><!--/product-information-->";	
						else echo"
							<div class='view-product'>
								<img src='modules/quanlysanpham/uploads/".$dong['HinhAnh']."' alt='' />								
							</div>							
						</div>
						<div class='col-sm-8'>";
								
								
									
						 	
						 if ($km > 0) 
						 { $giakm= $giakm*(1-$km);
						 echo"	
						 	<h2><strong>".$dong['TenSP']."</strong> : ".$dong['TenCT']." <span style='color : red;'class='glyphicon glyphicon-arrow-down'><strong>".$tile."%</strong></span></h2>	 
								<span>
									<span style='text-decoration: line-through; color:black; font-size:15pt;'><small><center>".number_format($dong['GiaBan'])." VNĐ</center></small></span>
									<div class='col-sm-12';></div>
									<span>".number_format($giakm)." VNĐ</span>
								</span>";}
						else echo"
								<h2><strong>".$dong['TenSP']."</strong> : ".$dong['TenCT']." </h2>
								<span>
									<h2>".number_format($dong['GiaBan'])." VNĐ</h2>
								</span>";

								if ($dong['SLTon'] > 0)
								echo"
									
									
							
									
								<p><b>Hiện còn: </b>".$dong['SLTon']."</p>
								<p><b>Thương hiệu: </b>".$dong['TenThuongHieu']."</p>
								<p><b>Lợi nhuận: </b>".number_format($tien)."VND</p>";
						
								}}?>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
			

	


					
			
					
				</div>
			</div>
		</div>
	</section>