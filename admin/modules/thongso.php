<div class="page-content">
					
						<div class="page-header">
							<h1>
								THÔNG SỐ
							
							</h1>
						</div><!-- /.page-header -->

						<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->
								<div class="alert alert-block alert-success">
									<button type="button" class="close" data-dismiss="alert">
										<i class="ace-icon fa fa-times"></i>
									</button>

									<i class="ace-icon fa fa-check green"></i>

									Xin chào
									<strong class="green">
										<?php echo $_SESSION['dangnhap']?>
										
									</strong>,
									chúc bạn một ngày tốt lành!
								</div>

								<?php include('thongkechitiet.php'); ?>

								<!-- #section:custom/extra.hr -->
								<div class="hr hr32 hr-dotted"></div>

								<!-- /section:custom/extra.hr -->
								<?php include('thongkesanpham.php'); ?>

								<div class="hr hr32 hr-dotted"></div>
									
							
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
