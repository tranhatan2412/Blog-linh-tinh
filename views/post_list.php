<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include 'head.php';
require_once '../models/userModel.php';
?>

<body>
   <div id="wrapper">
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
                        Post List
                     </div>
                     <div class="panel-body">
                        <div class="table-responsive">
                           <table class="table table-striped table-bordered table-hover">
                              <thead>
                                 <tr>
                                    <th style="text-align: center; width: 5%;">Order</th>
                                    <th style="text-align: center; width: 15%;">Title</th>
                                    <th style="text-align: center; width: 15%;">Short Content</th>
                                    <th style="text-align: center; width: 15%;">Full Content</th>
                                    <th style="text-align: center; width: 10%;">Author</th>
                                    <th style="text-align: center; width: 10%;">Date</th>
                                    <th style="text-align: center; width: 10%;">Category</th>
                                    <th style="text-align: center; width: 10%;">Image</th>
                                    <th style="text-align: center; width: 15%;">Action</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $userModel = new UserModel();
                                 $posts = $userModel->getAllPosts();
                                 $order = 1;
                                 if ($posts->num_rows === 0) {
                                    echo "<tr><td colspan='8' style='text-align: center;'>Không có dữ liệu</td></tr>";
                                 } else {
                                    foreach ($posts as $row) {
                                       ?>
                                       <form
                                          action="../controllers/userController.php?action=update&id=<?php echo $row['id']; ?>"
                                          method="post" enctype="multipart/form-data">
                                          <tr>
                                             <td style="text-align: center;"><?php echo $order++; ?></td>
                                             <td style="text-align: center;">
                                                <input type="text" name="title" value="<?php echo $row['title']; ?>"
                                                   style="width: 100%; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none; text-align: center;"
                                                   onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                   onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'">
                                             </td>
                                             <td style="text-align: center;">
                                                <textarea name="short_content"
                                                   style="width: 100%; height: 70px; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none; resize: vertical; text-align: center;"
                                                   onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                   onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'"><?php echo $row['short_content']; ?></textarea>
                                             </td>
                                             <td style="text-align: center;">
                                                <textarea name="full_content"
                                                   style="width: 100%; height: 70px; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none; resize: vertical; text-align: center;"
                                                   onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                   onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'"><?php echo $row['full_content']; ?></textarea>
                                             </td>
                                             <td style="text-align: center;">
                                                <input type="text" name="author" value="<?php echo $row['author']; ?>"
                                                   style="width: 100%; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none; text-align: center;"
                                                   onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                   onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'">
                                             </td>
                                             <td style="text-align: center;">
                                                <input type="date" name="date" value="<?php echo $row['date']; ?>"
                                                   style="width: 100%; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none; text-align: center;"
                                                   onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                   onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'">
                                             </td>
                                             <td style="text-align: center;">
                                                <select name="category"
                                                   style="width: 100%; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none; text-align: center;"
                                                   onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                   onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'">
                                                   <option value="<?php echo $row['category']; ?>">
                                                      <?php echo $row['category']; ?>
                                                   </option>
                                                   <?php
                                                   $categories = (new AdminModel())->getAllCategories();
                                                   foreach ($categories as $category) {
                                                      if ($category['name'] != $row['category']) {
                                                         echo "<option value='" . $category['name'] . "'>" . $category['name'] . "</option>";
                                                      }
                                                   }
                                                   ?>
                                                </select>
                                             </td>
                                             <td style="text-align: center;">

                                                <img src="<?php echo $row['image']; ?>"
                                                   style="max-width: 50px; max-height: 50px;">

                                                <input type="file" name="image" style="width: 100%; font-size: 10px;">
                                             </td>
                                             <td style="text-align: center;">

                                                <input class="btn btn-info btn-sm" type="submit" name="update" value="Update">
                                                <a href="../controllers/userController.php?action=delete&id=<?php echo $row['id']; ?>"
                                                   onclick="return confirm('Bạn có muốn xóa bài viết này không?');"
                                                   class="btn btn-danger btn-sm">Delete</a>

                                             </td>
                                          </tr>
                                       </form>
                                       <?php
                                    }
                                 }
                                 ?>
                              </tbody>
                           </table>
                        </div>
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