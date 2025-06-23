<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>thongke</title>
  <style>
    .tunggtunggtunggsarhua {
      display: flex;
      gap: 20px;
      padding: 20px;
    }

    .cot, .tron {
      flex: 1;
      background: #fff;
      padding: 15px;
      height: 400px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      border-radius: 8px;
    }
  </style>
</head>
<body>
<h1>Thống kê</h1>
<div class="tunggtunggtunggsarhua">
  <div class="cot"><canvas id="barChart" width="300" height="150"></canvas></div>
  <div class="tron"><canvas id="pieChart" width="300" height="300"></canvas></div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
