<?php
require_once 'connect.php';
session_start();
class UserModel
{
   protected $conn;

   public function __construct()
   {
      $this->conn = (new Connect())->connect();
   }
   public function register()
   {
      if ($_REQUEST['action'] == 'register') {
         $sql_check = "SELECT * FROM user WHERE username = '$_POST[username]'";
         $result = $this->conn->query($sql_check);
         if ($result->num_rows > 0)
            return ['success' => false, 'error' => "Tên tài khoản đã tồn tại"];

         $sql_check = "SELECT * FROM user WHERE email = '$_POST[email]'";
         $result = $this->conn->query($sql_check);
         if ($result->num_rows > 0)
            return ['success' => false, 'error' => "Email đã được đăng ký"];
         $avatar = '/Admin/assets/img/portfolio/b.jpg';
         $sql = "INSERT INTO user (username, password, email, avatar) VALUES ('$_POST[username]', '$_POST[password]', '$_POST[email]', '$avatar')";
         $insertResult = $this->conn->query($sql);

         if ($insertResult) {
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['role'] = $this->conn->query($sql_check)->fetch_assoc()['role'];
            $_SESSION['avatar'] = $avatar;
            return ['success' => true, 'username' => $_POST['username']];
         } else
            return ['success' => false, 'error' => "Lỗi khi tạo tài khoản: " . $this->conn->error];
      }
      return ['success' => false, 'error' => "Yêu cầu không hợp lệ"];
   }
   public function login()
   {
      if ($_REQUEST['action'] == 'login') {
         $sql = "SELECT * FROM user WHERE (username = '$_POST[email_username]' OR email = '$_POST[email_username]') AND password = '$_POST[password]'";
         $result = $this->conn->query($sql);

         if ($result->num_rows === 0)
            return ['success' => false, 'error' => "Tên tài khoản hoặc mật khẩu không chính xác"];
         $user = $result->fetch_assoc();

         $_SESSION['username'] = $user['username'];
         $_SESSION['role'] = $user['role'];
         $_SESSION['avatar'] = $user['avatar'];
         return ['success' => true, 'username' => $user['username']];
      }

      return ['success' => false, 'error' => "Yêu cầu không hợp lệ"];
   }
   public function getAllPostsByUser()
   {
      $sql = "SELECT * FROM post where author = '$_SESSION[username]'";
      return $this->conn->query($sql);
   }
   public function addPost()
   {
      $image = '/Admin/img/' . basename($_FILES['picture']['name']);
      $sql = "INSERT INTO post (title, short_content, full_content, author, category, image) VALUES ('$_POST[title]', '$_POST[short_content]', '$_POST[full_content]', '$_SESSION[username]', '$_POST[category]', '$image')";
      return $this->conn->query($sql);
   }
   public function updatePost()
   {
      $image = '/Admin/img/' . basename($_FILES['picture']['name']);
      $sql = "UPDATE post SET title = '$_POST[title]', short_content = '$_POST[short_content]', full_content = '$_POST[full_content]', author = '$_SESSION[username]', date = '$_POST[date]', category = '$_POST[category]', image = '$image' WHERE id = '$_POST[id]'";
      return $this->conn->query($sql);
   }
   public function deletePost()
   {
      $sql = "DELETE FROM post WHERE id = '$_POST[id]'";
      return $this->conn->query($sql);
   }

   public function updateUser($id, $username, $email)
   {
      $sql = "UPDATE user SET username = '$username', email = '$email' WHERE id = '$id'";
      return $this->conn->query($sql);
   }

   public function getUserByUsername($username)
   {
      $sql = "SELECT * FROM user WHERE username = '$username'";
      $result = $this->conn->query($sql);
      return $result->fetch_assoc();
   }

   public function updateUserProfile()
   {
      $_SESSION['username'] = $_POST['username'];
      if (!empty($_FILES['avatar']['name'])) {
         $avatar = '/Admin/avatar/' . basename($_FILES['avatar']['name']);
         $sql = "UPDATE user SET username = '$_POST[username]', email = '$_POST[email]', password = '$_POST[password]', avatar = '$avatar' WHERE id = '$_GET[id]'";
      } else
         $sql = "UPDATE user SET username = '$_POST[username]', email = '$_POST[email]', password = '$_POST[password]' WHERE id = '$_GET[id]'";

      return $this->conn->query($sql);
   }
   public function getAllPosts()
   {
      $sql = "SELECT * FROM post order by created desc";
      return $this->conn->query($sql);
   }
}