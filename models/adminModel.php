<?php
require_once 'userModel.php';

class AdminModel extends UserModel
{

   public function getAllCategories()
   {
      $sql = "SELECT * FROM category";
      return $this->conn->query($sql);
   }
   public function addCategory()
   {
      if (isset($_POST['upload'])) {
         $sql = "select * from category where name = '$_POST[name]'";
         $result = $this->conn->query($sql);
         if ($result->num_rows > 0) {
            $_SESSION['errorInsert'] = "Danh mục {$_POST['name']} đã tồn tại";
            return;
         }
         $sql = "INSERT INTO category (name, description) VALUES ('$_POST[name]', '$_POST[description]')";
         $this->conn->query($sql);
      }
   }
   public function updateCategory()
   {
      if (isset($_POST['update'])) {
         $sql = "UPDATE category SET name = '$_POST[name]', description = '$_POST[description]' WHERE id = '$_GET[id]'";
         $this->conn->query($sql);
      }
   }
   public function deleteCategory()
   {
      $sql = "DELETE FROM category WHERE id = '$_GET[id]'";
      return $this->conn->query($sql);
   }
   public function getAllUsers()
   {
      // Xác định trường sắp xếp và hướng sắp xếp
      $sort_field = 'username'; // Mặc định sắp xếp theo username
      $sort_order = 'ASC'; // Mặc định sắp xếp tăng dần
      
      // Xử lý sắp xếp theo trường được chọn
      if (isset($_SESSION['sort_field'])) {
         $sort_field = $_SESSION['sort_field'];
      }
      
      // Kiểm tra action hiện tại để xác định hướng sắp xếp
      if (isset($_SESSION['action'])) {
         switch ($_SESSION['action']) {
            case 'sort_username':
               $sort_field = 'username';
               $sort_order = isset($_SESSION['sort_order']) ? $_SESSION['sort_order'] : 'ASC';
               break;
            case 'sort_created':
               $sort_field = 'created';
               $sort_order = isset($_SESSION['sort_created']) ? $_SESSION['sort_created'] : 'ASC';
               break;
            case 'sort_post':
               $sort_field = 'post';
               $sort_order = isset($_SESSION['sort_post']) ? $_SESSION['sort_post'] : 'ASC';
               break;
            default:
               // Nếu không phải action sắp xếp, dùng trường đã lưu trong session
               switch ($sort_field) {
                  case 'username':
                     $sort_order = isset($_SESSION['sort_order']) ? $_SESSION['sort_order'] : 'ASC';
                     break;
                  case 'created':
                     $sort_order = isset($_SESSION['sort_created']) ? $_SESSION['sort_created'] : 'ASC';
                     break;
                  case 'post':
                     $sort_order = isset($_SESSION['sort_post']) ? $_SESSION['sort_post'] : 'ASC';
                     break;
                  default:
                     $sort_order = 'ASC';
               }
         }
      }
      
      $sql = "SELECT user.*, count(author) as post 
              FROM user 
              LEFT OUTER JOIN post ON user.username = post.author 
              GROUP BY user.username 
              ORDER BY $sort_field $sort_order";
      
      return $this->conn->query($sql);
   }
   public function deleteUser()
   {
      $sql = "DELETE FROM user WHERE id = '$_GET[id]'";
      return $this->conn->query($sql);
   }
   


}

