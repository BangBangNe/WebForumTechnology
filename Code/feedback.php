<?php include 'connect.php' ?>
<?php
if ($_SESSION['User_ID'] == null) {
  header("Location:Code/signinUP.php ");
  exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Feedback</title>
  <style>
    .feed{
      padding: 5%;
    }
    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 6px;
    }

    input[type="text"],
    input[type="email"],
    select,
    textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    textarea {
      height: 120px;
    }

    .readonly-field {
      background-color: #eee;
    }


    .buttons button {
      padding: 10px 16px;
      border: none;
      border-radius: 4px;
      margin-right: 10px;
      font-weight: bold;
      cursor: pointer;
    }

    .btn-success {
      background-color: #4CAF50;
      color: white;
    }

    .btn-warning {
      background-color: #f0ad4e;
      color: white;
    }

    .btn-danger {
      background-color: #d9534f;
      color: white;
    }

    h2 {
      border-bottom: 2px solid #ccc;
      padding-bottom: 10px;
      margin-bottom: 30px;
    }

    .name {
      border: 1px solid gray;
      border-radius: 5px;
      padding: 7px;
    }
  </style>
</head>

<body>
  <div class="feed">

    <h2>Tạo phản hồi</h2>
    <form method="post" action="Code/add_feedback.php"> <!-- gửi qua file PHP -->
      <div class="form-group">
        <label>Người dùng:</label>
        <div class="name">
          <span class="user-info"><?php echo htmlspecialchars($_SESSION['User_name']); ?></span>
        </div>
      </div>

      <div class="form-group">
        <label>Tiêu đề hỗ trợ *</label>
        <input type="text" name="title" placeholder="Nhập tiêu đề yêu cầu..." required>
      </div>

      <div class="form-group">
        <label>Nội dung yêu cầu</label>
        <textarea name="content" placeholder="Vui lòng điền nội dung yêu cầu rõ ràng, chi tiết, tiếng Việt có dấu." required></textarea>
      </div>

      <div class="buttons">
        <button class="btn-success" type="submit">Gửi đi</button>
        <button class="btn-warning" type="reset">Làm mới</a></button>
      </div>
    </form>
  </div>

</body>

</html>