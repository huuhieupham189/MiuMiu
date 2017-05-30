<?php
	if(isset($_POST['logout'])){
		unset($_SESSION['dangnhap']);
		header('location:login.php');
	}
?>
<div class="menu">
    	<ul>
        	<li><a href="index.php?quanly=loaisp&ac=them">Quản lý loại sp</a></li>
             <li><a href="index.php?quanly=hieusp&ac=them">Quản lý hiệu sp</a></li>
            <li><a href="index.php?quanly=sanpham&ac=them">Quản lý sản phẩm</a></li>
            <li><a href="index.php?quanly=hoadon&ac=lietke">Quản lý hóa đơn</a></li>
            <li><a href="index.php?quanly=nhansu&ac=lietke">Quản lý nhân sự</a></li>
            <li><a href="index.php?quanly=nhaphanphoi&ac=lietke">Quản lý nhà phân phối</a></li>
            
        </ul>
       
    </div>
    <form action="" method="post" enctype="multipart/form-data">
            <input type="submit" name="logout" value="Đăng xuất" style="background:#06F;color:#fff;width:200px;height:30px;" />
            </form>

 <form action="index.php?quanly=timkiem&ac=sp" method="post" enctype="multipart/form-data">
     <p><input type="text" name="masp" placeholder="Nhập mã sản phẩm..." id="timkiem" required="required" />
        <input type="submit" id="button_timkiem" name="timkiem" value="Tìm sản phẩm" />
        </p>
        </form>