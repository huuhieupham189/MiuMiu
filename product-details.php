<section>
		<div class="container">
			<div class="row">
				
				<!--<div class="col-sm-1"></div>-->
				<div class="col-sm-12 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-4">
						<?php 
						$sqll="select TiSo from khuyenmai where MaSP=".$_GET['id']." and NgayKT >= CURDATE()";
						$kq=$conn->query($sqll);
						$km=0;
						while ($d=$kq->fetch_array()) {
							   $km=$d['TiSo'];}
						if(isset($_GET['id'])){
							$sql="select * from sanpham sp, thuonghieu th where th.mathuonghieu=sp.mathuonghieu and masp='".$_GET['id']."'";
							$ketqua=$conn->query($sql);
							while($dong=$ketqua->fetch_array()){
								$giakm=$dong['GiaBan'];
							$tile = $km*100;
							if ($km > 0)
							echo"
								
								<div class='view-product'>
								<img style='border-style: none;width:100px; height:auto; position:absolute;margin-left:250px;'src='images/icon/sale.ico'>
								<img src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' alt='' />								
							</div>							
						</div>
						<div class='col-sm-8'>
							<div class='product-information'><!--/product-information-->";	
						elseif ($dong['SLTon']==0) 
						echo"<div class='view-product'>
							<img style='border-style: none;width:100px; height:auto; position:absolute;margin-left:250px;'src='images/icon/soldout.png'>
								<img src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' alt='' />								
							</div>							
						</div>
						<div class='col-sm-8'>";

						else echo"
							<div class='view-product'>
								<img src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' alt='' />								
							</div>							
						</div>
						<div class='col-sm-8'>";
								
								
									
						 	
						 if ($km > 0) 
						 { $giakm= $giakm*(1-$km);
						 echo"	
						 	<h2><strong>".$dong['TenSP']."</strong> : ".$dong['TenCT']." <span style='color : red;'class='glyphicon glyphicon-arrow-down'><strong>".$tile."%</strong></span></h2>	 
								<span>
									<span style='text-decoration: line-through; color:black; font-size:15pt;'><small><center>".number_format($dong['GiaBan'])." VNĐ</center></small></span>
									<div class='col-sm-12';></div>
									<span>".number_format($giakm)." VNĐ</span>
								</span>";}
						else echo"
								<h2><strong>".$dong['TenSP']."</strong> : ".$dong['TenCT']." </h2>
								<span>
									<h2>".number_format($dong['GiaBan'])." VNĐ</h2>
								</span>";

								if ($dong['SLTon'] > 0)
								echo"
									<form action='update_cart.php?id=".$dong['MaSP']."' method='post'>
									<label>Số lượng: <input type='number' max=".$dong['SLTon']." min=1 name='soluong' /></label>
									<button type='submit' name='dathang' class='btn btn-fefault cart'>
										<i class='fa fa-shopping-cart'></i>' 
										 MUA NGAY
									</button></form>
								<p><b>Hiện còn: </b>".$dong['SLTon']."</p>
								<p><b>Thương hiệu: </b>".$dong['TenThuongHieu']."</p>";
							else echo " <form >
											<label>Số lượng: <input type='text' name='soluong' disabled /></label>
												<button  class='btn btn-danger' disabled> HẾT HÀNG :( </button>
										</form>
								<div class='col-sm-12' style='height:10px;'></div>		
								<div class='alert alert-warning col-sm-10'>
  									<strong>Xin Lỗi !</strong> Chúng tôi sẽ cập nhật thêm hàng sớm nhất có thể.
								</div>";
								
						
								}}?>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<div class="col-sm-12">
							<?php 
						if(isset($_GET['id'])){
							$sql="select * from sanpham sp, thuonghieu th where th.mathuonghieu=sp.mathuonghieu and masp='".$_GET['id']."'";
							$ketqua=$conn->query($sql);
							while($dong=$ketqua->fetch_array()){
							echo"
                            <ul class='nav nav-tabs'>
                                <li class='active' ><a href='#details' data-toggle='tab'>Thông Tin Chi Tiết</a></li>
                                <li><a href='#sale' data-toggle='tab'>Thông Tin Khuyến Mãi</a></li>
                                <li ><a href='#reviews' data-toggle='tab'>Đánh Giá </a></li>
                            </ul>
                        </div>
                        <div class='tab-content'>
                            <div class='tab-pane fade active in' id='details' >
                                <div class='col-sm-1'></div>
								<div class='col-sm-10'>
									<p><strong>".$dong['TenSP']."</strong> : ".$dong['TenCT']."  </p>
									<p><strong>THƯƠNG HIỆU </strong> : ".$dong['TenThuongHieu']."  </p>
									<p><strong>NƠI SẢN XUẤT</strong> : ".$dong['NoiSX']."  </p>
									<p><strong>DUNG TÍCH   </strong> : ".$dong['DungTich']."  </p>
									<p> ".$dong['TTCT']."  </p>
									<p><strong>ƯU ĐIỂM     </strong> : ".$dong['UuDiem']."  </p>
									<p><strong>NHƯỢC ĐIỂM  </strong> : ".$dong['NhuocDiem']."  </p>

								</div>
								

								
                            </div>
                            
                           
							 <div class='tab-pane fade' id='sale' >";
                           $sql1="select * from khuyenmai where MaSP=".$_GET['id']." order by NgayKT DESC";
							$kqq=$conn->query($sql1);
							$num=$kqq->num_rows;
							if ($num>0 ){ echo"
								<div class='col-sm-1'></div>
								<div class='col-sm-10'>
									<h2>Thông Tin Khuyến Mãi</h2>
									<h2></h2>            
									<table class='table table-striped'>
										<thead>
										<tr>
											<th>Đợt Khuyến Mãi</th>
											<th>Ngày Bắt Đầu</th>
											<th>Ngày Kết Thúc</th>
											<th>Giảm Giá</th>
											<th>Trạng Thái</th>
										</tr>
										</thead>
										<tbody>";
							
							while ($dt=$kqq->fetch_array()) {
								if ($dt['NgayKT'] >= DATE("Y-m-d")) {$TrangThai="Đang Diễn Ra"; $bt="danger";}
									else {$TrangThai="Đã Hết Hạn";$bt="success";}
									
								$phantram=$dt['TiSo']*100;
							   echo"	<tr>
											<td>".$dt['TenKM']."</td>
											<td>".$dt['NgayBD']."</td>
											<td>".$dt['NgayKT']."</td>
											<td>".$phantram."%</td>
											<td><button disabled  class='btn btn-".$bt."'>$TrangThai</button></td>
										</tr>";
							   		 }
								echo"
										</tbody>
									</table>
									</div>
							
							";}
							else echo" Sản Phẩm Này Chưa Có Chương Trình Khuyến Mãi !";
						
                           echo"
						    </div>
                            
							
                            <div class='tab-pane fade ' id='reviews' >
                                <div class='col-sm-12'>
                                    <ul>
                                        <li><a href=''><i class='fa fa-user'></i>EUGEN</a></li>
                                        <li><a href=''><i class='fa fa-clock-o'></i>12:41 PM</a></li>
                                        <li><a href=''><i class='fa fa-calendar-o'></i>31 DEC 2014</a></li>
                                    </ul>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                                    <p><b>Write Your Review</b></p>
                                    
                                    <form action='#'>
                                        <span>
                                            <input type='text' placeholder='Your Name'/>
                                            <input type='email' placeholder='Email Address'/>
                                        </span>
                                        <textarea name='' ></textarea>
                                        <b>Rating: </b> <img src='images/product-details/rating.png' alt='' />
                                        <button type='button' class='btn btn-default pull-right'>
                                            Submit
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                        </div>
                    </div><!--/category-tab-->

";}}?>	


					
			
					
				</div>
			</div>
		</div>
	</section>