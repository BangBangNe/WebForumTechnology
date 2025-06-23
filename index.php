<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="Style/main.css">
  <link rel="stylesheet" href="Style/nav.css">
  <link rel="stylesheet" href="Style/header.css">
  <link rel="stylesheet" href="Style/user.css">
  <link rel="stylesheet" href="Style/user_infor.css">
  <title>Stack Overflow - Newest Questions</title>
</head>

<body>
  <header> <?php include 'Code/header.php'; ?> </header>
  <div class="container-wrapper">
    <nav class="navigate" style="width:20%;"> <?php include 'Code/nav.php'; ?> </nav>
    <div class="container" style="width:70%;">    
    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'main';
    $allowed_pages = ['main', 'user', 'user_infor', 'tag']; // an toàn tránh include linh tinh
    if (in_array($page, $allowed_pages)) {
      include "Code/{$page}.php";
    } else {
      echo "<p>Không tìm thấy nội dung.</p>";
    }
    ?></div>
  </div>




  <footer><?php include 'Code/footer.php'; ?></footer>

</body>

</html>
