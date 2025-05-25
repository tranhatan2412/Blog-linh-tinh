<?php
require_once '../models/userModel.php';
if ($_SESSION['username'] === null) {
   header('Location: ../index.php');
   exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Post List</title>
   <?php
   include 'headIndex.php';
   include 'head.php';
   ?>
</head>

<body>
   <div id="wrapper">
      <?php include '../utils/user-display.php';
      include 'menu.php';
      if ($_SESSION['role'] === 'admin' && isset($_GET['from']) && $_GET['from'] === 'admin') {
         include 'head_top.php';
         include 'head_nav.php';
      } else { ?>
         <style>
            #page-wrapper {
               margin: 0 0 0 0;
            }
         </style>
      <?php } ?>
      <div id="page-wrapper">
         <div id="page-inner">
            <div class="row">
               <div class="col-md-12" id="post-list">
                  <div class="panel panel-info">
                     <div class="panel-heading" style="text-align: center;">
                        Post List <?php echo "of {$_GET['username']}"; ?>
                     </div>
                     <div class="panel-body">
                        <div class="table-responsive">
                           <ul class="articles box">
                              <?php
                              // Phân trang
                              $itemsPerPage = 5; // Số bài viết mỗi trang
                              $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

                              // Lấy tất cả bài viết
                              $allPosts = (new UserModel())->getAllPosts($_GET['username']);
                              $totalItems = $allPosts->num_rows;
                              $totalPages = ceil($totalItems / $itemsPerPage);

                              // Đảm bảo trang hiện tại không vượt quá tổng số trang
                              if ($totalPages > 0) {
                                 $currentPage = min($currentPage, $totalPages);
                              } else {
                                 $currentPage = 1;
                              }

                              // Tính vị trí bắt đầu và kết thúc cho các bài viết trên trang hiện tại
                              $startIndex = ($currentPage - 1) * $itemsPerPage;
                              $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                              // Lấy các bài viết cho trang hiện tại
                              $currentPosts = [];
                              $counter = 0;

                              if ($totalItems > 0) {
                                 foreach ($allPosts as $post) {
                                    if ($counter >= $startIndex && $counter < $endIndex) {
                                       $currentPosts[] = $post;
                                    }
                                    $counter++;
                                 }
                              }

                              if (empty($currentPosts)) {
                                 echo "<li style='text-align: center;'>Không có bài viết nào</li>";
                              } else {
                                 foreach ($currentPosts as $post): ?>
                                    <li>
                                       <h2><a href="#"><?php echo $post['title']; ?></a></h2>
                                       <div class="article-info box">
                                          <p class="f-right"><a href="#" class="comment">Comments (15)</a></p>
                                          <p class="f-left"><?php echo date('d/m/Y H:i', strtotime($post['created'])); ?> |
                                             Posted by <a style="text-decoration: underline; color: red;"
                                                href="#"><?php echo $post['author']; ?></a> | Category: <a
                                                style="text-decoration: underline; color: red;"
                                                href="#"><?php echo $post['category']; ?></a></p>
                                       </div>

                                       <p><img src="<?php echo $post['image']; ?>" alt=""
                                             class="f-left" /><?php echo $post['short_content']; ?></p>

                                       <p style="min-height: 30px;" class="more"><a href="#">Read more &raquo;</a></p>
                                       <?php if (isset($_GET['from']) && $_GET['from'] === 'user') { ?>
                                          <a href="update_post.php?action=update&id=<?php echo $post['id']; ?>&username=<?php echo $_GET['username']; ?>"
                                             class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                       <?php } ?>
                                       <a href="../controllers/userController.php?action=deletePost&id=<?php echo $post['id']; ?>&from=<?php echo $_GET['from']; ?>&username=<?php echo $_GET['username']; ?>"
                                          class="btn btn-danger" onclick="return confirm('Bạn có muốn xóa bài viết này?')"><i
                                             class="fa fa-trash"></i></a>
                                    </li>
                                 <?php endforeach;
                              } ?>
                           </ul>
                        </div>
                     </div>
                     <?php
                     // Hiển thị thanh phân trang nếu có bài viết
                     if ($totalItems > 0) {
                        ?>
                        <div class="pagination-container">
                           <!-- Nút về đầu -->
                           <a href="?page=1<?php echo isset($_GET['username']) ? '&username=' . urlencode($_GET['username']) : ''; ?><?php echo isset($_GET['link']) ? '&link=' . urlencode($_GET['link']) : ''; ?>"
                              class="pagination-arrow<?php echo ($currentPage <= 1) ? ' disabled' : ''; ?>"
                              title="Về đầu">&laquo;&laquo;</a>

                           <!-- Nút lùi 1 trang -->
                           <?php $prevPage = max(1, $currentPage - 1); ?>
                           <a href="?page=<?php echo $prevPage; ?><?php echo isset($_GET['username']) ? '&username=' . urlencode($_GET['username']) : ''; ?><?php echo isset($_GET['link']) ? '&link=' . urlencode($_GET['link']) : ''; ?>"
                              class="pagination-arrow<?php echo ($currentPage <= 1) ? ' disabled' : ''; ?>"
                              title="Trang trước">&laquo;</a>

                           <!-- Các số trang -->
                           <div class="pagination-numbers">
                              <?php
                              // Hiển thị tối đa 5 số trang, với trang hiện tại ở giữa nếu có thể
                              $startPage = max(1, $currentPage - 2);
                              $endPage = min($totalPages, $startPage + 4);

                              // Điều chỉnh lại startPage nếu endPage đã đạt giới hạn
                              if ($endPage - $startPage < 4) {
                                 $startPage = max(1, $endPage - 4);
                              }

                              for ($i = $startPage; $i <= $endPage; $i++):
                                 ?>
                                 <a href="?page=<?php echo $i; ?><?php echo isset($_GET['username']) ? '&username=' . urlencode($_GET['username']) : ''; ?><?php echo isset($_GET['link']) ? '&link=' . urlencode($_GET['link']) : ''; ?>"
                                    class="<?php echo ($i == $currentPage) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                              <?php endfor; ?>
                           </div>

                           <!-- Nút tiến 1 trang -->
                           <?php $nextPage = min($totalPages, $currentPage + 1); ?>
                           <a href="?page=<?php echo $nextPage; ?><?php echo isset($_GET['username']) ? '&username=' . urlencode($_GET['username']) : ''; ?><?php echo isset($_GET['link']) ? '&link=' . urlencode($_GET['link']) : ''; ?>"
                              class="pagination-arrow<?php echo ($currentPage >= $totalPages) ? ' disabled' : ''; ?>"
                              title="Trang sau">&raquo;</a>

                           <!-- Nút đến cuối -->
                           <a href="?page=<?php echo $totalPages; ?><?php echo isset($_GET['username']) ? '&username=' . urlencode($_GET['username']) : ''; ?><?php echo isset($_GET['link']) ? '&link=' . urlencode($_GET['link']) : ''; ?>"
                              class="pagination-arrow<?php echo ($currentPage >= $totalPages) ? ' disabled' : ''; ?>"
                              title="Đến cuối">&raquo;&raquo;</a>

                           <!-- Hiển thị thông tin trang hiện tại/tổng số trang -->
                           <span style="margin-left: 15px; font-size: 14px;">
                              Trang <?php echo $currentPage; ?> / <?php echo $totalPages; ?>
                           </span>
                        </div>
                        <?php
                     }
                     ?>
                  </div>
               </div>
            </div>
         </div>
         <!-- /. PAGE INNER  -->
      </div>
      <!-- /. PAGE WRAPPER  -->
   </div>
   <!-- /. WRAPPER  -->
   <?php include 'footer.php';
   ?>
</body>

</html>