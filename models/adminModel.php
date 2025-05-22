<?php
require_once 'connect.php';
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
   public function getAllUsers() {
      $sql = "SELECT * FROM user";
      return $this->conn->query($sql);
   }
   public function deleteUser() {
      $sql = "DELETE FROM user WHERE id = '$_GET[id]'";
      return $this->conn->query($sql);
   }


}

