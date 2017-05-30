<!DOCTYPE>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	 <meta name="description" content="">
    <meta name="author" content="">
<link href="../css/main.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="style/css.css" />

 
   
<title>Trang quản lý website</title>

</head>
<?php
 session_start();
 if(!isset($_SESSION['dangnhap'])&&$_SESSION['loaitk']){
	 header('location:login.php');
 }
?>
<body>
<div class="wrapper">
	<?php
		include('modules/config.php');
		include('modules/header.php');
		include('modules/menu.php');
		include('modules/content.php');
		include('modules/footer.php');
	?>
   
<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="js/jquery-3.2.1.js"></script>
<script type="text/javascript" src="js/delete.js"></script>
<script type="text/javascript" src="js/tinymce/js/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="js/tinymce/js/tinymce/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>
</div>
</body>
</html>