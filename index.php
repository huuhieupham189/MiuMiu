
<?php
session_start();
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 
    <meta name="description" content="">
    <meta name="author" content="">
    <!--<meta name="description" content="">
    <meta name="author" content="">-->
    <title>Shop Mỹ Phẩm MiuMiu</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
     
    <link rel="shortcut icon" href="images/icon/logo.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body >
	<header id="header"><!--header-->
	
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/home/homelogo.png" alt="" /></a>
						</div>
					</div>
					<div class="col-sm-8">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								<?php if(isset($_SESSION['ten'])){ $matk=$_SESSION['matk']; echo "<li><a href='index.php?xem=profile&id=$matk'><i class='fa fa-user'></i> Xin chào ".$_SESSION['ten']."</a></li>
								<!--/ <li><a href='index.php?xem=checkout'><i class='fa fa-crosshairs'></i> Checkout</a></li>-->
								";if(isset($_SESSION['giohang'])) $count=count($_SESSION['giohang']);else $count=''; echo"<li><a href='index.php?xem=cart'><i class='fa fa-shopping-cart'> ".$count."</i> Giỏ Hàng</a></li>
								<li><a href='index.php?xem=logout'><i class='fa fa-sign-out' aria-hidden='true'></i> Đăng xuất</a></li>";}?>
								<?php if(!isset($_SESSION['ten'])) echo "<li><a href='index.php?xem=login'><i class='fa fa-lock'></i> Đăng Nhập</a></li>";?>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" class="active">TRANG CHỦ</a></li>
								<li><a href="index.php?xem=sanpham">SẢN PHẨM</a></li> 
							</ul>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="search_box pull-right">
							<input type="text" placeholder="Nội dung tìm kiếm"/>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	<?php
	include("content.php")
	?>
	
	
	<footer class="footer-distributed">

			<div class="footer-left">

				<h3>MiuMiu<span>Shop</span></h3>

				<p class="footer-links">
					<a href="index.php">Trang Chủ</a>
					·
					<a href="index.php?xem=sanpham">Sản Phẩm</a>
					·
					<a href="#">Tài Khoản</a>
					
				</p>

				<p class="footer-company-name">HTCL-UIT &copy; 2015</p>
			</div>

			<div class="footer-center">

				<div>
					<i class="fa fa-map-marker"></i>
					<p><span>Khu Phố 6, Phường Linh Trung</span> Quận Thủ Đức, TP. Hồ Chí Minh</p>
				</div>

				<div>
					<i class="fa fa-phone"></i>
					<p> (08) 372 52002</p>
				</div>

				<div>
					<i class="fa fa-envelope"></i>
					<p><a>MiuMiuShop@gmail.com</a></p>
				</div>

			</div>

			<div class="footer-right">

				<p class="footer-company-about">
					<span>Thông Tin Về MiuMiuShop</span>
					MiuMiu là một cửa hàng kinh doanh chủ yếu là mặt hàng mĩ phẩm ,cung cấp cho khách hàng những sản phẩm tốt nhất với giá rẻ nhất.
				</p>

				<div class="footer-icons">

					<a href="#"><i class="fa fa-facebook"></i></a>
					<a href="#"><i class="fa fa-twitter"></i></a>
					<a href="#"><i class="fa fa-linkedin"></i></a>
					<a href="#"><i class="fa fa-github"></i></a>

				</div>

			</div>

		</footer> <!--/footer-->

  
    
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
</body>
</html>