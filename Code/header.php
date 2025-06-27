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
        <button class="chuong-thong-bao"><img src="../uploads/icon/bell.png" alt=""></button>

      </div>
    </div>
  </header>

</body>

</html>