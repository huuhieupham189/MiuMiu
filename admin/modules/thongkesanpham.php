<?php include('config.php');?>
<div class="row">
									<div class="col-sm-6">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-star orange"></i>
													Sản Phẩm Nổi Bật
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Tên SP
																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Giá SP
																</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Lượng Tồn<ng></ng>
																</th>
															</tr>
														</thead>
                                                        <?php
                                                        $sql_lietkesp=" select TenSP,GiaBan,SLTon,sum(cthd.SoLuong) as soluong
                                                                        from sanpham left join cthd on sanpham.MaSP=cthd.MaSP ,thuonghieu,loaisp
                                                                        where loaisp.maloaisp=sanpham.maloaisp and thuonghieu.mathuonghieu=sanpham.mathuonghieu 
                                                                        GROUP by TenSP,GiaBan
                                                                        order by soluong DESC limit 5";
                                                                        $ketqua=$conn->query($sql_lietkesp);
                                                                        while($dong=$ketqua->fetch_array()){
														echo '<tbody>
															<tr>
																<td> '.$dong['TenSP'].' </td>

																<td>
																	
																	<b class="green">'.number_format($dong['GiaBan']).'<br><center>VND</center></b>
																</td>

																<td class="hidden-480">
																	<span class="light-orange"><strong><center>' .$dong['SLTon']. '</center></strong></span>
																</td>
															</tr>';
                                                            ?>
<?php }?>
															
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->

									<div class="col-sm-6">
										<div class="widget-box transparent">
											<div class="widget-header widget-header-flat">
												<h4 class="widget-title lighter">
													<i class="ace-icon fa fa-signal"></i>
													Khách Hàng Thân Thiết
												</h4>

												<div class="widget-toolbar">
													<a href="#" data-action="collapse">
														<i class="ace-icon fa fa-chevron-up"></i>
													</a>
												</div>
											</div>

											<div class="widget-body">
												<div class="widget-main no-padding">
													<table class="table table-bordered table-striped">
														<thead class="thin-border-bottom">
															<tr>
																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Tên Tài Khoản
																</th>

																<th>
																	<i class="ace-icon fa fa-caret-right blue"></i>Điểm Thưởng
																</th>

																<th class="hidden-480">
																	<i class="ace-icon fa fa-caret-right blue"></i>Loại Tài Khoản<ng></ng>
																</th>
															</tr>
														</thead>
                                                        <?php
                                                        $sql_lietkesp=" select TenDangNhap,DiemThuong,TenLoaiTK
                                                                        from taikhoan left join loaitk on taikhoan.LoaiTK=loaitk.MaLoaitk
																		where maloaitk < 6
                                                                        order by diemthuong DESC limit 5";
                                                                        $ketqua=$conn->query($sql_lietkesp);
                                                                        while($dong=$ketqua->fetch_array()){
														echo '<tbody>
															<tr>
																<td> '.$dong['TenDangNhap'].' </td>

																<td>
																	
																	<b class="light-orange">'.number_format($dong['DiemThuong']).'</b>
																</td>

																<td class="hidden-480">
																	<span class="label label-success arrowed-right arrowed-in"></strong>'.$dong['TenLoaiTK'].'</strong></span>
																</td>
															</tr>';?>
<?php }?>
															
														</tbody>
													</table>
												</div><!-- /.widget-main -->
											</div><!-- /.widget-body -->
										</div><!-- /.widget-box -->
									</div><!-- /.col -->
								</div><!-- /.row -->