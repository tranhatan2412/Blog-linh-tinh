<?php
include 'models/userModel.php';
$posts = (new UserModel())->getAllPosts();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include 'views/headIndex.php'; ?>

<body>
  <!-- START PAGE SOURCE -->
  <div class="main">
    <?php include 'utils/user-display.php';
    include 'views/menu.php' ?>
    <form action="#" method="get" id="search">
      <h3><i class="fa fa-filter"></i> Bộ lọc tìm kiếm</h3>
      <div class="filter-box modern-filter">
        <div class="search-row">
          <div class="input-with-icon">
            <i class="fa fa-user"></i>
            <input type="text" class="input-text" placeholder="Tìm theo tên tác giả..." />
          </div>

          <div class="input-with-icon">
            <i class="fa fa-book"></i>
            <input type="text" class="input-text" placeholder="Tìm theo tiêu đề..." />
          </div>

          <div class="filter-item">
            <div class="dropdown-check-list" id="categoryDropdown">
              <span class="anchor"><i class="fa fa-tags"></i> Chọn thể loại <span class="category-count">0</span></span>
              <ul class="items">
                <li><input type="checkbox" id="cat1" name="category[]" value="1" /><label for="cat1">Tin tức</label>
                </li>
                <li><input type="checkbox" id="cat2" name="category[]" value="2" /><label for="cat2">Công nghệ</label>
                </li>
                <li><input type="checkbox" id="cat3" name="category[]" value="3" /><label for="cat3">Giải trí</label>
                </li>
                <li><input type="checkbox" id="cat4" name="category[]" value="4" /><label for="cat4">Thể thao</label>
                </li>
                <li><input type="checkbox" id="cat5" name="category[]" value="5" /><label for="cat5">Đời sống</label>
                </li>
                <li class="clear-all"><button type="button" id="clearAllBtn">Xóa tất cả</button></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="active-filters">
          <div class="filter-count">Bộ lọc đang áp dụng: <span>0</span></div>
          <div class="filter-tags"></div>
        </div>

        <div class="submit-buttons">
          <button type="submit" class="btn-search" name="search"><i class="fa fa-search"></i> Tìm kiếm</button>
          <button type="button" class="btn-reset"><i class="fa fa-refresh"></i> Đặt lại</button>
        </div>

      </div>
    </form>
    <div id="section" class="box">
      <div id="content">
        <ul class="articles box">
          <?php foreach ($posts as $post) : ?>
          <li>
            <h2><a href="#"><?php echo $post['title']; ?></a></h2>
            <div class="article-info box">
              <p class="f-right"><a href="#" class="comment">Comments (15)</a></p>
              <p class="f-left"><?php echo date('d/m/Y H:i', strtotime($post['created'])); ?> | Posted by <a style="text-decoration: underline; color: red;" href="#"><?php echo $post['author']; ?></a> | Category: <a style="text-decoration: underline; color: red;"
              href="#"><?php echo $post['category']; ?></a></p>
            </div>
            
            <p><img src="<?php echo $post['image']; ?>" alt="" class="f-left" /><?php echo $post['short_content']; ?></p>
            <p style="min-height: 30px;" class="more"><a href="#">Read more &raquo;</a></p>
          </li>
          <?php endforeach; ?>
            
        </ul>
        <div class="pagination box">
          <p class="f-right"> <a href="#" class="current">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a
              href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">Next &raquo;</a> </p>
          <p class="f-left">Page 1 of 13</p>
        </div>
      </div>
      <div id="aside">


        <h3>Sidebar Menu</h3>
        <ul class="menu">
          <li><a href="#">Discussion</a></li>
          <li><a href="#">Authors</a></li>
          <li><a href="#">Blogs</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        <h3 class="nomb">Sponsors</h3>
        <ul class="sponsors">
          <li><a href="#">Lorem ipsum dolor</a><br />
            Donec libero. Suspendisse bibendum</li>
          <li><a href="#">Dui pede condimentum</a><br />
            Phasellus suscipit, leo a pharetra</li>
          <li><a href="#">Condimentum lorem</a><br />
            Tellus eleifend magna eget</li>
          <li><a href="#">Donec mattis</a><br />
            purus nec placerat bibendum</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Form Đăng nhập -->
  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeLogin">&times;</span>
      <h2 class="form-title"><i class="fa fa-sign-in"></i> Đăng nhập</h2>

      <div id="loginErrorArea" class="error-message" style="display: none;">
        <div class="alert alert-danger">
          <i class="fa fa-exclamation-circle"></i>
          <span id="loginErrorMessage"></span>
        </div>
      </div>

      <form id="loginForm" action="/Admin/controllers/userController.php?action=login" method="post">
        <div class="form-group">
          <label for="loginEmail">Email hoặc tên đăng nhập</label>
          <input type="text" id="loginEmail" name="email_username" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="loginPassword">Mật khẩu</label>
          <div style="position: relative;">
            <input type="password" id="loginPassword" name="password" class="form-control" required>
            <i class="fa fa-eye-slash toggle-password"
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
          </div>
        </div>
        <input id="login" type="submit" class="btn-submit" name="login" value="Đăng nhập">
        <div class="form-footer">
          <p>Chưa có tài khoản? <a href="#" id="switchToRegister">Đăng ký ngay</a></p>
          <p><a href="#">Quên mật khẩu?</a></p>
        </div>
      </form>
    </div>
  </div>

  <!-- Form Đăng ký -->
  <div id="registerModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeRegister">&times;</span>
      <h2 class="form-title"><i class="fa fa-user-plus"></i> Đăng ký tài khoản</h2>

      <div id="registerErrorArea" class="error-message" style="display: none;">
        <div class="alert alert-danger">
          <i class="fa fa-exclamation-circle"></i>
          <span id="registerErrorMessage"></span>
        </div>
      </div>

      <form id="registerForm" action="/Admin/controllers/userController.php?action=register" method="post">
        <div class="form-group">
          <label for="username">Tên đăng nhập</label>
          <input type="text" id="username" name="username" placeholder="Sử dụng làm tên tác giả đăng bài"
            class="form-control" pattern="^[a-zA-Z0-9 ]+$" required>
          <small id="usernameMessage" class="form-text" >Tên đăng nhập chỉ chứa chữ cái và số</small>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
            class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password">Mật khẩu</label>
          <div style="position: relative;">
            <input type="password" id="password" name="password"
              pattern="^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};:'\\\|,.<>\/?]{8,}$" class="form-control" required>
            <i class="fa fa-eye-slash toggle-password" aria-hidden="true"
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
          </div>
          <small id="passwordLengthMessage" class="password-check"></small>
        </div>
        <div class="form-group">
          <label for="confirmPassword">Xác nhận mật khẩu</label>
          <div style="position: relative;">
            <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
            <i class="fa fa-eye-slash toggle-password" aria-hidden="true"
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
          </div>
          <small id="passwordMatchMessage" class="form-text" style="display: none;"></small>
        </div>

        <input id="register" type="submit" class="btn-submit" name="register" value="Đăng ký">
        <div class="form-footer">
          <p>Đã có tài khoản? <a href="#" id="switchToLogin">Đăng nhập</a></p>
        </div>
      </form>
    </div>
  </div>

  <script type="text/javascript">Cufon.now();</script>
  <!-- END PAGE SOURCE -->
</body>

</html>