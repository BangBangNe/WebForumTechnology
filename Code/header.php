<?php
include 'db_connect.php';

if (isset($_SESSION['User_ID'])) {
  $user_id = $_SESSION['User_ID'];
  $user2_result = mysqli_query($link, "SELECT * FROM users WHERE User_ID = $user_id");
  $user2 = mysqli_fetch_assoc($user2_result);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Header</title>
  <link rel="stylesheet" href="../Style/header.css">
</head>

<body>
  <header>
    <div class="all">
      <div class="trai">
        <h2 Style="border: none; padding: 0 30px; margin: 0;">ForumTechnology</h2>
        <ol>
          <li><a href="index.php?page=feedback">Báo cáo</a></li>
          <li><a href="index.php?page=main#footer">Liên hệ</a></li>
        </ol>
      </div>


      <div class="phai">
        <?php

        // Trong phần giao diện:
        if (isset($_SESSION['User_ID'])) {
          echo '<span class="user-info">Xin chào, ' . htmlspecialchars($_SESSION['User_name']) . '</span>';
          echo '<button class="login-btn" onclick="window.location.href=\'index.php?action=logout\';">Đăng Xuất</button>';
        } else {
          echo '<button class="login-btn" onclick="window.location.href=\'Code/signinUP.php\';">Đăng Nhập</button>';
        }
        ?>
        <div class="chuong-thong-bao"><img src="<?php echo $user2['avatar'] ?? '../WebForumTechnology/uploads/icon/avatar_md.jpg'  ?>" alt="anh"></div>

      </div>
    </div>
  </header>

</body>

</html>