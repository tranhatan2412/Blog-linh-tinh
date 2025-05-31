
<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">TRẦN NHẬT TÂN</a>
    </div>

    <div class="header-right">


        <a href="post_list.php?from=admin&status=0" class="btn btn-info" title="New Message"><b style="font-size: 20px; color: white; font-weight: bold; padding: 5px; "><?php echo (new UserModel())->getAllPostsUnCensored()->num_rows; ?></b><i
                class="fa fa-envelope-o fa-2x"></i></a>
        


    </div>
</nav>