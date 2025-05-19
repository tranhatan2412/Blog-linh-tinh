<?php
include '../models/postModel.php';
$postModel = new PostModel();
$action = $_GET['action'];

switch ($action) {
   case 'add':
      $postModel->addPost();
      move_uploaded_file($_FILES['picture']['tmp_name'], '../img/' . $_FILES['picture']['name']);
      header('Location: ../views/new_post.php');
      break;
   case 'update':
      $postModel->updatePost();
      header('Location: ../views/post_list.php');
      break;
   case 'delete':
      $postModel->deletePost();
      header('Location: ../views/post_list.php');
      break;
   default:
      header('Location: ../views/post_list.php');
      break;
}
?>