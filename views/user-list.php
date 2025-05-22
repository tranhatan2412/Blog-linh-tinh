<?php
require_once '../models/adminModel.php';

if ($_SESSION['username'] === null) {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User List</title>
    <?php
    include 'headIndex.php';
    include 'head.php';
    ?>
</head>

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


                <div class="row">
                    <div class="col-md-12" id="user-list">
                        <div class="panel panel-info">
                            <div class="panel-heading" style="text-align: center;">
                                User List
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table user-list table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 5%;">Order</th>
                                                <th style="text-align: center; width: 20%; "><a
                                                        href="../controllers/adminController.php?action=sort_username">Username  <span
                                                            class="fa fa-sort"></span></a></th>
                                                <th style="text-align: center; width: 25%;">Email</th>
                                                <th style="text-align: center; width: 15%;">Created Date</th>
                                                <th style="text-align: center; width: 5%;">Post</th>
                                                <th style="text-align: center; width: 15%;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $adminModel = new AdminModel();
                                            $users = $adminModel->getAllUsers();
                                            if ($users->num_rows === 0) {
                                                echo "<tr><td colspan='5' style='text-align: center;'>Không có dữ liệu</td></tr>";
                                            } else {
                                                $count = 1;
                                                foreach ($users as $row) {
                                                    ?>
                                                    <tr>
                                                        <td style="text-align: center;"><?php echo $count++; ?></td>

                                                        <td>
                                                            <?php echo $row['username']; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $row['email']; ?>
                                                        </td>
                                                        <td style="text-align: center;"><?php echo $row['created']; ?></td>
                                                        <td style="text-align: center;">
                                                            <?php echo $row['post']; ?>
                                                        </td>
                                                        <td style="text-align: center;">
                                                            <a href="../controllers/userController.php?action=delete&id=<?php echo $row['id']; ?>"
                                                                onclick="return confirm('Bạn có muốn xóa người dùng này không?');"
                                                                class="btn btn-danger btn-sm">Delete</a>
                                                        </td>
                                                    </tr>
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
                <!-- End of User List Table -->

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