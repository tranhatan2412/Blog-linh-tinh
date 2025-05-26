<?php
// Bao gồm các file cần thiết
require_once '../models/adminModel.php';

$adminModel = new AdminModel();

// Lấy thông tin bài viết
$post = $adminModel->getPostById($_GET['id']);

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css" media="screen" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <style>
        .full-content-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .article-header {
            margin-bottom: 30px;
        }
        
        .article-title {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }
        
        .article-meta {
            margin-bottom: 20px;
            color: #666;
            font-size: 14px;
        }
        
        .article-image {
            max-width: 100%;
            height: auto;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .article-content {
            line-height: 1.8;
            font-size: 16px;
            color: #333;
            margin-bottom: 30px;
        }
        
        .back-button {
            display: inline-block;
            padding: 8px 16px;
            background-color: #e74c3c;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .back-button:hover {
            background-color: #c0392b;
        }
    </style>
</head>

<body>
    <!-- START PAGE SOURCE -->
    <div class="main">
        <?php include '../utils/user-display.php';
        include 'menu.php' ?>

        <div class="full-content-container box">
            <div class="article-header">
                <h1 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                <div class="article-info box">
                    <p class="f-right"><a href="#" class="comment">Comments (15)</a></p>
                    <p class="f-left"><?php echo date('d/m/Y H:i', strtotime($post['created'])); ?> | Posted by <a
                            style="text-decoration: underline; color: red;" href="../index.php?author=<?php echo urlencode($post['author']); ?>"><?php echo htmlspecialchars($post['author']); ?></a> |
                        Category: <a style="text-decoration: underline; color: red;"
                            href="../index.php?category[]=<?php echo urlencode($post['category']); ?>"><?php echo htmlspecialchars($post['category']); ?></a></p>
                </div>
            </div>

            <?php if (!empty($post['image'])): ?>
                <div class="article-image">
                    <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" style="max-width: 100%;" />
                </div>
            <?php endif; ?>

            <div class="article-content">
                <?php 
                // Hiển thị nội dung đầy đủ của bài viết
                 if(isset($post['full_content']))
                    echo htmlspecialchars($post['full_content']);
                
                ?>
            </div>

            <a href="#" onclick="window.history.back(); return false;" class="back-button"><i class="fa fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>
    <!-- END PAGE SOURCE -->

    <script src="../assets/js/main.js"></script>
</body>

</html>
