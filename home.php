	
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
									<img src="images/home/slide1.png" class="girl img-responsive" alt="" />
								</div>
							</div>
							<div class="item">
								<div class="col-sm-12">
									<img src="images/home/slide2.png" class="girl img-responsive" alt="" />
								</div>
							</div>
							
							<div class="item">
								<div class="col-sm-12">
									<img src="images/home/slide3.png" class="girl img-responsive" alt="" />
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
							<img src="images/home/shipping.jpg" alt="" />
						</div><!--/shipping-->
					
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					<div class="features_items"><!--features_items-->
						<h2 class="title text-center">Sản Phẩm Bán Chạy Nhất</h2>
						<?php
						$sql="SELECT sp.masp,HinhAnh,GiaBan,TenSP,TenCT,sum(SoLuong) as SoLuongBan
							  from cthd ct,sanpham sp
								where ct.masp=sp.masp
								group by sp.masp 
								ORDER BY ct.SoLuong  DESC limit 3";
						$ketqua=$conn->query($sql);
						while($dong=$ketqua->fetch_array()){
						echo"<div class='col-sm-4'>
							<div class='product-image-wrapper'>
								<div class='single-products'>
										<div class='productinfo text-center'>
											<img  src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' width='250' height='250'/>
										<h2>".number_format($dong['GiaBan'])."VND"."</h2>
										<p><strong>".$dong['TenSP']."<strong></p>
										<p>".$dong['TenCT']."</p>
										
										<a href='index.php?xem=product&id=".$dong['masp']."' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
										<a href='update_cart.php?id=".$dong['masp']."' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Đặt Mua</a>
										</div>

								</div>
								
							</div>
						</div>";}
						?>
				
						
					</div><!--features_items-->
					
				<?php include("items.php"); ?>
					
				
					
				</div>
			</div>
		</div>
	</section>