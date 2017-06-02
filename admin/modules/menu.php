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

						
						</ul>
					</li>

						<li class="">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-credit-card"></i>
							<span class="menu-text">Quản Lý Tài Chính </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="">
								<a href="form-elements.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Form Elements
								</a>

								<b class="arrow"></b>
							</li>

							<li class="">
								<a href="form-elements-2.html">
									<i class="menu-icon fa fa-caret-right"></i>
									Form Elements 2
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


				

					<li class="">
						<a href="calendar.html" >
							<i class="menu-icon fa fa-calendar"></i>

							<span class="menu-text">
								Calendar

								<!-- #section:basics/sidebar.layout.badge -->
								<span class="badge badge-transparent tooltip-error" title="2 Important Events">
									<i class="ace-icon fa fa-exclamation-triangle red bigger-130"></i>
								</span>

								<!-- /section:basics/sidebar.layout.badge -->
							</span>
						</a>

						<b class="arrow"></b>
					</li>

				
				</ul><!-- /.nav-list -->

			
			</div>



    

 