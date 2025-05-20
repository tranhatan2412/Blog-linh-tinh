<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();
if (!isset($_SESSION['pending_registration'])) {
   header('Location: index.php');
   exit();
}

// Tạo mã xác nhận mới
$verification_code = rand(100000, 999999);
$_SESSION['pending_registration']['verification_code'] = $verification_code;
$_SESSION['pending_registration']['expiry_time'] = time() + 1800; // Thêm 30 phút

$username = $_SESSION['pending_registration']['username'];
$email = $_SESSION['pending_registration']['email'];

// Gửi email xác nhận
$mail = new PHPMailer(true);

try {
   // Cài đặt server (giống code ở register_process.php)
   $mail->isSMTP();
   $mail->Host = 'smtp.gmail.com';
   $mail->SMTPAuth = true;
   $mail->Username = 'your_email@gmail.com';
   $mail->Password = 'your_app_password';
   $mail->SMTPSecure = 'tls';
   $mail->Port = 587;
   $mail->CharSet = 'UTF-8';

   // Người gửi và người nhận
   $mail->setFrom('your_email@gmail.com', 'BlogLinhTinh Admin');
   $mail->addAddress($email);

   // Nội dung email
   $mail->isHTML(true);
   $mail->Subject = 'Mã xác nhận mới - BlogLinhTinh';
   $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <h2 style="color: #4CAF50;">Mã xác nhận mới</h2>
            <p>Xin chào <strong>' . htmlspecialchars($username) . '</strong>,</p>
            <p>Đây là mã xác nhận mới của bạn:</p>
            <div style="padding: 15px; background-color: #f8f8f8; font-size: 24px; font-weight: bold; text-align: center; margin: 20px 0; letter-spacing: 5px;">
                ' . $verification_code . '
            </div>
            <p>Mã xác nhận có hiệu lực trong 30 phút.</p>
            <p>Trân trọng,<br>BlogLinhTinh Team</p>
        </div>
    ';

   $mail->send();

   // Chuyển hướng về trang xác nhận với thông báo
   header('Location: verify.php?message=resent');
   exit();
} catch (Exception $e) {
   echo "Không thể gửi email. Lỗi: {$mail->ErrorInfo}";
}
?>