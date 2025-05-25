<?php
include '../models/adminModel.php';
if ($_SESSION['username'] === null) {
    header('Location: ../index.php');
    exit();
}
$adminModel = new AdminModel();
$post = $adminModel->getPostById($_GET['id']);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Post</title>
    <?php
    include 'headIndex.php';
    include 'head.php'
        ?>
</head>


<body>
    <?php
    include '../utils/user-display.php';
    include 'menu.php';
    ?>
    <div id="wrapper">

        <style>
            #page-wrapper {
                margin: 0 0 0 0;
            }
        </style>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">
                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div style="text-align: center;" class="panel-heading">
                                Update Post
                            </div>
                            <div class="panel-body">
                                <form action="../controllers/userController.php?action=updatePost&id=<?php echo $_GET['id'] ?>&username=<?php echo $_GET['username']; ?>&from=user"
                                    method="post" enctype="multipart/form-data"
                                    style="max-width: 600px; margin: 0 auto;">

                                    <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" type="text" name="title" required
                                            value="<?php echo $post['title']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Short Content</label>
                                        <textarea class="form-control" rows="2"
                                            name="short_content"><?php echo $post['short_content'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Full Content</label>
                                        <textarea class="form-control" rows="10"
                                            name="full_content"><?php echo $post['full_content'] ?></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category">
                                            <?php
                                            $categories = $adminModel->getAllCategories();
                                            if ($categories->num_rows == 0) {
                                                ?>
                                                <option value="">Không có danh mục nào</option>
                                                <?php
                                            } else {
                                                foreach ($categories as $category) {
                                                    ?>
                                                    <option value="<?php echo $category['name'] ?>" <?php if ($category['name'] === $post['category']) { ?> selected <?php } ?>>
                                                        <?php echo $category['name'] ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="">Picture</label>
                                        <input class="form-control" type="file" name="picture" id="imageUpload" accept="image/*" onchange="previewImage(this)">
                                        
                                        <div class="image-preview-container" style="margin-top: 10px;">
                                            <div class="current-image" style="margin-bottom: 10px;">
                                                <p>Current Image:</p>
                                                <img src="<?php echo $post['image'] ?>" alt="Current Image" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                            <div class="new-image" style="display: none;">
                                                <p>New Image Preview: <button type="button" class="btn btn-xs btn-danger" id="cancelImage">Hủy chọn ảnh</button></p>
                                                <img id="imagePreview" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>
                                        </div>
                                    </div>

                                    <div style="text-align: center;">
                                        <input type="submit" class="btn btn-info" value="Upload" name="upload">
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
    <?php include 'footer.php' ?>
    
    <script>
        // JavaScript trực tiếp để xử lý việc hủy chọn ảnh
        document.addEventListener('DOMContentLoaded', function() {
            const cancelButton = document.getElementById('cancelImage');
            if (cancelButton) {
                cancelButton.addEventListener('click', function() {
                    // Tìm input file
                    const imageUpload = document.getElementById('imageUpload');
                    if (imageUpload) {
                        // Reset giá trị của input file
                        imageUpload.value = '';
                        
                        // Ẩn phần xem trước ảnh mới
                        const newImageContainer = document.querySelector('.new-image');
                        if (newImageContainer) {
                            newImageContainer.style.display = 'none';
                        }
                    }
                });
            }
        });
    </script>
</body>

</html>