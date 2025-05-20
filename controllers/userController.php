<?php
include '../models/userModel.php';
$userModel = new UserModel();
$action = $_GET['action'];

switch ($action) {
   case 'addPost':
      $userModel->addPost();
      move_uploaded_file($_FILES['picture']['tmp_name'], '../img/' . $_FILES['picture']['name']);
      header('Location: ../views/new_post.php');
      break;
   case 'updatePost':
      $userModel->updatePost();
      header('Location: ../views/post_list.php');
      break;
   case 'deletePost':
      $userModel->deletePost();
      header('Location: ../views/post_list.php');
      break;
   case 'register':
      $userModel->register();
      header('Location: ../views/index.php');
      break;
   case 'login':
      $userModel->login();
      header('Location: ../views/index.php');
      break;
   case 'logout':
      session_destroy();
      header('Location: ../views/index.php');
      break;
   default:
      header('Location: ../views/post_list.php');
      break;
}
?>