<?php
include("config.php");
$sql_hoadon="select * from hoadon";
$ketqua=$conn->query($sql_hoadon);
$hoadon=$ketqua->num_rows;

$sql_sanpham="select * from sanpham";
$ketqua=$conn->query($sql_sanpham);
$sanpham=$ketqua->num_rows;

$sql_taikhoan="select * from taikhoan where loaitk<6";
$ketqua=$conn->query($sql_taikhoan);
$taikhoan=$ketqua->num_rows;

$sql_hoadon="select * from hoadon where tinhtrang='đã duyệt'";
$ketqua=$conn->query($sql_hoadon);
$doanhthu=0;
while($dong=$ketqua->fetch_array()){
    $doanhthu+=$dong['TongTien'];
}

?>
<div class="row">
									<div class="space-6"></div>
								
									<div class="col-sm-7 infobox-container">
										<!-- #section:pages/dashboard.infobox -->
										<div class="infobox infobox-green">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-comments"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">320</span>
												<div class="infobox-content">Đánh giá sản phẩm</div>
											</div>

									
										</div>

										<div class="infobox infobox-blue">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-facebook"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number">110</span>
												<div class="infobox-content">Lượt theo dõi facebook</div>
											</div>

										
										</div>

										<div class="infobox infobox-pink">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-shopping-cart"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"><?php echo $hoadon;?></span>
												<div class="infobox-content">Hóa đơn thanh toán</div>
											</div>
											
										</div>

										<div class="infobox infobox-red">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-flask"></i>
											</div>

											<div class="infobox-data">
												<span class="infobox-data-number"><?php echo $sanpham;?></span>
												<div class="infobox-content">Sản phẩm các loại</div>
											</div>
										</div>

										<div class="infobox infobox-orange2">
											<!-- #section:pages/dashboard.infobox.sparkline -->
											<div class="infobox-icon">
												<i class="ace-icon fa fa-user"></i>
											</div>

											<!-- /section:pages/dashboard.infobox.sparkline -->
											<div class="infobox-data">
												<span class="infobox-data-number"><?php echo $taikhoan;?></span>
												<div class="infobox-content">Tài khoản thành viên</div>
											</div>

											
										</div>

										<div class="infobox infobox-orange2">
											<div class="infobox-icon">
												<i class="ace-icon fa fa-heart"></i>
											</div>

											
											<div class="infobox-data">
												<span class="infobox-data-number">95%</span>
												<div class="infobox-content">Khách hàng tin tưởng</div>
											</div>
										</div>

										<!-- /section:pages/dashboard.infobox -->
										<div class="space-6"></div>

										<!-- #section:pages/dashboard.infobox.dark -->
										

										<div class="infobox infobox-blue  infobox-dark">
											<!-- #section:pages/dashboard.infobox.sparkline -->
											<div class="infobox-chart">
												<span class="sparkline" data-values="3,4,2,3,4,4,2,2"></span>
											</div>

											<!-- /section:pages/dashboard.infobox.sparkline -->
											<div class="infobox-data">
											<div class="infobox-content">Doanh Thu</div>
												<strong><div class="infobox-content"><?php echo number_format($doanhthu);?></div></strong>
											</div>
										</div>

										<div class="infobox infobox-grey  infobox-dark">
											<div class="infobox-chart">
												<span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
											</div>

											<!-- /section:pages/dashboard.infobox.sparkline -->
											<div class="infobox-data">
											<strong>	<span class="infobox-data-number">6,251</span></strong>
												<div class="infobox-content">Lượt truy cập</div>
											</div>
										</div>

										<!-- /section:pages/dashboard.infobox.dark -->
									</div>

									<div class="vspace-12-sm"></div>

								
								</div><!-- /.row -->