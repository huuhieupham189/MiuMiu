<section>
		<div class="container">
			<div class="row">
				
				<!--<div class="col-sm-1"></div>-->
				<div class="col-sm-12 padding-right">
					<div class="product-details"><!--product-details-->
						<div class="col-sm-4">
						<?php 
						if(isset($_GET['id'])){
							$sql="select * from sanpham sp, thuonghieu th where th.mathuonghieu=sp.mathuonghieu and masp='".$_GET['id']."'";
							$ketqua=$conn->query($sql);
							while($dong=$ketqua->fetch_array()){
							echo"<div class='view-product'>
								<img src='admin/modules/quanlysanpham/uploads/".$dong['HinhAnh']."' alt='' />								
							</div>							
						</div>
						<div class='col-sm-8'>
							<div class='product-information'><!--/product-information-->
								
								<h2><strong>".$dong['TenSP']."</strong> : ".$dong['TenCT']."</h2>
								
								
								<span>
									<span>".number_format($dong['GiaBan'])."VNĐ</span>
									
								</span>
								<form action='update_cart.php?id=".$dong['MaSP']."' method='post'>
								<label>Số lượng: <input type='text' name='soluong' /></label>
									
									<button type='submit' name='dathang' class='btn btn-fefault cart'>
										<i class='fa fa-shopping-cart'></i>' 
										 MUA NGAY
									</button></form>
								<p><b>Hiện còn: </b>".$dong['SLTon']."</p>
								<p><b>Thương hiệu: </b>".$dong['TenThuongHieu']."</p>";
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
                                <li><a href='#companyprofile' data-toggle='tab'>Thông Tin Thương Hiệu</a></li>
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
                            
                            <div class='tab-pane fade' id='companyprofile' >
                                
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