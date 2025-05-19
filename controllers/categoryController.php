<?php
require_once '../models/categoryModel.php';
$action = $_GET['action'];
$categoryModel = new CategoryModel();

switch ($action) {
   case 'add':
      $categoryModel->addCategory();
      header('Location: ../views/categoryAdmin.php');
      break;
   case 'update':
      $categoryModel->updateCategory();
      header('Location: ../views/categoryAdmin.php#category-list');
      break;
   case 'delete':
      $categoryModel->deleteCategory();
      header('Location: ../views/categoryAdmin.php#category-list');
      break;
   default:
      header('Location: ../views/categoryAdmin.php');
      break;
}
