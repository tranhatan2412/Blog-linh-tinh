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
      $sort = "asc";
      if ($_SESSION['action'] === 'sort_username' && $_SESSION['status_username']) {
         $_SESSION['sort_username'] = !$_SESSION['sort_username'];
         $sort = $_SESSION['sort_username'] ? 'asc' : 'desc';
         $_SESSION['status_username'] = false;
      }
      $sql = "SELECT user.*, count(author) as post FROM user left outer join post on user.username = post.author group by user.username order by username $sort";
      return $this->conn->query($sql);
   }
   public function deleteUser()
   {
      $sql = "DELETE FROM user WHERE id = '$_GET[id]'";
      return $this->conn->query($sql);
   }


}

