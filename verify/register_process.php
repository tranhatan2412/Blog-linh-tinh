<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Lấy thông tin đăng ký
   $username = $_POST['username'];
   $email = $_POST['email'];
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu

   // Tạo mã xác nhận ngẫu nhiên gồm 6 chữ số
   $verification_code = rand(100000, 999999);

   // Lưu thông tin tạm thời vào session
   session_start();
   $_SESSION['pending_registration'] = [
      'username' => $username,
      'email' => $email,
      'password' => $password,
      'verification_code' => $verification_code,
      'expiry_time' => time() + 1800 // Hết hạn sau 30 phút
   ];

   // Gửi email xác nhận
   $mail = new PHPMailer(true);

   try {
      // Cài đặt server
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com'; // Hoặc SMTP server khác
      $mail->SMTPAuth = true;
      $mail->Username = 'your_email@gmail.com'; // Email của bạn
      $mail->Password = 'your_app_password'; // Mật khẩu ứng dụng
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;
      $mail->CharSet = 'UTF-8';

      // Người gửi và người nhận
      $mail->setFrom('your_email@gmail.com', 'BlogLinhTinh Admin');
      $mail->addAddress($email);

      // Nội dung email
      $mail->isHTML(true);
      $mail->Subject = 'Xác nhận đăng ký tài khoản - BlogLinhTinh';
      $mail->Body = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                <h2 style="color: #4CAF50;">Xác nhận đăng ký tài khoản</h2>
                <p>Xin chào <strong>' . htmlspecialchars($username) . '</strong>,</p>
                <p>Cảm ơn bạn đã đăng ký tài khoản tại BlogLinhTinh. Vui lòng sử dụng mã xác nhận sau để hoàn tất quá trình đăng ký:</p>
                <div style="padding: 15px; background-color: #f8f8f8; font-size: 24px; font-weight: bold; text-align: center; margin: 20px 0; letter-spacing: 5px;">
                    ' . $verification_code . '
                </div>
                <p>Mã xác nhận có hiệu lực trong 30 phút.</p>
                <p>Nếu bạn không thực hiện đăng ký tài khoản, vui lòng bỏ qua email này.</p>
                <p>Trân trọng,<br>BlogLinhTinh Team</p>
            </div>
        ';

      $mail->send();

      // Chuyển hướng đến trang xác nhận
      header('Location: verify.php');
      exit();
   } catch (Exception $e) {
      echo "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
   }
}
?>