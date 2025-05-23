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
      include 'menu.php' ?>
      <?php include 'head_top.php' ?>
      <!-- /. NAV TOP  -->
      <?php include 'head_nav.php' ?>
      <!-- /. NAV SIDE  -->
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
                              $posts = (new UserModel())->getAllPosts();
                              if ($posts->num_rows == 0) {
                                 echo "<li>Không có bài viết nào</li>";
                              } else {
                                 foreach ($posts as $post): ?>
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
                                    </li>
                                 <?php endforeach;
                              } ?>
                           </ul>
                        </div>
                     </div>
                     <div align="center" class="pagination box">
                        <p class="f-right"> <a href="#" class="current">1</a> <a href="#">2</a> <a href="#">3</a> <a
                              href="#">4</a> <a href="#">5</a> <a href="#">6</a> <a href="#">7</a> <a href="#">Next
                              &raquo;</a> </p>
                        <p class="f-left">Page 1 of 13</p>
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
   <?php include 'footer.php';
   ?>
</body>

</html>