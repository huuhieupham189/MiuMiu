<?php
	if(isset($_POST['logout'])){
		session_destroy();
		header('location:login.php');
	}
?>

<div id="sidebar" class="sidebar responsive">
				
				<ul class="nav nav-list">
					<li class="">
						<a href="index.php?quanly=thongso&ac=lietke">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Thông Số </span>
						</a>

						<b class="arrow"></b>
					</li>

						<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-user"></i>
							<span class="menu-text">
								Quản Lý Nhân Sự
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							

							<li class="">
								<a href="index.php?quanly=nhansu&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Tài Khoản
								</a>

								<b class="arrow"></b>
							</li>

							
						</ul>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-shopping-cart"></i>
							<span class="menu-text"> Quản Lý Bán Hàng </span>
                                 <b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="index.php?quanly=hoadon&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Hóa Đơn
                               
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="index.php?quanly=kigui&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Kí Gửi
                               
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="index.php?quanly=khuyenmai&ac=tao">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Khuyến Mãi
                               
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>

					<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text">Quản Lý Kho Hàng </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="index.php?quanly=loaisp&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Loại Sản Phẩm
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="index.php?quanly=hieusp&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Thương Hiệu
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="index.php?quanly=sanpham&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Sản Phẩm
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="index.php?quanly=nhaphanphoi&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Nhà Phân Phối
								</a>

								<b class="arrow"></b>
							</li>
								<li class="">
								<a href="index.php?quanly=nhapkho&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Nhập Kho
								</a>

								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="index.php?quanly=thanhtoan&ac=lietkedh">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Thanh Toán
								</a>

								<b class="arrow"></b>
							</li>

						
						</ul>
					</li>

						<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-credit-card"></i>
							<span class="menu-text">Quản Lý Tài Vụ </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="index.php?quanly=congno&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Công Nợ
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="index.php?quanly=soluongban&ac=lietke">
									<i class="menu-icon fa fa-caret-right"></i>
									Quản Lý Số Lượng Bán
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="form-wizard.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Wizard &amp; Validation
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="wysiwyg.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Wysiwyg &amp; Markdown
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="dropzone.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Dropzone File Upload
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>


				

				

				
				</ul><!-- /.nav-list -->

			
			</div>



    

 