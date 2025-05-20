<?php
session_start();
if (!isset($_SESSION['pending_registration'])) {
   // Chuyển về trang chủ nếu không có thông tin đăng ký
   header('Location: index.php');
   exit();
}

// Kiểm tra thời gian hết hạn
if (time() > $_SESSION['pending_registration']['expiry_time']) {
   // Xóa session nếu đã hết hạn
   unset($_SESSION['pending_registration']);
   session_destroy();
   header('Location: index.php?error=verification_expired');
   exit();
}
?>
<!DOCTYPE html>
<html>

<head>
   <title>Xác nhận đăng ký - BlogLinhTinh</title>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <link rel="stylesheet" media="screen,projection" type="text/css" href="assets/css/main.css" />
   <link rel="stylesheet" media="screen,projection" type="text/css" href="assets/css/skin.css" />
   <link rel="stylesheet" href="assets/css/font-awesome.css">
   <style>
      body {
         background-color: #f5f5f5;
         font-family: Arial, sans-serif;
      }

      .verification-container {
         max-width: 500px;
         margin: 100px auto;
         padding: 30px;
         background-color: #fff;
         border-radius: 8px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .verification-title {
         text-align: center;
         margin-bottom: 20px;
         color: #333;
      }

      .verification-info {
         margin-bottom: 20px;
         line-height: 1.6;
      }

      .verification-input {
         display: flex;
         justify-content: center;
         margin: 20px 0;
      }

      .code-input {
         width: 50px;
         height: 50px;
         font-size: 24px;
         text-align: center;
         margin: 0 5px;
         border: 2px solid #ddd;
         border-radius: 4px;
      }

      .btn-verify {
         display: block;
         width: 100%;
         padding: 12px;
         background-color: #4CAF50;
         color: white;
         border: none;
         border-radius: 4px;
         font-size: 16px;
         cursor: pointer;
         margin-top: 20px;
      }

      .btn-verify:hover {
         background-color: #45a049;
      }

      .resend-link {
         text-align: center;
         margin-top: 15px;
      }

      .resend-link a {
         color: #4CAF50;
         text-decoration: none;
      }

      .resend-link a:hover {
         text-decoration: underline;
      }
   </style>
</head>

<body>
   <div class="verification-container">
      <h2 class="verification-title">Xác nhận đăng ký tài khoản</h2>
      <div class="verification-info">
         Chúng tôi đã gửi mã xác nhận gồm 6 chữ số đến email
         <strong><?php echo htmlspecialchars($_SESSION['pending_registration']['email']); ?></strong>. Vui lòng kiểm tra
         hộp thư đến và nhập mã xác nhận để hoàn tất đăng ký.
      </div>

      <form action="verify_process.php" method="post">
         <div class="form-group">
            <label for="verification_code">Mã xác nhận</label>
            <input type="text" id="verification_code" name="verification_code" class="form-control" required
               pattern="[0-9]{6}" maxlength="6" placeholder="Nhập mã 6 chữ số">
            <small class="form-text text-muted">Mã xác nhận có hiệu lực trong 30 phút</small>
         </div>
         <button type="submit" class="btn-verify">Xác nhận</button>
      </form>

      <div class="resend-link">
         <a href="resend_code.php">Gửi lại mã xác nhận</a>
      </div>
   </div>
</body>

</html>