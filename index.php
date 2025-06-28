<?php
session_start();

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
  // Xóa toàn bộ session
  session_unset(); // Xóa tất cả biến session
  session_destroy(); // Hủy session

  // Quay về lại trang chủ
  header("Location: index.php");
  exit();
}


$page = isset($_GET['page']) ? $_GET['page'] : 'main';
$allowed_pages = ['main', 'user', 'user_infor', 'tag', 'mainPost', 'tro_chuyen','check','bai_post','cau_hoi','cap_nhat','feedback']; // an toàn tránh include linh tinh


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Style/main.css">
  <link rel="stylesheet" href="Style/mainPost.css">
  <link rel="stylesheet" href="Style/nav.css">
  <link rel="stylesheet" href="Style/header.css">
  <link rel="stylesheet" href="Style/user.css">
  <link rel="stylesheet" href="Style/user_infor.css">
    <link rel="stylesheet" href="Style/tag.css">
  <title>Stack Overflow - Newest Questions</title>
</head>

<body>
  <header> <?php include 'Code/header.php'; ?> </header>
  <div class="container-wrapper">
    <nav class="navigate" style="width:20%;"> 
      <?php include 'Code/nav.php'; 
      include 'Code/top_bxh.php'; 
      ?> </nav>
    <div id="main-content" class="container" style="width:70%;">
      <?php
      if (in_array($page, $allowed_pages)) {
        if ($page === 'tro_chuyen') {
          echo "<script>window.location.href = 'Code/tro_chuyen.php';</script>";
        } else {
          include "Code/{$page}.php";
        }
      } else {
        echo "<p>Không tìm thấy nội dung.</p>";
      }
      ?></div>
  </div>

  <!-- Thêm script để xử lý click -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $(document).on('click', '.question-title', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        $('#main-content').load(url);
      });
    });
  </script>


  <footer id="footer"><?php include 'Code/footer.php'; ?></footer>

</body>

</html>