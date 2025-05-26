<?php
include 'models/adminModel.php';

$adminModel = new AdminModel();
if(isset($_SESSION['username']))
$_SESSION['totalPostsUser'] = $adminModel->getAllPostsByUser($_SESSION['username'])->num_rows;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include 'views/headIndex.php'; ?>

<body>
  <!-- START PAGE SOURCE -->
  <div class="main">
    <?php include 'utils/user-display.php';
    include 'views/menu.php' ?>
    <form action="index.php" method="get" id="search">
      <h3><i class="fa fa-filter"></i> Bộ lọc tìm kiếm</h3>
      <div class="filter-box modern-filter">
        <div class="search-row">
          <div class="input-with-icon">
            <i class="fa fa-user"></i>
            <input type="text" name="author" class="input-text" placeholder="Tìm theo tên tác giả..." />
          </div>

          <div class="input-with-icon">
            <i class="fa fa-book"></i>
            <input type="text" name="title" class="input-text" placeholder="Tìm theo tiêu đề..." />
          </div>

          <div class="filter-item">
            <div class="dropdown-check-list" id="categoryDropdown">
              <span class="anchor"><i class="fa fa-tags"></i> Chọn thể loại <span class="category-count">0</span></span>
              <ul class="items">
                <?php
                $categories = $adminModel->getAllCategories();
                foreach ($categories as $category): ?>
                  <li><input type="checkbox" id="cat<?php echo $category['id']; ?>" name="category[]"
                      value="<?php echo $category['name']; ?>" /><label for="cat<?php echo $category['id']; ?>"><?php echo $category['name']; ?></label>
                  </li>
                <?php endforeach; ?>
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
    <?php
    $allPosts = $adminModel->getAllPosts()->fetch_all(MYSQLI_ASSOC);
    if (isset($_GET['search'])) {
      $allPosts = $adminModel->searchPosts($_GET['author'] ?? null, $_GET['title'] ?? null, $_GET['category'] ?? null)->fetch_all(MYSQLI_ASSOC);
    }
    if (isset($_GET['author']))
      $allPosts = $adminModel->searchPosts($_GET['author'], null, null)->fetch_all(MYSQLI_ASSOC);
    if (isset($_GET['title']))
      $allPosts = $adminModel->searchPosts(null, $_GET['title'], null)->fetch_all(MYSQLI_ASSOC);
    if (isset($_GET['category']))
      $allPosts = $adminModel->searchPosts(null, null, $_GET['category'])->fetch_all(MYSQLI_ASSOC);
    $totalItems = count($allPosts);
  

    // Thiết lập phân trang
    $itemsPerPage = 5; // Số bài viết mỗi trang
    $totalPages = ceil($totalItems / $itemsPerPage);
    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $currentPage = min($currentPage, max(1, $totalPages)); // Đảm bảo trang hiện tại không vượt quá tổng số trang
    
    // Lấy dữ liệu cho trang hiện tại
    $offset = ($currentPage - 1) * $itemsPerPage;
    $posts = array_slice($allPosts, $offset, $itemsPerPage);
    ?>
    <div id="section" class="box">
      <div id="content">
        <ul class="articles box">
          <?php foreach ($posts as $post): ?>
            <li>
              <h2><a href="views/full-content.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h2>
              <div class="article-info box">
                <p class="f-right"><a href="#" class="comment">Comments (15)</a></p>
                <p class="f-left"><?php echo date('d/m/Y H:i', strtotime($post['created'])); ?> | Posted by <a
                    style="text-decoration: underline; color: red;" href="index.php?author=<?php echo $post['author']; ?>"><?php echo $post['author']; ?></a> |
                  Category: <a style="text-decoration: underline; color: red;"
                    href="index.php?category[]=<?php echo $post['category']; ?>"><?php echo $post['category']; ?></a></p>
              </div>

              <p><img src="<?php echo $post['image']; ?>" alt="" class="f-left" /><?php echo $post['short_content']; ?>
              </p>
              <p style="min-height: 30px;" class="more"><a
                  href="views/full-content.php?id=<?php echo $post['id']; ?>">Read more &raquo;</a></p>
            </li>
          <?php endforeach; ?>

        </ul>
        <?php if ($totalItems > 0): ?>
          <div class="pagination-container">
            <!-- Nút về đầu -->
            <a href="?page=1" class="pagination-arrow<?php echo ($currentPage <= 1) ? ' disabled' : ''; ?>"
              title="Về đầu">&laquo;&laquo;</a>

            <!-- Nút lùi 5 trang -->
            <?php $prevPage = max(1, $currentPage - 5); ?>
            <a href="?page=<?php echo $prevPage; ?>"
              class="pagination-arrow<?php echo ($currentPage <= 1) ? ' disabled' : ''; ?>"
              title="Lùi 5 trang">&laquo;</a>

            <!-- Các số trang -->
            <div class="pagination-numbers">
              <?php
              $startPage = max(1, $currentPage - 2);
              $endPage = min($totalPages, $startPage + 4);
              $startPage = max(1, min($startPage, $endPage - 4));

              for ($i = $startPage; $i <= $endPage; $i++):
                ?>
                <a href="?page=<?php echo $i; ?>"
                  class="<?php echo ($i == $currentPage) ? 'active' : ''; ?>"><?php echo $i; ?></a>
              <?php endfor; ?>
            </div>

            <!-- Nút tiến 5 trang -->
            <?php $nextPage = min($totalPages, $currentPage + 5); ?>
            <a href="?page=<?php echo $nextPage; ?>"
              class="pagination-arrow<?php echo ($currentPage >= $totalPages) ? ' disabled' : ''; ?>"
              title="Tiến 5 trang">&raquo;</a>

            <!-- Nút đến cuối -->
            <a href="?page=<?php echo $totalPages; ?>"
              class="pagination-arrow<?php echo ($currentPage >= $totalPages) ? ' disabled' : ''; ?>"
              title="Đến cuối">&raquo;&raquo;</a>

            <!-- Hiển thị thông tin trang hiện tại/tổng số trang -->
            <span style="margin-left: 15px; font-size: 14px;">
              Trang <?php echo $currentPage; ?> / <?php echo $totalPages; ?>
            </span>


          </div>
        <?php endif; ?>
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
          <small id="usernameMessage" class="form-text">Tên đăng nhập chỉ chứa chữ cái và số</small>
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