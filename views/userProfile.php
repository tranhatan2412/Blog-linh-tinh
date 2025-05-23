<?php
require_once '../models/userModel.php';
if ($_SESSION['username'] === null) {
   header('Location: ../index.php');
   exit();
}
$userInfo = (new UserModel())->getUserByUsername($_SESSION['username']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta charset="utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Thông tin cá nhân</title>
   <?php
   include 'headIndex.php';
   include 'head.php';
   ?>
</head>

<body>
   <?php
   include '../utils/user-display.php';
   include 'menu.php';
   ?>
   <div id="wrapper">
      <?php if ($_REQUEST['action'] == 'userProfile') {
         ?>
         <style>
            #page-wrapper {
               margin: 0 0 0 0;
            }
         </style>
      <?php } ?>
      <!-- /. NAV SIDE  -->
      <div id="page-wrapper">
         <div id="page-inner">
            <!-- /. ROW  -->
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-info">
                     <div style="text-align: center;" class="panel-heading">
                        Thông tin cá nhân
                     </div>
                     <div class="panel-body">
                        <?php if (isset($_SESSION['errorUpdate'])): ?>
                           <div class="alert alert-danger">
                              <?php echo $_SESSION['errorUpdate'];
                              unset($_SESSION['errorUpdate']); ?>
                           </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['successUpdate'])): ?>
                           <div class="alert alert-success">
                              <?php echo $_SESSION['successUpdate'];
                              unset($_SESSION['successUpdate']); ?>
                           </div>
                        <?php endif; ?>

                        <form method="post" enctype="multipart/form-data" class="user-profile-form" action="../controllers/userController.php?action=updateUser&id=<?php echo $userInfo['id']; ?>">
                           <div class="form-group text-center">
                              <div class="avatar-container">
                                 <img id="avatar-preview"
                                    src="<?php echo $userInfo['avatar'];  ?>"
                                    alt="Avatar" class="profile-avatar">
                                 <label for="avatar-upload" class="avatar-edit">
                                    <i class="fa fa-camera"></i>
                                 </label>
                                 <input type="file" id="avatar-upload" name="avatar" accept="image/*" style="display: none;">
                              </div>
                           </div>

                           <div class="form-group">
                              <label>Tên đăng nhập</label>
                              <input pattern="^[a-zA-Z0-9]+$" class="form-control" type="text" name="username"
                                 value="<?php echo $userInfo['username']; ?>" required>
                           </div>

                           <div class="form-group">
                              <label>Email</label>
                              <input pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$" class="form-control" type="email" name="email"
                                 value="<?php echo $userInfo['email']; ?>" required>
                           </div>

                           <div class="form-group">
                              <label>Mật khẩu</label>
                              <div class="password-container">
                                 <input pattern="^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};:'\\\|,.<>\/?]{8,}$" class="form-control" type="password" id="password" name="password"
                                    value="<?php echo $userInfo['password']; ?>" required>
                                 <span onclick="togglePassword()" class="password-toggle">
                                    <i id="password-toggle-icon" class="fa fa-eye"></i>
                                 </span>
                              </div>
                           </div>

                           <div style="text-align: center;">
                              <input type="submit" class="btn btn-info" value="Cập nhật" name="update_profile">
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /. PAGE INNER  -->
      </div>
      <!-- /. PAGE WRAPPER  -->
   </div>
   <!-- /. WRAPPER  -->

   <script src="/Admin/assets/js/avatar.js"></script>
   <script>
      // Hiển thị/ẩn mật khẩu
      function togglePassword() {
         const passwordInput = document.getElementById('password');
         const icon = document.getElementById('password-toggle-icon');

         if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
         } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
         }
      }
   </script>
</body>

</html>