<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<link rel="stylesheet" type="text/css" href="style/css.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
   
<title>Trang quản lý website</title>

</head>
<?php
 session_start();
 if(!isset($_SESSION['dangnhap'])){
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