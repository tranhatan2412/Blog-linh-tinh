<?php
$current_page = $_SERVER['REQUEST_URI'];
?>
<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li>
                <div class="user-img-div">
                    <img src="/Admin/assets/img/user.png" class="img-thumbnail" />
                    <div class="inner-text">
                        Nguyễn Thu Vân
                        <br />
                        <small>Last Login : 2 Weeks Ago </small>
                    </div>
                </div>
            </li>
            <li>
                <a <?php echo (strpos($current_page, 'index.php') !== false) ? 'class="active-menu"' : ''; ?>
                    href="/Admin/views/dashboard.php"><i class="fa fa-dashboard "></i>Dashboard</a>
            </li>
            <li>
                <a><i class="fa fa-desktop "></i>Content <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse in">
                    <li>
                        <a <?php echo (strpos($current_page, 'new_post.php') !== false) ? 'class="active-menu"' : ''; ?>
                            href="/Admin/views/new_post.php"><i class="fa fa-plus"></i>New Post</a>
                    </li>
                    <li>
                        <a <?php echo (strpos($current_page, 'post_list.php') !== false) ? 'class="active-menu"' : ''; ?>
                            href="/Admin/views/post_list.php"><i class="fa fa-list"></i>Post List</a>
                    </li>
                </ul>
            </li>
            <li>
                <a <?php echo (strpos($current_page, 'category.php') !== false) ? 'class="active-menu"' : ''; ?>
                    href="/Admin/views/categoryAdmin.php"><i class="fa fa-desktop "></i>Category</a>
            </li>
        </ul>
    </div>

</nav>