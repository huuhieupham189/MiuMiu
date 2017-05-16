<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta name="description" content="">
    <meta name="author" content="">-->
    <title>Shop Mỹ Phẩm MiuMiu</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/price-range.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
	<link href="../css/main.css" rel="stylesheet">
	<link href="../css/responsive.css" rel="stylesheet">
     
    <link rel="shortcut icon" href="images/icon/logo.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<?php
include('modules/config.php');

session_start();
if(isset($_POST['login'])){
	$username=$_POST['user'];
	$password=$_POST['pass'];
	$sql="SELECT * from taikhoan where tendangnhap='$username' and matkhau='$password' and loaitk='1' limit 1";
	
	$result=$conn->query($sql);
	if($result->num_rows > 0){
		$_SESSION['dangnhap']=$username;
		header('location:index.php');
	}
	
}
?>
<body>
<section id="form"><!--form-->
		
		<div class="container">
		<div class="breadcrumbs">
				
			</div>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-4">
					<div class="login-form"><!--login form-->
						<h2> <strong>ĐĂNG NHẬP</strong></h2>
						<form action="" method="post">
							<input type="text" placeholder="Tên Đăng Nhập" name="user" />
							<input type="password" placeholder="Mật Khẩu" name="pass" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<button type="submit" name="login" class="btn btn-default">Đăng Nhập</button>
						</form>
					</div><!--/login form-->
					<?php
					if(!isset($_SESSION['dangnhap'])&&isset($_POST['login'])) echo "<p><a style='color:red;'  href=''>Tài khoản hoặc mặt khẩu không đúng!</a></p>";
					?>
				</div>			
			</div>
		</div>
</section><!--/form-->
</body>	