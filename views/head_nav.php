<?php
// Xác định trang hiện tại
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <div class="user-img-div">
                    <img src="/Admin/assets/img/user.png" class="img-thumbnail" />
                    <div class="inner-text">
                        Trần Nhật Tân
                        <br />
                        <small>Last Login : 2 Weeks Ago </small>
                    </div>
                </div>
            </li>
            <li>
                <a <?php echo ($current_page == 'dashboard.php') ? 'class="active-menu"' : ''; ?>
                    href="/Admin/views/dashboard.php"><i class="fa fa-dashboard "></i>Dashboard</a>
            </li>
            <li>
                <a <?php echo ($current_page == 'user-list.php') ? 'class="active-menu"' : ''; ?>
                    href="/Admin/views/user-list.php"><i class="fa fa-users "></i>User List</a>
            </li>
            <li>
                <a <?php echo ($current_page == 'category.php') ? 'class="active-menu"' : ''; ?>
                    href="/Admin/views/category.php"><i class="fa fa-tags "></i>Category</a>
            </li>
        </ul>
    </div>

</nav>