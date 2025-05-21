<?php
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
  unset($_SESSION['username']);
  header('Location: index.php');
  exit;
}

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
          <li>
            <h2><a href="#">Template License</a></h2>
            <div class="article-info box">
              <p class="f-right"><a href="#" class="comment">Comments (15)</a></p>
              <p class="f-left">October 27, 2011 | Posted by <a href="#">John Doe</a> | Filed under <a
                  href="#">templates</a>, <a href="#">webdesign</a>, <a href="#">internet</a></p>
            </div>
            <p>This is a free web template by TemplatesDock. This work is distributed under the Creative Commons
              Attribution 3.0 License, which means that you are free to adapt, copy, distribute and transmit the work.
              You must attribute the work in the manner specified by the author or licensor (don´t remove our backlink
              from footer).</p>
            <p><img src="tmp/article-01.jpg" alt="" class="f-left" />Suspendisse posuere, metus eget pharetra
              adipiscing, arcu velit lobortis augue, quis pharetra mauris ante a velit. Duis feugiat, odio a mattis
              gravida, velit est euismod urna, vitae gravida elit turpis sit amet elit. Phasellus ac hendrerit tortor.
              Aliquam erat volutpat. Donec laoreet viverra sapien et luctus. Cras fringilla commodo nulla sit amet
              congue. Donec aliquam gravida elit, in fringilla urna adipiscing in. Sed vel risus id urna luctus
              eleifend. Morbi ut fringilla magna. Curabitur lobortis molestie tellus ac ultricies. Maecenas tempus
              rutrum mauris in auctor. Ut interdum diam a justo malesuada dignissim. Morbi blandit odio sed magna
              rhoncus tincidunt. Etiam diam neque, ornare in molestie posuere, vulputate a nisl. Donec dictum, erat vel
              varius ullamcorper, lorem ipsum vulputate eros, sit amet lacinia orci arcu ac mi. Cras pellentesque, lacus
              vel laoreet tristique, justo magna convallis ante, at pellentesque ligula sapien sit amet elit. Nulla ut
              nunc libero.</p>
            <p class="more"><a href="#">Read more &raquo;</a></p>
          </li>
          <li>
            <h2><a href="#">Template License</a></h2>
            <div class="article-info box">
              <p class="f-right"><a href="#" class="comment">Comments (15)</a></p>
              <p class="f-left">October 27, 2011 | Posted by <a href="#">John Doe</a> | Filed under <a
                  href="#">templates</a>, <a href="#">webdesign</a>, <a href="#">internet</a></p>
            </div>
            <p>This is a free web template by TemplatesDock. This work is distributed under the Creative Commons
              Attribution 3.0 License, which means that you are free to adapt, copy, distribute and transmit the work.
              You must attribute the work in the manner specified by the author or licensor (don´t remove our backlink
              from footer).</p>
            <p><img src="tmp/article-02.jpg" alt="" class="f-right" />Suspendisse posuere, metus eget pharetra
              adipiscing, arcu velit lobortis augue, quis pharetra mauris ante a velit. Duis feugiat, odio a mattis
              gravida, velit est euismod urna, vitae gravida elit turpis sit amet elit. Phasellus ac hendrerit tortor.
              Aliquam erat volutpat. Donec laoreet viverra sapien et luctus. Cras fringilla commodo nulla sit amet
              congue. Donec aliquam gravida elit, in fringilla urna adipiscing in. Sed vel risus id urna luctus
              eleifend. Morbi ut fringilla magna. Curabitur lobortis molestie tellus ac ultricies. Maecenas tempus
              rutrum mauris in auctor. Ut interdum diam a justo malesuada dignissim. Morbi blandit odio sed magna
              rhoncus tincidunt. Etiam diam neque, ornare in molestie posuere, vulputate a nisl. Donec dictum, erat vel
              varius ullamcorper, lorem ipsum vulputate eros, sit amet lacinia orci arcu ac mi. Cras pellentesque, lacus
              vel laoreet tristique, justo magna convallis ante, at pellentesque ligula sapien sit amet elit. Nulla ut
              nunc libero.</p>
            <p class="more"><a href="#">Read more &raquo;</a></p>
          </li>
          <li>
            <h2><a href="#">Template License</a></h2>
            <div class="article-info box">
              <p class="f-right"><a href="#" class="comment">Comments (15)</a></p>
              <p class="f-left">October 27, 2011 | Posted by <a href="#">John Doe</a> | Filed under <a
                  href="#">templates</a>, <a href="#">webdesign</a>, <a href="#">internet</a></p>
            </div>
            <p>This is a free web template by TemplatesDock. This work is distributed under the Creative Commons
              Attribution 3.0 License, which means that you are free to adapt, copy, distribute and transmit the work.
              You must attribute the work in the manner specified by the author or licensor (don´t remove our backlink
              from footer).</p>
            <p><img src="tmp/article-03.jpg" alt="" class="f-left" />Suspendisse posuere, metus eget pharetra
              adipiscing, arcu velit lobortis augue, quis pharetra mauris ante a velit. Duis feugiat, odio a mattis
              gravida, velit est euismod urna, vitae gravida elit turpis sit amet elit. Phasellus ac hendrerit tortor.
              Aliquam erat volutpat. Donec laoreet viverra sapien et luctus. Cras fringilla commodo nulla sit amet
              congue. Donec aliquam gravida elit, in fringilla urna adipiscing in. Sed vel risus id urna luctus
              eleifend. Morbi ut fringilla magna. Curabitur lobortis molestie tellus ac ultricies. Maecenas tempus
              rutrum mauris in auctor. Ut interdum diam a justo malesuada dignissim. Morbi blandit odio sed magna
              rhoncus tincidunt. Etiam diam neque, ornare in molestie posuere, vulputate a nisl. Donec dictum, erat vel
              varius ullamcorper, lorem ipsum vulputate eros, sit amet lacinia orci arcu ac mi. Cras pellentesque, lacus
              vel laoreet tristique, justo magna convallis ante, at pellentesque ligula sapien sit amet elit. Nulla ut
              nunc libero.</p>
            <p class="more"><a href="#">Read more &raquo;</a></p>
          </li>
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
        <h3>About</h3>
        <p class="box"> <img src="tmp/about-01.jpg" alt="" class="f-left" /> My name is Jessie Doe. I´m 26 years old and
          I´m living in the New York City.<br />
          <a href="#">More about me</a>
        </p>
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
  <div id="footer">
    <div class="main box">
      <p class="f-right t-right">Design by <a href="http://www.templatesdock.com/">TemplatesDock</a></p>
      <p class="f-left">Copyright &copy;&nbsp;2010 <a href="#">SimpleMagazine</a></p>
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
            class="form-control" required>
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


  <?php
  if (isset($_SESSION["error"])) {
    echo '<script>alert("' . $_SESSION["error"] . '");</script>';
    unset($_SESSION["error"]);
  }

  // Xử lý đăng xuất
  if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    // Hủy session
    session_unset();
    session_destroy();

    // Chuyển hướng về trang chủ
    echo '<script>window.location.href = "index.php";</script>';
    exit();
  }
  ?>
</body>

</html>