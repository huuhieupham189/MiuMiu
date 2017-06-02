<?php
    //goi thu vien
    require "class.phpmailer.php";
 
// Khai báo tạo PHPMailer
$mail = new PHPMailer();
//Khai báo gửi mail bằng SMTP
$mail->IsSMTP();
//Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
// 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
// 1 = Thông báo lỗi ở client
// 2 = Thông báo lỗi cả client và lỗi ở server
$mail->SMTPDebug  = 2;
 
$mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
$mail->Host       = "smtp.gmail.com"; //host smtp để gửi mail
$mail->Port       = 587; // cổng để gửi mail
$mail->SMTPSecure = "tls"; //Phương thức mã hóa thư - ssl hoặc tls
$mail->SMTPAuth   = true; //Xác thực SMTP
$mail->Username   = "huuhieupham189@gmail.com"; // Tên đăng nhập tài khoản Gmail
$mail->Password   = "cmnd205909071"; //Mật khẩu của gmail
$mail->SetFrom("huuhieupham189@gmail.com", "Test Email"); // Thông tin người gửi
$mail->AddReplyTo("huuhieupham189@gmail.com","Test Reply");// Ấn định email sẽ nhận khi người dùng reply lại.
$mail->AddAddress("15520235@gm.uit.edu.vn", "John Doe");//Email của người nhận
$mail->Subject = "Tiêu đề thư"; //Tiêu đề của thư
$mail->MsgHTML("lorem"); //Nội dung của bức thư.
// $mail->MsgHTML(file_get_contents("email-template.html"), dirname(__FILE__));
// Gửi thư với tập tin html
$mail->AltBody = "This is a plain-text message body";//Nội dung rút gọn hiển thị bên ngoài thư mục thư.
$mail->AddAttachment("images/attact-tui.gif");//Tập tin cần attach
 
//Tiến hành gửi email và kiểm tra lỗi
if(!$mail->Send()) {
  echo "Có lỗi khi gửi mail: " . $mail->ErrorInfo;
} else {
  echo "Đã gửi thư thành công!";
}
?>