<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['pending_registration'])) {
   $entered_code = $_POST['verification_code'];
   $correct_code = $_SESSION['pending_registration']['verification_code'];

   // Kiểm tra thời gian hết hạn
   if (time() > $_SESSION['pending_registration']['expiry_time']) {
      unset($_SESSION['pending_registration']);
      header('Location: index.php?error=verification_expired');
      exit();
   }

   // Kiểm tra mã xác nhận
   if ($entered_code == $correct_code) {
      // Kết nối database
      $servername = "localhost";
      $username = "username"; // Thay đổi thông tin đăng nhập DB của bạn
      $password = "password";
      $dbname = "blog_db";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
         die("Kết nối thất bại: " . $conn->connect_error);
      }

      // Lấy thông tin người dùng từ session
      $username = $_SESSION['pending_registration']['username'];
      $email = $_SESSION['pending_registration']['email'];
      $password = $_SESSION['pending_registration']['password'];
      $created_at = date('Y-m-d H:i:s');

      // Kiểm tra email hoặc tên đăng nhập đã tồn tại chưa
      $check_sql = "SELECT * FROM users WHERE email = ? OR username = ?";
      $check_stmt = $conn->prepare($check_sql);
      $check_stmt->bind_param("ss", $email, $username);
      $check_stmt->execute();
      $result = $check_stmt->get_result();

      if ($result->num_rows > 0) {
         $check_stmt->close();
         $conn->close();
         header('Location: index.php?error=user_exists');
         exit();
      }

      // Thêm người dùng vào database
      $sql = "INSERT INTO users (username, email, password, created_at, status) VALUES (?, ?, ?, ?, 'active')";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssss", $username, $email, $password, $created_at);

      if ($stmt->execute()) {
         // Xóa thông tin tạm thời sau khi đăng ký thành công
         unset($_SESSION['pending_registration']);

         // Tạo session đã đăng nhập nếu muốn tự động đăng nhập
         $_SESSION['user_id'] = $conn->insert_id;
         $_SESSION['username'] = $username;
         $_SESSION['email'] = $email;

         $stmt->close();
         $conn->close();

         // Chuyển hướng đến trang thành công
         header('Location: index.php?registration=success');
         exit();
      } else {
         header('Location: index.php?error=database');
         exit();
      }
   } else {
      // Mã xác nhận không đúng
      header('Location: verify.php?error=invalid_code');
      exit();
   }
} else {
   // Không có dữ liệu POST hoặc không có thông tin đăng ký
   header('Location: index.php');
   exit();
}
?>