<?php
require_once 'connect.php';
class PostModel {
   private $conn;

   public function __construct() {
      $this->conn = (new Connect())->connect();
   }
   public function getAllPosts() {
      $sql = "SELECT * FROM post";
      return $this->conn->query($sql);
   }
   public function addPost() {
      $image = '/Admin/img/' . basename($_FILES['picture']['name']);
      $sql = "INSERT INTO post (title, short_content, full_content, author, date, category, image) VALUES ('$_POST[title]', '$_POST[short_content]', '$_POST[full_content]', '$_POST[author]', '$_POST[date]', '$_POST[category]', '$image')";
      return $this->conn->query($sql);
   }
   public function updatePost() {
      $image = '/Admin/img/' . basename($_FILES['picture']['name']);
      $sql = "UPDATE post SET title = '$_POST[title]', short_content = '$_POST[short_content]', full_content = '$_POST[full_content]', author = '$_POST[author]', date = '$_POST[date]', category = '$_POST[category]', image = '$image' WHERE id = '$_POST[id]'";
      return $this->conn->query($sql);
   }
   public function deletePost() {
      $sql = "DELETE FROM post WHERE id = '$_POST[id]'";
      return $this->conn->query($sql);
   }

}
?>
