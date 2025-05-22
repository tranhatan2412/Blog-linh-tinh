<?php
require_once '../models/adminModel.php';
$action = $_GET['action'];
$adminModel = new AdminModel();

switch ($action) {
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
   case 'getUser':
      $adminModel->getAllUsers();
      header('Location: ../views/user-list.php');
      break;
   default:
      header('Location: ../views/dashboard.php');
      break;
}
