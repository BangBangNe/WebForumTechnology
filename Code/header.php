<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Header</title>
  <link rel="stylesheet" href="../style/header.css">
</head>
<body>
    <header>
        <div class="all">
          <div class="trai">
            <a href="">StackOverflow</a>
            <ol>
              <li><a href="">about</a></li>
              <li><a href="">product</a></li>
              <li><a href="">contact</a></li>
            </ol>
          </div>
      
          <div class="giua">
            <form><input type="text" placeholder="Tìm kiếm..." /></form>
          </div>
      
            <div class="phai">
                <button class="login-btn" onclick="window.location.href='index.php?action=logout';">Đăng Nhập</button>
                <button class="login-btn" onclick="window.location.href='signinUp.php';">Đăng Ký</button>   
                <button class="chuong-thong-bao"><img src="icon/bell.png" alt=""></button>
            </div>
        </div>
    </header>
      
</body>
</html>
