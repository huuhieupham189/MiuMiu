
	
	<section id="cart_items">
		<div class="container">
		
			<div class="table-responsive cart_info">
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Sản Phẩm</td>
							<td class="description"></td>
							<td class="price">Giá</td>
							<td class="quantity">Số Lượng</td>
							<td class="total">Thành Tiền</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
					<?php
					$thanhtien=0;
					if(isset($_SESSION['giohang'])){
					foreach($_SESSION['giohang'] as $list){
					$sql="select * from sanpham where masp='".$list['id']."'";
					$sanpham=$conn->query($sql);
					if($sanpham->num_rows>0){
					
					while($dong=$sanpham->fetch_array()){
						
					
						echo "<tr>
							<td class='cart_product'>
								<a href=''><img width=60 height=60 src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."'></a>
							</td>
							<td class='cart_description'>
								<h4><a href=''>".$dong['TenSP']."</a></h4>
							</td>
							<td class='cart_price'>
								<p>".number_format($dong['GiaBan'])."VND 	</p>
							</td>
							<td class='cart_quantity'>
								<div class='cart_quantity_button'>
									<a class='cart_quantity_up' href='update_cart.php?cong=".$list['id']."'> + </a>
									<input class='cart_quantity_input' type='text' name='quantity' value='".$list['soluong']."' autocomplete='off' size='1' disabled>
									<a class='cart_quantity_down' href='update_cart.php?tru=".$list['id']."'> - </a>
								</div>";
								$tien=$dong['GiaBan']*$list['soluong'];
								$thanhtien+=$tien;
							echo"</td>
							<td class='cart_total'>
								<p class='cart_total_price'>".number_format($tien)."VND </p>
							</td>
							<td class='cart_delete'>
								<a class='cart_quantity_delete' href='update_cart.php?xoa=".$list['id']."'><i class='fa fa-times'></i></a>
							</td>
						</tr>";}}}}
						

						?>
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>Bạn Muốn Thanh Toán ?</h3>
				<p>Vui lòng cung cấp đẩy đủ thông tin bên dưới.</p>
			</div>
			<div class="row">
				<form method="post" action="">
				<div class="col-sm-6">
					
					<div class="chose_area">
						<ul>
							<li>
							<?php
							 $id=$_SESSION['matk'];
                   			 $sql="select * from taikhoan where matk='$id'";
                    		$ketqua=$conn->query($sql);
							while($dong=$ketqua->fetch_array()){
							echo"
								<label>Địa Chỉ: </label>
								<input class='cartinput' type='text' name='diachi' value='".$dong['DiaChi']."' autocomplete='off'>";
								}
							?>
							</li>
							
							
						</ul>
						<ul class="user_info">
							<li class="single_field">
								<label>Loại Vận Chuyển:</label>
								<select name="vanchuyen">
									<?php
								$sql="select * from vanchuyen";
								$vanchuyen=$conn->query($sql);
								while($dong=$vanchuyen->fetch_array()){
									echo "<option value='".$dong['MaVC']."' >".$dong['TenVC']."</option>";}
								?>	
									
								</select>
								
							</li>
							
							<li class="single_field">
								<label>Loại Thanh Toán:</label>
								<select name="loaithanhtoan">
								<?php
								$sql="select * from thanhtoan";
								$thanhtoan=$conn->query($sql);
								while($dong=$thanhtoan->fetch_array()){
									echo "<option value='".$dong['MaTT']."' >".$dong['TenTT']."</option>";}
								?>	
								</select>
							
							</li>
							
						</ul>
						<ul>
							<li>
								<label>Ghi chú: </label>
								<input class="cartinput" type="text" name="ghichu" placeholder="" autocomplete="off">
								
							</li>
							
							
						</ul>
						
					</div>
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Tạm Tính <span>
							<?php if(isset($_SESSION['giohang'])) echo number_format($thanhtien)."VND";else echo "0VND";?></span></li>
							<li>Giảm Giá <span>
							<?php
							$sql="select * from taikhoan tk ,loaitk ltk where tk.loaitk=ltk.maloaitk and tendangnhap='".$_SESSION['ten']."'";
							$giamgia=$conn->query($sql);
							while($dong=$giamgia->fetch_array()){
								$a=$dong['ChietKhau'];
							}
							echo $a."%";
							?>
							</span></li>
							<li>Phí Vận Chuyển  <span>0</span></li>
							<li>Tổng Tiền <span><?php if(isset($_SESSION['giohang'])){
							$tongtien=$thanhtien*(1-$a);
							echo number_format($tongtien)."VND ";
							}else{ $tongtien=0; echo "0VND";}
							 ?></span></li>
						</ul>
							
								<button type="submit" name="thanhtoan" class="btn btn-default update">Thanh toán</button>
								<?php
									if(isset($_POST['thanhtoan'])){
									if($_POST['diachi']=="") echo "<a href='' style='color:red;'>Bạn chưa nhập địa chỉ!</a>";
									else if($tongtien==0) echo "<a href='' style='color:red;'>Bạn chưa đặt hàng!</a>";
									else{
									$vanchuyen=$_POST['vanchuyen'];
									$loaithanhtoan=$_POST['loaithanhtoan'];
									$matk=$_SESSION['matk'];
									$diachi=$_POST['diachi'];
									$ghichu=$_POST['ghichu'];
									$sqltr="insert into hoadon (MaVC,MaTT,MaTK,NgayLap,TongTien,DiaChi,TinhTrang,GhiChu)  values('$vanchuyen','$loaithanhtoan','$matk','".date('Y-m-d')."','$tongtien','$diachi','Chờ','$ghichu')";
									$ketqua=$conn->query($sqltr);
									if($ketqua){
										$lastid=$conn->insert_id;
										foreach($_SESSION['giohang'] as $list){
											$sql="select * from sanpham where masp='".$list['id']."'";
											$sanpham=$conn->query($sql);
											while($dong=$sanpham->fetch_array()){
												$tien=$dong['GiaBan']*$list['soluong'];
												$masp=$dong['MaSP'];
												$soluong=$list['soluong'];
												$sql="insert into CTHD value('$lastid','$masp','$soluong','$tien')";
												$conn->query($sql);
											}}
											echo "<a href='index.php'>Chúc mừng bạn đặt hàng thành công. Nhấp để mua tiếp!</a>";
											unset($_SESSION['giohang']);
										}
									}

								}
								?>
					</div>
					</div>
				</form>
			</div>
		</div>
	</section><!--/#do_action-->
