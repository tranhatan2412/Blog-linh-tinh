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