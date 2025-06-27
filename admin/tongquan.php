<?php include '../code/connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tổng quan</title>
  <style>
    .tunggtunggtunggsarhua {
      display: flex;
      gap: 20px;

    }

    .cot, .tron {
      flex: 1;
      background: #fff;
      padding: 15px;
      height: 400px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
    }
    h1{
      padding: 20px;
    }
  </style>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f0f4f8;
      margin: 0;

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
      font-size: 24px;
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
  <?php $tables = [
    'posts' => 'Bài viết',
    'users' => 'Thành viên',
    'feedback' => 'Phản hồi',
    'comments' => 'Bình luận',
    'tags' => 'Thẻ',
    'questions' => 'Câu hỏi'
];

$counts = [];
$sumLike = 0;

foreach ($tables as $table => $label) {
  $sql = "SELECT COUNT(*) AS total FROM $table";
  $result = $conn->query($sql);
  $counts[$label] = ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
}

$conn->close();
?>
    <h1>Tổng quan</h1>
    <div class="dashboard">
        <div class="box orange">
            <div class="number"><?= $counts['Bài viết'] ?? 0 ?></div>
            <div class="label">Số lượng Bài viết</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box green">
            <div class="number"><?= $counts['Thành viên'] ?? 0 ?></div>
            <div class="label">Danh sách người dùng</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box blue">
            <div class="number"><?= $counts['Phản hồi'] ?? 0 ?></div>
            <div class="label">Lượt phản hồi</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box red">
            <div class="number"><?= $counts['Bình luận'] ?? 0 ?></div>
            <div class="label">Lượt bình luận</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box purple">
            <div class="number"><?= $counts['Câu hỏi'] ?? 0 ?></div>
            <div class="label">Danh sách Câu hỏi</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
        <div class="box pink">
            <div class="number"><?= $counts['Thẻ'] ?? 0 ?></div>
            <div class="label">Thẻ tags</div>
            <div class="detail">Chi tiết ➜</div>
        </div>
    </div>
    <br>
    <br><br>
    <h1>Thống kê</h1>
<div class="tunggtunggtunggsarhua">
  <div class="cot"><canvas id="barChart" width="300" height="150"></canvas></div>
  <div class="tron"><canvas id="pieChart" width="300" height="300"></canvas></div>
</div><script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
