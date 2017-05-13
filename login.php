


<section id="form"><!--form-->
		
		<div class="container">
		<div class="breadcrumbs">
				
			</div>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2> <strong>ĐĂNG NHẬP</strong></h2>
						<form action="" method="post">
							<input type="text" name="user" placeholder="Tên Đăng Nhập" autocomplete="off"/>
							<input type="password" name="pass" placeholder="Mật Khẩu" autocomplete="off"/>
							<span>
								<input type="checkbox" class="checkbox"> 
								Ghi nhớ đăng nhập
							</span>
							<button type="submit" name="login" class="btn btn-default">Đăng Nhập</button>
						</form>
					
					<?php					
						if(isset($_SESSION['ten']))
						echo "<a href='index.php'>Chúc mừng ".$_SESSION['ten']." đã đăng nhập thành công.";
					 //kiểm tra đăng nhập
					 ?> 
					</div><!--/login form-->
					

				</div>
				
				<div class="col-sm-1">
					<h2 class="or"></h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form" ><!--sign up form-->
						<h2><strong>ĐĂNG KÝ</strong></h2>
				
						<form action="" method="post" >
							<input type="text" name="tendangnhap" placeholder="Tên Đăng Nhập"/>
							<input type="email" name="email" placeholder="Email"/>
							<input type="password" name="matkhau" placeholder="Mật Khẩu"/>
							<button type="submit" name="dangky" class="btn btn-default">Đăng Ký</button>
						</form>
					</div><!--/sign up form-->
					<?php
					if(isset($_POST['dangky']))
					{
						$tendangnhap=$_POST['tendangnhap'];
						$matkhau=$_POST['matkhau'];
						$email=$_POST['email'];
					$sqlstr="INSERT into taikhoan (username,password,loai,email) VALUE ('$tendangnhap','$matkhau','nguoidung','$email')";
					$result=$conn->query($sqlstr);
					if($result)
					echo "<p><a href='#'>Chuc mung ban dang ki thanh cong!</a></p>";
					//đăng kí tài khoản
					}
					
					?>
				</div>
			</div>
		</div>
</section><!--/form-->
	