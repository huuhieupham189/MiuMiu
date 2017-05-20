
<section>
<div class="container">
	<div class="row">
  		<div class="col-sm-10"><h1></h1></div>
    	<div class="col-sm-2"></div>
    </div>
    <div class="row">
  		<div class="col-sm-3"><!--left col-->
              
          <ul class="list-group">
          <?php if(isset($_GET['id'])) 
                  {
                    $id=$_GET['id'];
                    $sql="select * from taikhoan where matk='$id'";
                    $ketqua=$conn->query($sql);
                    
                  while($dong=$ketqua->fetch_array()){
                    echo"
            <li class='list-group-item text-muted'>Thông Tin Cá Nhân</li>
            <li class='list-group-item text-right'><span class='pull-left'><strong>Tên </strong></span>".$dong['HoTen']."</li>
            <li class='list-group-item text-right'><span class='pull-left'><strong>Ngày Sinh</strong></span>".$dong['NgaySinh']."</li>
            <li class='list-group-item text-right'><span class='pull-left'><strong>Email</strong></span>".$dong['Email']."</li>'
           
          </ul> 
               
          <div class='panel panel-default'>
            <div class='panel-heading'>Địa chỉ nhận hàng mặc định <i class='glyphicon glyphicon-map-marker'></i></div>
            <div class='panel-body'>".$dong['DiaChi']."</div>
          </div>";} }?>
          
          
          <ul class="list-group">
            <li class="list-group-item text-muted">Thống Kê <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Số Mặt Hàng Đã Mua</strong></span> 125</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Số Mặt Hàng Kí Gửi</strong></span> 78</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Tổng Điểm Tích Lũy</strong></span> 13000</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Loại Tài Khoản</strong></span> Kim Cương </li>
            
          </ul> 
               
          <div class="panel panel-default">
            <div class="panel-heading">Social Media</div>
            <div class="panel-body">
            	<i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
            </div>
          </div>
          
        </div><!--/col-3-->
    	<div class="col-sm-9">
          
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#QLDH" data-toggle="tab">Quản Lý Đơn Hàng</a></li>
            <li><a href="#messages" data-toggle="tab">Thông Tin Khuyến Mãi</a></li>
            <li><a href="#settings" data-toggle="tab">Sửa Thông Tin </a></li>
          </ul>
              
          <div class="tab-content">
            <div class="tab-pane active" id="QLDH">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Mã Đơn Hàng</th>
                      <th>Ngày Đặt</th>
                      <th>Thành Tiền</th>
                      <th>Thanh Toán</th>
                      <th>Tình Trạng </th>
                      <th>Ghi Chú </th>
                    </tr>
                  </thead>
                  <?php
                  $sql="select * from taikhoan tk,hoadon hd where tk.matk=hd.matk and tk.matk='$id' ";
                  $kq=$conn->query($sql);
                  $stt=0;
                  while($dong=$kq->fetch_array()){
                  $stt++;
                  echo"<tbody id='items'>
                    <tr>
                      <td>".$stt."</td>
                      <td>".$dong['MaHD']."</td>
                      <td>".$dong['NgayLap']."</td>
                      <td>".number_format($dong['TongTien'])."VND</td>
                      <td>".number_format($dong['TongTien'])."VND</td>
                      <td>".$dong['TinhTrang']."</td>
                      <td>".$dong['GhiChu']."</td>
                    </tr>";}
                   ?> 
                   
                  </tbody>
                </table>
                <hr>
                <div class="row">
                  <div class="col-md-4 col-md-offset-4 text-center">
                  	<ul class="pagination" id="myPager"></ul>
                  </div>
                </div>
              </div><!--/table-resp-->
              
              
              
             </div><!--/tab-pane-->
             <div class="tab-pane" id="messages">
               
               <h2></h2>
               
               <ul class="list-group">
                  <li class="list-group-item text-muted">Inbox</li>
                  <li class="list-group-item text-right"><a href="#" class="pull-left">Giảm giá 50% các mặt hàng</a> 18.5.2017</li>
                  
                  
                </ul> 
               
             </div><!--/tab-pane-->
             <div class="tab-pane" id="settings">
            		
               	
                  <hr>
                  <form class="form" action="" method="post" id="registrationForm">
                      <div class="form-group">
                          <?php
                            $sql="select * from taikhoan where matk='$id'";
                    $ketqua=$conn->query($sql);
                          while ($dong=$ketqua->fetch_array()){

                        echo "<div class='col-xs-6'>
                              <label for='HoTen'><h4>Họ Và Tên</h4></label>
                              <input type='text' class='form-control' name='hoten' id='HoTen' value='".$dong['HoTen']."' title=''>
                          </div>
                      </div>
                      <div class='form-group'>
                          
                          <div class='col-xs-6'>
                            <label for='NgaySinh'><h4>Ngày Sinh</h4></label>
                              <input type='text' class='form-control' name='ngaysinh' id='NgaySinh' value='".$dong['NgaySinh']."' title=''>
                          </div>
                      </div>
          
                      <div class='form-group'>
                          
                          <div class='col-xs-6'>
                              <label for='SDT'><h4>Số Điện Thoại</h4></label>
                              <input type='text' class='form-control' name='sdt' id='SDT' value='".$dong['SDT']."' title=''>
                          </div>
                      </div>
          
                      <div class='form-group'>
                          <div class='col-xs-6'>
                             <label for='DiaChi'><h4>Địa Chỉ Nhận Hàng Mặt Định</h4></label>
                              <input type='text' class='form-control' name='diachi' id='DiaChi' value='".$dong['DiaChi']."' title=''>
                          </div>
                      </div>
                      <div class='form-group'>
                          
                          <div class='col-xs-6'>
                              <label for='email'><h4>Email</h4></label>
                              <input type='email' class='form-control' name='email' id='email' value='".$dong['Email']."' title='enter your email.'>
                          </div>
                      </div>
                      <div class='form-group'>
                          
                          <div class='col-xs-6'>
                              <label for='CMND'><h4>Chứng Minh Nhân Dân</h4></label>
                              <input type='text' class='form-control' id='CMND' name='cmnd' value='".$dong['CMND']."' title=''>
                          </div>
                      </div>";  }
                          ?>
                      <!--<div class="form-group">
                          
                          <div class="col-xs-6">
                              <label for="password"><h4>Mật Khẩu Mới</h4></label>
                              <input type="password" class="form-control" name="password" id="password" placeholder="Mật Khẩu Mới" title="enter your password.">
                          </div>
                      </div>
                      <div class="form-group">-->
                          
                          <!--<div class="col-xs-6">
                            <label for="password2"><h4>Mật Khẩu Xác Nhận</h4></label>
                              <input type="password" class="form-control" name="password2" id="password2" placeholder="Mật Khẩu Cũ" title="enter your password2.">
                          </div>
                      </div>-->
                      <div class="form-group">
                           <div class="col-xs-12">
                                <br>
                              	<button class="btn btn-lg btn-success" type="submit" name="save"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                            
                            </div>
                      </div>
              	</form>
              </div>
               
              </div><!--/tab-pane-->
          </div><!--/tab-content-->

        </div><!--/col-9-->
    </div><!--/row-->
</section>
<?php
if(isset($_POST['save']))
{
  $hoten=$_POST['hoten'];
  $ngaysinh=$_POST['ngaysinh'];
  
  $sdt=$_POST['sdt'];
  $diachi=$_POST['diachi'];
  $email=$_POST['email'];
  $cmnd=$_POST['cmnd'];
  $sql="update taikhoan set hoten='$hoten',ngaysinh='$ngaysinh',sdt='$sdt',diachi='$diachi',email='$email',cmnd='$cmnd' where matk='$id'";
  $conn->query($sql);
}
?>