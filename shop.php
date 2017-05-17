
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
										<a data-toggle='collapse' data-parent='#accordian' href='#sportswear'>
											<span class='badge pull-right'><i class='fa fa-plus'></i></span>
											Sportswear
										</a>
									</h4>
								</div>
								<div id='sportswear' class='panel-collapse collapse'>
									<div class='panel-body'>
										<ul>
											<li><a href=''>Nike </a></li>
											<li><a href=''>Under Armour </a></li>
											<li><a href=''>Adidas </a></li>
											<li><a href=''>Puma</a></li>
											<li><a href=''>ASICS </a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'>
										<a data-toggle='collapse' data-parent='#accordian' href='#mens'>
											<span class='badge pull-right'><i class='fa fa-plus'></i></span>
											Mens
										</a>
									</h4>
								</div>
								<div id='mens' class='panel-collapse collapse'>
									<div class='panel-body'>
										<ul>
											<li><a href=''>Fendi</a></li>
											<li><a href=''>Guess</a></li>
											<li><a href=''>Valentino</a></li>
											<li><a href=''>Dior</a></li>
											<li><a href=''>Versace</a></li>
											<li><a href=''>Armani</a></li>
											<li><a href=''>Prada</a></li>
											<li><a href=''>Dolce and Gabbana</a></li>
											<li><a href=''>Chanel</a></li>
											<li><a href=''>Gucci</a></li>
										</ul>
									</div>
								</div>
							</div>
							
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'>
										<a data-toggle='collapse' data-parent='#accordian' href='#womens'>
											<span class='badge pull-right'><i class='fa fa-plus'></i></span>
											Womens
										</a>
									</h4>
								</div>
								<div id='womens' class='panel-collapse collapse'>
									<div class='panel-body'>
										<ul>
											<li><a href=''>Fendi</a></li>
											<li><a href=''>Guess</a></li>
											<li><a href=''>Valentino</a></li>
											<li><a href=''>Dior</a></li>
											<li><a href=''>Versace</a></li>
										</ul>
									</div>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Kids</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Fashion</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Households</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Interiors</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Clothing</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Bags</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='#'>Shoes</a></h4>
								</div>
							</div>
						</div><!--/category-productsr-->
					
						<div class='brands_products'><!--brands_products-->
							<h2>Nhãn Hiệu</h2>
							<div class='brands-name'>
								<ul class='nav nav-pills nav-stacked'>
									<li><a href=''> <span class='pull-right'>(50)</span>Maybeline</a></li>
									<li><a href=''> <span class='pull-right'>(56)</span>Mac</a></li>
									<li><a href=''> <span class='pull-right'>(27)</span>Hisu mùi chuối</a></li>
									<li><a href=''> <span class='pull-right'>(32)</span>Bun mùi mít</a></li>
									<li><a href=''> <span class='pull-right'>(5)</span>Moon mùi sầu riêng</a></li>
								
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
										<p>".$row['TenSP']."</p>
										<a href='product-details.php' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
										<a href='index.php?xem=cart&id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Đặt Mua</a>
									</div>
									<!--<div class='product-overlay'>
										<div class='overlay-content'>
											<h2>$56</h2>
											<p>Easy Polo Black Edition</p>
											<a href='#' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Add to cart</a>
										</div>
									</div>-->
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
