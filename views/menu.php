
<div id="header" class="box">
   <h1 id="logo">Blog<span>LinhTinh</span> <i class="fa fa-pencil"></i></h1>
   <ul id="nav">
      <li class="current"><a href="/Admin/index.php"><i class="fa fa-home"></i> Trang chủ</a></li>
      <li><a href="subpage.html"><i class="fa fa-envelope"></i> Liên hệ</a></li>
      <li><a href="#"><i class="fa fa-info-circle"></i> Giới thiệu</a></li>
      <?php
      if (!isset($_SESSION['username'])) { ?>
         <li class="auth-buttons"><a href="#" id="registerBtn"><i class="fa fa-user-plus"></i> Đăng ký</a></li>
         <li class="auth-buttons"><a href="#" id="loginBtn"><i class="fa fa-sign-in"></i> Đăng nhập</a></li><?php
      } else {
         ?>
         <li><a href="/Admin/views/new_post.php?action=new_post"><i class="fa fa-plus"></i> Đăng bài</a></li>
         <li class="user-dropdown" id="userDropdown">
            <div class="user-dropdown-toggle">
               <i class="fa fa-user"></i>
               <span id="username-display" class="username-display"><?php echo truncate($_SESSION['username']); ?></span>
               <i class="fa fa-caret-down"></i>
            </div>
            <div class="user-dropdown-menu">
               <?php if ($_SESSION['role'] == 'admin') { ?>
                  <a href="/Admin/views/dashboard.php" class="admin-link">
                     <div style="display: flex; align-items: center;">
                        <i class="fa fa-dashboard"></i>
                        <div style="margin-left: 50px;" class="menu-item-content">
                           <span>Dashboard</span>
                           <small>Quản trị website</small>
                        </div>
                     </div>
                  </a>
               <?php } ?>
               <a href="/Admin/views/userProfile.php?action=userProfile" class="profile-link">
                  <div style="display: flex; align-items: center;">
                     <img style="width: 40px; height: 40px; border-radius: 50%;" src="<?php echo $_SESSION['avatar']; ?>"
                        alt="Avatar" class="avatar-icon">
                     <div style="margin-left: 10px;" class="menu-item-content">
                        <span>Thông tin cá nhân</span>
                        <small>Xem và cập nhật thông tin</small>
                     </div>
                  </div>
               </a>
               <a href="/Admin/views/post_list.php?username=<?php echo $_SESSION['username']; ?>&from=user"
                  class="posts-link">
                  <div style="display: flex; align-items: center;">
                     <i class="fa fa-file-text"></i>
                     <span class="notification-badge"><?php echo $_SESSION['totalPostsUser']; ?></span>
                     <div style="margin-left: 50px;" class="menu-item-content">
                        <span>Bài viết đã đăng</span>
                        <small>Quản lý bài viết của bạn</small>
                     </div>
                  </div>
               </a>

               <a class="logout-link" id="logoutBtn">
                  <div style="display: flex; align-items: center;">
                     <i class="fa fa-sign-out"></i>
                     <div style="margin-left: 50px;" class="menu-item-content">
                        <span>Đăng xuất</span>
                     </div>
                  </div>
               </a>
            </div>
         </li>
         <?php
      }
      ?>
   </ul>
</div>