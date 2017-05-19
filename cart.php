
	
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
									<input class='cart_quantity_input' type='text' name='quantity' value='".$list['soluong']."' autocomplete='off' size='1' <disabled></disabled>
									<a class='cart_quantity_down' href='update_cart.php?tru=".$list['id']."'> - </a>
								</div>
							</td>
							<td class='cart_total'>
								<p class='cart_total_price'>".number_format($dong['GiaBan']*$list['soluong'])."VND </p>
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
				<div class="col-sm-6">
					<div class="chose_area">
						<ul>
							<li>
								<label>Địa Chỉ</label>
								<input class="cartinput" type="text" name="DiaChi" placeholder="" autocomplete="off">
							</li>
							<li>
								<input type="checkbox">
								<label>Use Gift Voucher</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Estimate Shipping & Taxes</label>
							</li>
						</ul>
						<ul class="user_info">
							<li class="single_field">
								<label>Loại Vận Chuyển:</label>
								<select>
									<option>United States</option>
									<option>Bangladesh</option>
									<option>UK</option>
									<option>India</option>
									<option>Pakistan</option>
									<option>Ucrane</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
								
							</li>
							<li>  </li>
							<li class="single_field">
								<label>Loại Thanh Toán:</label>
								<select>
									<option>Select</option>
									<option>Dhaka</option>
									<option>London</option>
									<option>Dillih</option>
									<option>Lahore</option>
									<option>Alaska</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
							
							</li>
							
						</ul>
						<a class="btn btn-default update" href="">Xác Nhận</a>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Tạm Tính <span>$59</span></li>
							<li>Giảm Giá <span>$2</span></li>
							<li>Phí Vận Chuyển  <span>0</span></li>
							<li>Tổng Tiền <span>$61</span></li>
						</ul>
							<a class="btn btn-default update" href="">Thanh Toán</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
