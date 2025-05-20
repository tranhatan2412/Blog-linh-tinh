<?php
session_start();

// Xử lý đăng xuất
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
  unset($_SESSION['username']);
  // Chuyển hướng để tránh F5 làm mất session
  header('Location: index.php');
  exit;
}

// Xử lý đăng ký thành công từ URL
if (isset($_GET['register_success']) && $_GET['register_success'] == 'true' && isset($_GET['username'])) {
  $_SESSION['username'] = $_GET['username'];
}

// Xử lý đăng nhập thành công từ URL
if (isset($_GET['login_success']) && $_GET['login_success'] == 'true' && isset($_GET['username'])) {
  $_SESSION['username'] = $_GET['username'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>SimpleMagazine 01</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" media="screen,projection" type="text/css" href="assets/css/main.css" />
  <link rel="stylesheet" media="screen,projection" type="text/css" href="assets/css/skin.css" />
  <link rel="stylesheet" href="assets/css/font-awesome.css">
  <script type="text/javascript" src="assets/js/cufon-yui.js"></script>
  <script type="text/javascript" src="assets/js/font.font.js"></script>
  <script type="text/javascript">
    Cufon.replace('h1, h2, h3, h4, h5, h6', {
      hover: true
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    /* CSS cho form đăng nhập và đăng ký */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      width: 400px;
      max-width: 90%;
      position: relative;
    }

    .close {
      position: absolute;
      right: 15px;
      top: 10px;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
    }

    .form-title {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
      font-size: 24px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .btn-submit {
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 10px;
    }

    .btn-submit:hover {
      background-color: #45a049;
    }

    .form-footer {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .form-footer a {
      color: #4CAF50;
      text-decoration: none;
    }

    .form-footer a:hover {
      text-decoration: underline;
    }

    /* CSS cho dropdown người dùng */
    .user-dropdown {
      position: relative;
      display: inline-block;
    }

    .user-dropdown-toggle {
      display: flex;
      align-items: center;
      cursor: pointer;
      padding: 8px 15px;
      border-radius: 4px;
      transition: all 0.3s ease;
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .user-dropdown-toggle:hover {
      background-color: rgba(255, 255, 255, 0.2);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .user-dropdown-toggle i.fa-user {
      margin-right: 8px;
      font-size: 16px;
      color: #FFD700;
    }

    .user-dropdown-toggle i.fa-caret-down {
      margin-left: 8px;
      transition: transform 0.3s ease;
    }

    .user-dropdown.active .user-dropdown-toggle i.fa-caret-down {
      transform: rotate(180deg);
    }

    .user-dropdown-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 100%;
      background-color: #fff;
      min-width: 220px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      border-radius: 8px;
      overflow: hidden;
      margin-top: 10px;
      transform-origin: top center;
      transform: translateY(-10px);
      opacity: 0;
      transition: all 0.3s ease;
      visibility: hidden;
      /* Thuộc tính kiểm soát hiển thị */
      pointer-events: none;
      /* Vô hiệu hóa sự kiện khi ẩn */
    }

    .user-dropdown-menu:before {
      content: '';
      position: absolute;
      top: -8px;
      right: 20px;
      width: 16px;
      height: 16px;
      background-color: #fff;
      transform: rotate(45deg);
      border-top-left-radius: 4px;
      box-shadow: -2px -2px 5px rgba(0, 0, 0, 0.05);
    }

    .user-dropdown-menu a {
      color: #333 !important;
      padding: 14px 20px;
      text-decoration: none;
      display: flex;
      align-items: center;
      transition: all 0.3s ease;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      font-weight: 500;
    }

    .user-dropdown-menu a:last-child {
      border-bottom: none;
    }

    .user-dropdown-menu a:hover {
      background-color: #f8f9fa;
      padding-left: 25px;
      color: #007bff !important;
    }

    .user-dropdown-menu a i {
      margin-right: 12px;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 16px;
      color: #555;
      transition: all 0.3s ease;
    }

    .user-dropdown-menu a:hover i {
      color: #007bff;
      transform: scale(1.1);
    }

    .user-dropdown-menu a.logout-link {
      background-color: #f8f8f8;
    }

    .user-dropdown-menu a.logout-link:hover {
      background-color: #ffebee;
      color: #f44336 !important;
    }

    .user-dropdown-menu a.logout-link:hover i {
      color: #f44336;
    }

    .user-dropdown-menu.show {
      display: block !important;
      transform: translateY(0);
      opacity: 1;
      visibility: visible !important;
      pointer-events: auto !important;
      /* Cho phép tương tác khi hiển thị */
    }

    /* Badge thông báo */
    .notification-badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background-color: #f44336;
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Animation cho dropdown */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Đã kết hợp với định nghĩa ở trên */
    /* .user-dropdown-menu.show {
      animation: fadeIn 0.3s ease forwards;
    } */
  </style>
</head>

<body>
  <!-- START PAGE SOURCE -->
  <div class="main">
    <div id="header" class="box">
      <h1 id="logo">Blog<span>LinhTinh</span> <i class="fa fa-pencil" aria-hidden="true"></i></h1>
      <ul id="nav">
        <li class="current"><a href="index.html"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
        <li><a href="subpage.html"><i class="fa fa-envelope" aria-hidden="true"></i> Liên hệ</a></li>
        <li><a href="#"><i class="fa fa-info-circle" aria-hidden="true"></i> Giới thiệu</a></li>
        <?php
        if (!isset($_SESSION['username'])) { ?>
          <li class="auth-buttons"><a href="#" id="registerBtn"><i class="fa fa-user-plus" aria-hidden="true"></i> Đăng
              ký</a></li>
          <li class="auth-buttons"><a href="#" id="loginBtn"><i class="fa fa-sign-in" aria-hidden="true"></i> Đăng
              nhập</a></li><?php
        } else {
          ?>
          <li class="user-dropdown" id="userDropdown">
            <div class="user-dropdown-toggle">
              <i class="fa fa-user" aria-hidden="true"></i>
              <span id="username-display"><?php echo $_SESSION['username']; ?></span>
              <i class="fa fa-caret-down" aria-hidden="true"></i>
            </div>
            <div class="user-dropdown-menu">
              <a href="#"><i class="fa fa-id-card" aria-hidden="true"></i> Thông tin cá nhân</a>
              <a href="#"><i class="fa fa-file-text" aria-hidden="true"></i> Bài viết đã đăng
                <span class="notification-badge">3</span>
              </a>
              <a href="#" class="logout-link" id="logoutBtn"><i class="fa fa-sign-out" aria-hidden="true"></i> Đăng
                xuất</a>
            </div>
          </li>
          <?php
        }
        ?>
      </ul>
    </div>
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
        <form action="#" method="get" id="search">
          <h3><i class="fa fa-filter"></i> Bộ lọc tìm kiếm</h3>
          <div class="filter-box">

            <input type="text" size="28" class="input-text" placeholder="Tìm theo tên tác giả hoặc tiêu đề..." />

            <div class="category-filter">
              <div class="dropdown-check-list">
                <span class="anchor">Chọn thể loại</span>
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
                </ul>
              </div>
            </div>

            <input type="submit" value="Tìm kiếm" class="input-submit" name="search" />

          </div>
        </form>
        <style>
          .filter-box {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
          }

          .category-filter {
            margin: 10px 0;
          }

          .category-filter h4 {
            margin: 5px 0;
            font-size: 14px;
          }

          .dropdown-check-list {
            display: inline-block;
            width: 90%;
          }

          .dropdown-check-list .anchor {
            position: relative;
            cursor: pointer;
            display: inline-block;
            padding: 5px 10px;
            border: 1px solid #ccc;
            width: 100%;
            background: #fff;
            margin-bottom: 5px;
          }

          .dropdown-check-list .anchor:after {
            position: absolute;
            content: "";
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #000;
            right: 10px;
            top: 45%;
          }

          .dropdown-check-list .items {
            display: none;
            border: 1px solid #ccc;
            border-top: none;
            position: absolute;
            z-index: 1;
            background: #fff;
            width: 15%;
            max-height: 200px;
            overflow-y: auto;
            margin: 0;
          }

          .dropdown-check-list .items li {
            list-style: none;
            padding: 5px;
            margin: 0;
          }

          .dropdown-check-list .items li label {
            display: inline-block;
            margin-left: 5px;
          }
        </style>
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            var checkList = document.querySelector('.dropdown-check-list');
            var anchor = checkList.querySelector('.anchor');
            var items = checkList.querySelector('.items');

            anchor.addEventListener('click', function () {
              if (items.style.display === 'block') {
                items.style.display = 'none';
              } else {
                items.style.display = 'block';
              }
            });

            // Đóng dropdown khi click ra ngoài
            document.addEventListener('click', function (e) {
              if (!checkList.contains(e.target)) {
                items.style.display = 'none';
              }
            });
          });
        </script>
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
      <form action="../controllers/userController.php?action=login" method="post">
        <div class="form-group">
          <label for="loginEmail">Email hoặc tên đăng nhập</label>
          <input type="text" id="loginEmail" name="loginEmail" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="loginPassword">Mật khẩu</label>
          <div style="position: relative;">
            <input type="password" id="loginPassword" name="loginPassword" class="form-control" required>
            <i class="fa fa-eye-slash toggle-password" aria-hidden="true"
              style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
          </div>
        </div>
        <div class="form-group">
          <input type="checkbox" id="remember" name="remember">
          <label for="remember" style="display: inline-block; margin-left: 5px;">Ghi nhớ đăng nhập</label>
        </div>
        <button type="submit" class="btn-submit">Đăng nhập</button>
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
      <form action="../controllers/userController.php?action=register" method="post">
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
          <small class="form-text text-muted">Mật khẩu phải có ít nhất 8 ký tự</small>
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

        <button type="submit" class="btn-submit">Đăng ký</button>
        <div class="form-footer">
          <p>Đã có tài khoản? <a href="#" id="switchToLogin">Đăng nhập</a></p>
        </div>
      </form>
    </div>
  </div>

  <script type="text/javascript">Cufon.now();</script>
  <!-- END PAGE SOURCE -->

  <script>
    // JavaScript để điều khiển hiển thị form
    document.addEventListener('DOMContentLoaded', function () {
      // Lấy các phần tử modal
      var loginModal = document.getElementById('loginModal');
      var registerModal = document.getElementById('registerModal');

      // Lấy các nút mở modal
      var loginBtn = document.getElementById('loginBtn');
      var registerBtn = document.getElementById('registerBtn');

      // Lấy các phần tử đóng modal
      var closeLogin = document.getElementById('closeLogin');
      var closeRegister = document.getElementById('closeRegister');

      // Lấy các nút chuyển đổi giữa đăng nhập và đăng ký
      var switchToRegister = document.getElementById('switchToRegister');
      var switchToLogin = document.getElementById('switchToLogin');

      // Khi người dùng nhấp vào nút đăng nhập
      loginBtn.onclick = function (e) {
        e.preventDefault();
        loginModal.style.display = 'block';
      }

      // Khi người dùng nhấp vào nút đăng ký
      registerBtn.onclick = function (e) {
        e.preventDefault();
        registerModal.style.display = 'block';
      }

      // Khi người dùng nhấp vào nút đóng
      closeLogin.onclick = function () {
        loginModal.style.display = 'none';
      }

      closeRegister.onclick = function () {
        registerModal.style.display = 'none';
      }

      // Khi người dùng nhấp vào nút chuyển đổi
      switchToRegister.onclick = function (e) {
        e.preventDefault();
        loginModal.style.display = 'none';
        registerModal.style.display = 'block';
      }

      switchToLogin.onclick = function (e) {
        e.preventDefault();
        registerModal.style.display = 'none';
        loginModal.style.display = 'block';
      }

      // Khi người dùng nhấp vào bất kỳ đâu bên ngoài modal
      window.onclick = function (event) {
        if (event.target == loginModal) {
          loginModal.style.display = 'none';
        }
        if (event.target == registerModal) {
          registerModal.style.display = 'none';
        }
      }

      // Kiểm tra mật khẩu khớp nhau
      var password = document.getElementById('password');
      var confirmPassword = document.getElementById('confirmPassword');
      var passwordMatchMessage = document.getElementById('passwordMatchMessage');
      var registerForm = document.querySelector('#registerModal form');

      // Hàm kiểm tra mật khẩu
      function checkPasswordMatch() {
        if (confirmPassword.value === '') {
          passwordMatchMessage.style.display = 'none';
          return;
        }

        if (password.value === confirmPassword.value) {
          passwordMatchMessage.textContent = 'Mật khẩu khớp!';
          passwordMatchMessage.style.color = 'green';
          passwordMatchMessage.style.display = 'block';
          confirmPassword.setCustomValidity('');
        } else {
          passwordMatchMessage.textContent = 'Mật khẩu không khớp!';
          passwordMatchMessage.style.color = 'red';
          passwordMatchMessage.style.display = 'block';
          confirmPassword.setCustomValidity('Mật khẩu không khớp');
        }
      }

      // Gắn sự kiện kiểm tra khi nhập
      password.addEventListener('input', checkPasswordMatch);
      confirmPassword.addEventListener('input', checkPasswordMatch);

      // Kiểm tra khi submit form đăng ký
      registerForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Kiểm tra mật khẩu khớp nhau
        if (password.value !== confirmPassword.value) {
          checkPasswordMatch();
          return;
        }

        // Kiểm tra các trường bắt buộc
        var fullname = document.getElementById('username');
        var email = document.getElementById('email');
        var termsCheckbox = document.getElementById('terms');

        if (!fullname.value.trim()) {
          alert('Vui lòng nhập họ tên');
          return;
        }

        if (!email.value.trim()) {
          alert('Vui lòng nhập email');
          return;
        }

        if (!password.value.trim()) {
          alert('Vui lòng nhập mật khẩu');
          return;
        }

        if (!termsCheckbox.checked) {
          alert('Vui lòng đồng ý với điều khoản sử dụng');
          return;
        }

        // Hiển thị loading
        var submitBtn = registerForm.querySelector('button[type="submit"]');
        var originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
        submitBtn.disabled = true;

        // Giả lập đăng ký thành công sau 1.5 giây
        setTimeout(function () {
          // Đóng modal đăng ký
          registerModal.style.display = 'none';

          // Lưu thông tin người dùng vào session (giả lập)
          // Trong thực tế, đây sẽ là phản hồi từ máy chủ
          var username = fullname.value;

          // Hiển thị thông báo đăng ký thành công
          alert('Đăng ký thành công! Chào mừng ' + username);

          // Tải lại trang với thông tin người dùng mới
          window.location.href = 'index.php?register_success=true&username=' + encodeURIComponent(username);
        }, 1500);
      })

      // Chức năng bật tắt hiển thị mật khẩu
      document.querySelectorAll('.toggle-password').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
          const passwordField = this.previousElementSibling;
          const type = passwordField.getAttribute('type');

          if (type === 'password') {
            passwordField.setAttribute('type', 'text');
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
          } else {
            passwordField.setAttribute('type', 'password');
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
          }
        });
      });

      // Xử lý form đăng nhập
      var loginForm = document.querySelector('#loginModal form');
      if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
          e.preventDefault();

          // Kiểm tra các trường bắt buộc
          var email = document.getElementById('loginEmail');
          var password = document.getElementById('loginPassword');

          if (!email.value.trim()) {
            alert('Vui lòng nhập email hoặc tên đăng nhập');
            return;
          }

          if (!password.value.trim()) {
            alert('Vui lòng nhập mật khẩu');
            return;
          }

          // Hiển thị loading
          var submitBtn = loginForm.querySelector('button[type="submit"]');
          var originalBtnText = submitBtn.innerHTML;
          submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
          submitBtn.disabled = true;

          // Giả lập đăng nhập thành công sau 1.5 giây
          setTimeout(function () {
            // Đóng modal đăng nhập
            loginModal.style.display = 'none';

            // Lưu thông tin người dùng vào session (giả lập)
            // Trong thực tế, đây sẽ là phản hồi từ máy chủ
            var username = email.value;

            // Hiển thị thông báo đăng nhập thành công
            alert('Đăng nhập thành công! Chào mừng trở lại, ' + username);

            // Tải lại trang với thông tin người dùng mới
            window.location.href = 'index.php?login_success=true&username=' + encodeURIComponent(username);
          }, 1500);
        });
      }

      // Xử lý dropdown người dùng
      $(document).ready(function () {
        // Mở/đóng dropdown khi nhấp vào
        $('.user-dropdown-toggle').on('click', function (e) {
          e.preventDefault();
          e.stopPropagation();

          var $dropdown = $(this).closest('.user-dropdown');
          var $menu = $dropdown.find('.user-dropdown-menu');

          // Đóng tất cả các dropdown khác
          $('.user-dropdown-menu').not($menu).removeClass('show');
          $('.user-dropdown').not($dropdown).removeClass('active');

          // Mở/đóng dropdown hiện tại
          $menu.toggleClass('show');
          $dropdown.toggleClass('active');

          // Debug
          console.log('Dropdown clicked');
          console.log('Show class:', $menu.hasClass('show'));
          console.log('Display style:', $menu.css('display'));

          // Đảm bảo hiển thị dropdown và xử lý các thuộc tính CSS
          if ($menu.hasClass('show')) {
            $menu.css({
              'display': 'block',
              'visibility': 'visible',
              'pointer-events': 'auto'
            });
            console.log('Dropdown opened');
          } else {
            $menu.css({
              'display': 'none',
              'visibility': 'hidden',
              'pointer-events': 'none'
            });
            console.log('Dropdown closed');
          }

          // Thêm hiệu ứng ripple khi nhấp vào
          var $ripple = $('<span class="ripple"></span>');
          var $button = $(this);
          var buttonPos = $button.offset();
          var xPos = e.pageX - buttonPos.left;
          var yPos = e.pageY - buttonPos.top;

          $ripple.css({
            top: yPos,
            left: xPos
          }).appendTo($button);

          setTimeout(function () {
            $ripple.remove();
          }, 600);
        });

        // Đóng dropdown khi nhấp ra ngoài
        $(document).on('click', function (e) {
          if (!$(e.target).closest('.user-dropdown').length) {
            var $menu = $('.user-dropdown-menu');
            $menu.removeClass('show');
            $('.user-dropdown').removeClass('active');

            // Đảm bảo các thuộc tính CSS được đặt lại
            $menu.css({
              'display': 'none',
              'visibility': 'hidden',
              'pointer-events': 'none'
            });
            console.log('Dropdown closed by outside click');
          }
        });

        // Xử lý sự kiện đăng xuất
        $('#logoutBtn').on('click', function (e) {
          e.preventDefault();

          // Hiển thị loading
          var $logoutBtn = $(this);
          var originalText = $logoutBtn.html();
          $logoutBtn.html('<i class="fa fa-spinner fa-spin"></i> Đang đăng xuất...');

          // Giả lập đăng xuất sau 1 giây
          setTimeout(function () {
            // Chuyển hướng đến trang đăng xuất
            window.location.href = 'index.php?logout=true';
          }, 1000);
        });

        // Thêm hiệu ứng hover cho các mục trong dropdown
        $('.user-dropdown-menu a').on('mouseenter', function () {
          $(this).find('i').addClass('pulse');
        }).on('mouseleave', function () {
          $(this).find('i').removeClass('pulse');
        });

        // Xử lý đăng xuất
        $('#logoutBtn').on('click', function (e) {
          e.preventDefault();

          // Hiển thị hiệu ứng loading
          var $button = $(this);
          $button.html('<i class="fa fa-spinner fa-spin"></i> Đang đăng xuất...');

          // Giả lập đăng xuất sau 1 giây
          setTimeout(function () {
            // Chuyển hướng đến trang đăng xuất hoặc trang chủ
            window.location.href = 'index.php?logout=true';
          }, 1000);
        });
      });
    });
  </script>

  <style>
    /* CSS bổ sung cho hiệu ứng */
    .ripple {
      position: absolute;
      background: rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      transform: scale(0);
      width: 100px;
      height: 100px;
      pointer-events: none;
      animation: ripple-effect 0.6s linear;
    }

    @keyframes ripple-effect {
      to {
        transform: scale(2.5);
        opacity: 0;
      }
    }

    .pulse {
      animation: pulse 0.5s infinite alternate;
    }

    @keyframes pulse {
      from {
        transform: scale(1);
      }

      to {
        transform: scale(1.2);
      }
    }

    /* Hiệu ứng loading */
    .fa-spin {
      animation: fa-spin 1s infinite linear;
    }

    @keyframes fa-spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>

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