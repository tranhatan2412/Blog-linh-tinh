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
   public function getAllPostsByUser($username)
   {
      $sql = "SELECT * FROM post where author = '$username' order by created desc";
      return $this->conn->query($sql);
   }
   public function updatePostStatus($id)
   {
      $sql = "UPDATE post SET status = 1 WHERE id = '$id'";
      return $this->conn->query($sql);
   }
   public function getAllPostsCensored()
   {
      $sql = "SELECT * FROM post where status = true order by created desc";
      return $this->conn->query($sql);
   }
   public function getAllPostsUnCensored()
   {
      $sql = "SELECT * FROM post where status = false order by created desc";
      return $this->conn->query($sql);
   }
   public function getPostById($id)
   {
      $sql = "SELECT * FROM post WHERE id = '$id'";
      return $this->conn->query($sql)->fetch_assoc();
   }
   public function addPost()
   {
      $image = '/Admin/img/' . basename($_FILES['picture']['name']);
      $status = $_SESSION['role'] == 'admin' ? 1 : 0;
      $sql = "INSERT INTO post (title, short_content, full_content, author, category, image, status) VALUES ('$_POST[title]', '$_POST[short_content]', '$_POST[full_content]', '$_SESSION[username]', '$_POST[category]', '$image', $status)";
      return $this->conn->query($sql);
   }
   public function updatePost($id)
   {
      if (!empty($_FILES['picture']['name'])) {
         $image = '/Admin/img/' . basename($_FILES['picture']['name']);
         $sql = "UPDATE post SET title = '$_POST[title]', short_content = '$_POST[short_content]', full_content = '$_POST[full_content]', category = '$_POST[category]', image = '$image', updated = NOW() WHERE id = '$id'";
      } else
         $sql = "UPDATE post SET title = '$_POST[title]', short_content = '$_POST[short_content]', full_content = '$_POST[full_content]', category = '$_POST[category]', updated = NOW() WHERE id = '$id'";
      return $this->conn->query($sql);
   }
   public function deletePost($id)
   {
      $sql = "DELETE FROM post WHERE id = '$id'";
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
         $_SESSION['avatar'] = $avatar;
      } else
         $sql = "UPDATE user SET username = '$_POST[username]', email = '$_POST[email]', password = '$_POST[password]' WHERE id = '$_GET[id]'";

      return $this->conn->query($sql);
   }
   public function getAllPosts($username = null)
   {
      if ($username)
         $sql = "SELECT * FROM post where author = '$username' order by created desc";
      else
         $sql = "SELECT * FROM post order by created desc";
      return $this->conn->query($sql);
   }
   public function searchPosts($author = null, $title = null, $category = null)
   {
      $sql = "SELECT * FROM post where status = true";
      if (!empty($author)) {
         if ($this->conn->query("SELECT * FROM user where username = '$author'")->num_rows === 0)
            $sql = "{$sql} and author like '%" . $author . "%'";
         else $sql = "{$sql} and author = '$author'";
      }
      if (!empty($title))
         $sql = "{$sql} AND title like '%" . $title . "%'";
      if (!empty($category)) {
         $category = implode("','", $category);
         $sql = "{$sql} AND category IN ('$category')";
      }
      $sql = "{$sql} order by created desc";
      return $this->conn->query($sql);
   }

}