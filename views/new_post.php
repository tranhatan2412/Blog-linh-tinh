<?php
include '../models/adminModel.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Post</title>
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
        <?php if ($_REQUEST['action'] == 'new_post') {
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
                                New Post
                            </div>
                            <div class="panel-body">
                                <form action="../controllers/postController.php?action=add" method="post"
                                    enctype="multipart/form-data" style="max-width: 600px; margin: 0 auto;">

                                    <div class="form-group">
                                        <label>Title</label>
                                        <input class="form-control" type="text" name="title" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Short Content</label>
                                        <textarea class="form-control" rows="2" name="short_content"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Full Content</label>
                                        <textarea class="form-control" rows="5" name="full_content"></textarea>
                                    </div>


                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="category">
                                            <?php
                                            $adminModel = new AdminModel();
                                            $categories = $adminModel->getAllCategories();
                                            if ($categories->num_rows == 0) {
                                                ?>
                                                <option value="">Không có danh mục nào</option>
                                                <?php
                                            } else {
                                                foreach ($categories as $category) {
                                                    ?>
                                                    <option value="<?php echo $category['name'] ?>">
                                                        <?php echo $category['name'] ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Picture</label>
                                        <input class="form-control" type="file" name="picture" required>
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
</body>

</html>