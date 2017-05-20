
<?php
include('config.php');
?>

	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">

						<h2>Danh Mục</h2>
						<div class='panel-group category-products' id='accordian'><!--category-productsr-->
							
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'>
										<a data-toggle='collapse' data-parent='#accordian' href='#Eyes'>
											<span class='badge pull-right'><i class='fa fa-plus'></i></span>
											Mắt
										</a>
									</h4>
								</div>
								<div id='Eyes' class='panel-collapse collapse'>
									<div class='panel-body'>
										<ul>
											<li><a href=''>Kẻ Mày</a></li>
											<li><a href=''>Kẻ Mắt</a></li>
											<li><a href=''>Phấn Mắt</a></li>
											<li><a href=''>Mascara</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'>
										<a data-toggle='collapse' data-parent='#accordian' href='#Face'>
											<span class='badge pull-right'><i class='fa fa-plus'></i></span>
											Mặt
										</a>
									</h4>
								</div>
								<div id='Face' class='panel-collapse collapse'>
									<div class='panel-body'>
										<ul>
											<li><a href=''>Kem BB/CC</a></li>
											<li><a href=''>Kem Nền</a></li>
											<li><a href=''>Phấn</a></li>
											<li><a href=''>Tạo Khối</a></li>
											
										</ul>
									</div>
								</div>
							</div>

							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'>
										<a data-toggle='collapse' data-parent='#accordian' href='#Lip'>
											<span class='badge pull-right'><i class='fa fa-plus'></i></span>
											Môi
										</a>
									</h4>
								</div>
								<div id='Lip' class='panel-collapse collapse'>
									<div class='panel-body'>
										<ul>
											<li><a href=''>Son Màu </a></li>
											<li><a href=''>Son Dưỡng </a></li>
										</ul>

									</div>

								</div>
							</div>
							
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Tẩy Trang</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Mặt Nạ</a></h4>
								</div>
							</div>
							
						</div><!--/category-productsr-->
					
						<div class='brands_products'><!--brands_products-->
							<h2>Nhãn Hiệu</h2>
							<div class='brands-name'>
								<ul class='nav nav-pills nav-stacked'>
									<li><a href=''> <span class='pull-right'>(50)</span>Maybeline</a></li>
									<li><a href=''> <span class='pull-right'>(56)</span>Mac</a></li>
									<li><a href=''> <span class='pull-right'>(27)</span>L'ore'al</a></li>
									<li><a href=''> <span class='pull-right'>(32)</span>Lancome</a></li>
									<li><a href=''> <span class='pull-right'>(5)</span>OLay</a></li>
									<li><a href=''> <span class='pull-right'>(5)</span>TheFaceShop</a></li>
									<li><a href=''> <span class='pull-right'>(5)</span>Biore'</a></li>
									<li><a href=''> <span class='pull-right'>(3)</span>Shiseido</a></li>
								
								</ul>
							</div>
						</div><!--/brands_products-->
						
						<div class='price-range'><!--price-range-->
							<h2>Price Range</h2>
							<div class='well'>
								 <input type='text' class='span2' value='' data-slider-min='0' data-slider-max='600' data-slider-step='5' data-slider-value='[250,450]' id='sl2' ><br />
								 <b>$ 0</b> <b class='pull-right'>$ 600</b>
							</div>
						</div><!--/price-range-->
						
						<div class='shipping text-center'><!--shipping-->
							<img src='images/home/shipping.jpg' alt='' />
						</div><!--/shipping-->
						
					</div>
				</div>
				<div class='col-sm-9 padding-right'>
					<div class='features_items'><!--features_items-->
						<h2 class='title text-center'> Sản Phẩm Bán Chạy Nhất</h2>
				<?php
				$sql='SELECT * from sanpham';
				$result=$conn->query($sql);
				if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()){        		
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
				} else {
    					echo '0 results';
						}
				$conn->close();

				?>
				<!--<ul class='pagination'>
							<li class='active'><a href=''>1</a></li>
							<li><a href=''>2</a></li>
							<li><a href=''>3</a></li>
							<li><a href=''>&raquo;</a></li>
						</ul>-->
				</div><!--features_items-->
				</div>
			</div>
		</div>
	</section>
