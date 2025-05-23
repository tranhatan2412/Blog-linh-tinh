<?php
require_once '../models/adminModel.php';
$_SESSION['action'] = $_GET['action'];
$adminModel = new AdminModel();

// Xử lý sắp xếp username
if ($_SESSION['action'] === 'sort_username') {
   // Lấy hướng sắp xếp từ tham số URL
   if (isset($_GET['sort'])) {
      $_SESSION['sort_order'] = $_GET['sort'];
   } else {
      // Nếu không có tham số, đặt mặc định là ASC
      $_SESSION['sort_order'] = 'ASC';
   }
   $_SESSION['sort_field'] = 'username';
}

// Xử lý sắp xếp created date
if ($_SESSION['action'] === 'sort_created') {
   if (isset($_GET['sort'])) {
      $_SESSION['sort_created'] = $_GET['sort'];
   } else {
      $_SESSION['sort_created'] = 'ASC';
   }
   $_SESSION['sort_field'] = 'created';
}

// Xử lý sắp xếp post
if ($_SESSION['action'] === 'sort_post') {
   if (isset($_GET['sort'])) {
      $_SESSION['sort_post'] = $_GET['sort'];
   } else {
      $_SESSION['sort_post'] = 'ASC';
   }
   $_SESSION['sort_field'] = 'post';
}


switch ($_SESSION['action']) {
   case 'deleteUser':
      $adminModel->deleteUser();
      header('Location: ../views/user-list.php');
      break;
   case 'addCategory':
      $adminModel->addCategory();
      header('Location: ../views/category.php');
      break;
   case 'updateCategory':
      $adminModel->updateCategory();
      header('Location: ../views/category.php#category-list');
      break;
   case 'deleteCategory':
      $adminModel->deleteCategory();
      header('Location: ../views/category.php#category-list');
      break;
   case 'sort_username':
   case 'sort_created':
   case 'sort_post':
   case 'getUser':
      $adminModel->getAllUsers();
      header('Location: ../views/user-list.php?action=getUser');
      break;
   default:
      header('Location: ../views/dashboard.php');
      break;
}
