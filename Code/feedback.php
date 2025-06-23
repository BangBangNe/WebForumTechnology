<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Feedback - Hỗ trợ</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #f7f7f7;
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

    .file-box {
      border: 2px dashed #ccc;
      padding: 15px;
      text-align: center;
      margin-top: 10px;
      border-radius: 4px;
      background-color: white;
    }

    .file-box input {
      border: none;
    }

    .buttons {
      margin-top: 20px;
      text-align: center;
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
  </style>
</head>
<body>

  <h2>Tạo hỗ trợ</h2>

  <div class="form-group">
    <label>Email:</label>
    <input type="text" placeholder="Nhập Email của bạn...">
  </div>

  <div class="form-group">
    <label>Người dùng:</label>
    <input type="text" placeholder="Nhập tên của bạn...">
  </div>

  <div class="form-group">
    <label>Chủ đề trợ giúp*</label>
    <select required>
      <option>— Chọn một chủ đề trợ giúp —</option>
      <option>tronvuongtamgiacvuongtron</option>
      <option>tungtungtungtungsarhua</option>
      <option>Tralalerotralala</option>
      <option>boombadilococodilo</option>
      <option>sikibididopdopyesyes</option>
      <option>Khác...</option>
    </select>
  </div>

  <div class="form-group">
    <label>Tiêu đề hỗ trợ *</label>
    <input type="text" placeholder="Nhập tiêu đề yêu cầu...">
  </div>

  <div class="form-group">
    <label>Nội dung yêu cầu</label>
    <textarea placeholder="Vui lòng điền nội dung yêu cầu rõ ràng, chi tiết, tiếng Việt có dấu."></textarea>
  </div>

  <div class="file-box">
    <label>Nhập files tại đây hoặc chọn files</label>
    <input type="file" multiple>
  </div>

  <div class="buttons">
    <button class="btn-success">Gửi đi</button>
    <button class="btn-warning" type="reset">Làm mới</button>
    <button class="btn-danger">Hủy bỏ</button>
  </div>

</body>
</html>
