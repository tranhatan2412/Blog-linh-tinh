<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Category</title>
    <?php
    include 'headIndex.php';
    include 'head.php';
    ?>
</head>
<?php
require_once '../models/adminModel.php';
?>

<body>
    <?php include '../utils/user-display.php'; ?>
    <?php include 'menu.php'; ?>
    <div id="wrapper">
        <?php include 'head_top.php' ?>
        <!-- /. NAV TOP  -->
        <?php include 'head_nav.php' ?>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
            <div id="page-inner">

                <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading" style="text-align: center;">
                                New Category
                            </div>
                            <div class="panel-body">
                                <form style="max-width: 600px; margin: 0 auto;"
                                    action="../controllers/adminController.php?action=addCategory" method="post">
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input name="name" class="form-control" type="text" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div align="center">
                                        <input type="submit" class="btn btn-info" name="upload" value="Upload">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12" id="category-list">
                        <div class="panel panel-info">
                            <div class="panel-heading" style="text-align: center;">
                                Category List
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 5%;">Order</th>
                                                <th style="text-align: center; width: 15%;">Category Name</th>
                                                <th style="text-align: center; width: 65%;">Description</th>
                                                <th style="text-align: center; width: 15%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $adminModel = new AdminModel();
                                            $categories = $adminModel->getAllCategories();
                                            $order = 1;
                                            if ($categories->num_rows === 0) {
                                                echo "<tr><td colspan='4' style='text-align: center;'>Không có dữ liệu</td></tr>";
                                            } else {
                                                foreach ($categories as $row) {
                                                    ?>
                                                    <form
                                                        action="../controllers/adminController.php?action=updateCategory&id=<?php echo $row['id']; ?>"
                                                        method="post">
                                                        <tr>
                                                            <td style="text-align: center;"><?php echo $order++; ?></td>

                                                            <td>
                                                                <input type="text" name="name"
                                                                    value="<?php echo $row['name']; ?>"
                                                                    style="width: 100%; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none;"
                                                                    onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                                    onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'">
                                                            </td>
                                                            <td>
                                                                <input type="text" name="description"
                                                                    value="<?php echo $row['description']; ?>"
                                                                    style="width: 100%; padding: 5px; box-sizing: border-box; border: 1px solid transparent; background: transparent; outline: none;"
                                                                    onfocus="this.style.borderColor='#5bc0de'; this.style.backgroundColor='#f8f9fa'"
                                                                    onblur="this.style.borderColor='transparent'; this.style.backgroundColor='transparent'">
                                                            </td>
                                                            <td style="text-align: center;">
                                                                <input class="btn btn-info btn-sm" type="submit" name="update"
                                                                    value="Update">

                                                                <a href="../controllers/adminController.php?action=deleteCategory&id=<?php echo $row['id']; ?>"
                                                                    onclick="return confirm('Bạn có muốn xóa danh mục này không?');"
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
                <!-- End of Category List Table -->

            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <?php include 'footer.php';

    if (isset($_SESSION['errorInsert'])) {
        echo "<script>alert('" . $_SESSION['errorInsert'] . "')</script>";
        unset($_SESSION['errorInsert']);
    }

    ?>
</body>

</html>