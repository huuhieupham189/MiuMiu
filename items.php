<div class="category-tab">
						<div class='col-sm-12'>
							<ul class='nav nav-tabs'>
						<?php
						$sql="select * from thuonghieu limit 8";
						$ketqua=$conn->query($sql);						
						while($dong=$ketqua->fetch_array()){
							$math=$dong['MaThuongHieu'];
							if($dong['MaThuongHieu']==1) echo"<li class='active' ><a href='index.php#".$dong['MaThuongHieu']."' data-toggle='tab'>".$dong['TenThuongHieu']."</a></li>";
						else echo "<li><a href='#".$math."' data-toggle='tab'>".$dong['TenThuongHieu']."</a></li>";
						}
						?>
						</ul>
						</div>
						<div class="tab-content">
						<?php
						$sql="select * from thuonghieu limit 8";
						$ketqua=$conn->query($sql);						
						while($dong=$ketqua->fetch_array()){
							if($dong['MaThuongHieu']==1){
							  echo"<div class='tab-pane fade active in' id='".$dong['MaThuongHieu']."' >";
								$sqltr="select * from sanpham where mathuonghieu='".$dong['MaThuongHieu']."' limit 3";
								$result=$conn->query($sqltr);
								while ($row=$result->fetch_array()){
								echo"<div class='col-sm-4'>
									<div class='product-image-wrapper'>
										<div class='single-products'>
											<div class='productinfo text-center'>
												<img  src='admin/modules/quanlysanpham/uploads/".$row['HinhAnh']."' width='250' height='250'/>
										<h2>".number_format($row['GiaBan'])."VND"."</h2>
										<p><strong>".$row['TenSP']."<strong></p>
										<p>".$row['TenCT']."</p>
											<a href='index.php?xem=product&id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
											<a href='update_cart.php?id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Đặt Mua</a>
										</div>
											
										</div>
									</div>
								</div>";}
								
							echo"</div>";}
							else {echo"<div class='tab-pane fade' id='".$dong['MaThuongHieu']."'>";
								$sqltr="select * from sanpham where mathuonghieu='".$dong['MaThuongHieu']."' limit 3";
								$result=$conn->query($sqltr);
								while ($row=$result->fetch_array()){
								echo"<div class='col-sm-4'>
									<div class='product-image-wrapper'>
										<div class='single-products'>
											<div class='productinfo text-center'>
												<img  src='admin/modules/quanlysanpham/uploads/".$row['HinhAnh']."' width='250' height='250'/>
										<h2>".number_format($row['GiaBan'])."VND"."</h2>
										<p><strong>".$row['TenSP']."<strong></p>
										<p>".$row['TenCT']."</p>
												<a href='index.php?xem=product&id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-plus'></i>Xem Thêm</a>
												<a href='update_cart.php?id=".$row['MaSP']."' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Đặt Mua</a>
										</div>
											
										</div>
									</div>
								</div>";}
								
							echo"</div>";}}?>
								
						</div>
					</div><!--/category-tab-->