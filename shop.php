
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
											<li><a href='index.php?xem=sanpham&id=7'>Kẻ Mày</a></li>
											<li><a href='index.php?xem=sanpham&id=8'>Kẻ Mắt</a></li>
											<li><a href='index.php?xem=sanpham&id=9'>Phấn Mắt</a></li>
											<li><a href='index.php?xem=sanpham&id=10'>Mascara</a></li>
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
											<li><a href='index.php?xem=sanpham&id=3'>Kem BB/CC</a></li>
											<li><a href='index.php?xem=sanpham&id=4'>Kem Nền</a></li>
											<li><a href='index.php?xem=sanpham&id=5'>Phấn</a></li>
											<li><a href='index.php?xem=sanpham&id=6'>Tạo Khối</a></li>
											
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
											<li><a href='index.php?xem=sanpham&id=1'>Son Môi </a></li>
											<li><a href='index.php?xem=sanpham&id=2'>Son Dưỡng </a></li>
										</ul>

									</div>

								</div>
							</div>
							
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='index.php?xem=sanpham&id=11'>Tẩy Trang</a></h4>
								</div>
							</div>
							<div class='panel panel-default'>
								<div class='panel-heading'>
									<h4 class='panel-title'><a href='index.php?xem=sanpham&id=12'>Mặt Nạ</a></h4>
								</div>
							</div>
							
						</div><!--/category-productsr-->
					
						<div class='brands_products'><!--brands_products-->
							<h2>Nhãn Hiệu</h2>
							<div class='brands-name'>
								<ul class='nav nav-pills nav-stacked'>
									<?php
									$sql="SELECT TenThuongHieu, th.MaThuongHieu,count(sp.MaSP) as SoLuong
										from thuonghieu th,sanpham sp
										where th.mathuonghieu=sp.mathuonghieu
										GROUP by TenThuongHieu";
									$ketqua=$conn->query($sql);
									while($dong=$ketqua->fetch_array()){
										echo"
									<li><a href='index.php?xem=sanpham&id=".$dong['MaThuongHieu']."&ten=".$dong['TenThuongHieu']."'> <span class='pull-right'>".$dong['SoLuong']."</span>".$dong['TenThuongHieu']."</a></li>";
									}
								?>
								</ul>
							</div>
						</div><!--/brands_products-->
						
			
						
					</div>
				</div>
				<div class='col-sm-9 padding-right'>
					<div class='features_items'><!--features_items-->
						
				<?php 
				include("sanpham.php");
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
