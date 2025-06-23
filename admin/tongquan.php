<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tổng quan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      margin: 0;

    }

    h1 {
      margin-bottom: 20px;
    }

    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .box {
      background-color: #fff;
      color: white;
      padding: 20px;
      border-radius: 8px;
      position: relative;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .box.orange { background-color: #f39c12; }
    .box.green { background-color: #27ae60; }
    .box.blue { background-color: #00c0ef; }
    .box.red { background-color: #d9534f; }
    .box.purple { background-color: #605ca8; }
    .box.pink { background-color: #d81b60; }
    .box.fuchsia { background-color: #f012be; }
    .box.teal { background-color: #00a65a; }

    .box .number {
      font-size: 52px;
      font-weight: bold;
    }

    .box .label {
      margin-top: 5px;
      margin-bottom: 5px;
      font-size: 14px;
    }

    .box .detail {
      bottom: 10px;
      left: 20px;
      font-size: 13px;
      color: white;
      opacity: 0.9;
    }
  </style>
</head>
<body>
    <h1>Tổng quan</h1>
    <div class="dashboard">
        <div class="box orange">
            <div class="number">0</div>
            <div class="label">Sản phẩm</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box green">
            <div class="number">0</div>
            <div class="label">Danh mục sản phẩm</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box blue">
            <div class="number">0</div>
            <div class="label">Bài viết</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box red">
            <div class="number">0</div>
            <div class="label">Danh mục bài viết</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box purple">
            <div class="number">0</div>
            <div class="label">Danh sách liên hệ</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box pink">
            <div class="number">0</div>
            <div class="label">Thành viên</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box fuchsia">
            <div class="number">0</div>
            <div class="label">Kiểm duyệt</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box teal">
            <div class="number">0</div>
            <div class="label">Bình luận</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
    </div>
</body>
</html>
