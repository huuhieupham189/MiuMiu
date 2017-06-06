	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
					
						<div class="carousel-inner">
							<div class="item active">
								<div class="col-sm-12">
									<img src="images/home/b1.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-12">
									<img src="images/home/b2.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
							
							<div class="item">
								<div class="col-sm-12">
									<img src="images/home/b3.jpg" class="girl img-responsive" alt="" />
								</div>
							</div>
							
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
		
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						
						
						<div class="shipping text-center"><!--shipping-->
							<a href="index.php?xem=sanpham&kigui=1"><img src="images/home/shipping.jpg" style="width:100%; background-color: none;" alt="" /></a>
						</div><!--/shipping-->
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản Phẩm Bán Chạy Nhất</h2>
						<?php
						$sql="SELECT sp.masp,HinhAnh,GiaBan,TenSP,TenCT,SLTon,sum(SoLuong) as SoLuongBan
							  from cthd ct,sanpham sp
								where ct.masp=sp.masp
								group by sp.masp 
								ORDER BY ct.SoLuong  DESC limit 9";
						$ketqua=$conn->query($sql);
						while($dong=$ketqua->fetch_array()){
						$sqll="select TiSo from khuyenmai where MaSP=".$dong['masp']." and NgayKT >= CURDATE()";
						$kq=$conn->query($sqll);
						$km=0;
						while ($d=$kq->fetch_array()) {
							   $km=$d['TiSo'];
							   $tile=$km*100;}
						echo"<div class='col-sm-4' style='height: 500px;'>
							<div class='product-image-wrapper'>
								<div class='single-products'>
										<div class='productinfo text-center'>";
										if ($km > 0) 
										echo"
										<img style='width:100px; position:absolute;margin-left:150px;'src='images/icon/sale.ico'>
											<img  src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' width='250' height='250'/>
											";
										elseif ($dong['SLTon']==0) echo
										"	<img style='width:100px; position:absolute;margin-left:150px;'src='images/icon/soldout.png'>
											<img  src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' width='250' height='250'/>
											";
										else echo"<img  src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' width='250' height='250'/>";
											$giakm=$dong['GiaBan'];
						 				
										 if ($km > 0) 	
						 					{ $giakm= $giakm*(1-$km);
						 					echo"	
												<span>
													
													<h2>".number_format($giakm)." VNĐ </h2>
												</span>";}
											else echo"<span>
															<h2>".number_format($dong['GiaBan'])." VNĐ</h2>
													</span>";
										if ($dong['SLTon']==0 )
										echo "
										<p><strong>".$dong['TenSP']."<strong></p>
										<p>".$dong['TenCT']."</p>
										
										<a href='index.php?xem=product&id=".$dong['masp']."' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
							
										</div>
								</div>	
							</div>
						</div>"; 
									else
										echo"
										<p><strong>".$dong['TenSP']."<strong></p>
										<p>".$dong['TenCT']."</p>
										
										<a href='index.php?xem=product&id=".$dong['masp']."' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
										<a href='update_cart.php?id=".$dong['masp']."' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Đặt Mua</a>
										</div>

								</div>
								
							</div>
						</div>";
						}
						?>
				
						
					</div><!--features_items-->
					
				<?php include("items.php"); ?>
					
				
					
				</div>
			</div>
		</div>
	</section>