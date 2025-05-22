<?php
include '../models/userModel.php';
$userModel = new UserModel();
$action = $_GET['action'];

switch ($action) {
   case 'addPost':
      move_uploaded_file($_FILES['picture']['tmp_name'], '../img/' . $_FILES['picture']['name']);
      $userModel->addPost();
      header('Location: ../views/new_post.php?action=new_post');
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
      $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
      
      $result = $userModel->register();
      
      if ($isAjax) {
         header('Content-Type: application/json');
         echo json_encode($result);
         exit;
      } else {
         if (isset($result['error'])) {
            $_SESSION['error'] = $result['error'];
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?register_error=1');
         } else
            header('Location: ../index.php');
      }
      break;
   case 'login':
      $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
      
      $result = $userModel->login();
      
      if ($isAjax) {
         header('Content-Type: application/json');
         echo json_encode($result);
         exit;
      } else {
         if (isset($result['error'])) {
            $_SESSION['error'] = $result['error'];
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?login_error=1');
         } else
            header('Location: ../index.php');
      }
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