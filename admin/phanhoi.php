<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>binhluan</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
      background: white;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f5f5f5;
    }

    tr:hover {
      background-color: #f0f8ff;
    }

    select {
      padding: 5px;
    }

    .btn {
      text-decoration: none;
      padding: 4px 8px;
      border-radius: 4px;
      margin: 0 2px;
    }

    .sua {
      background-color: #4CAF50;
      color: white;
    }

    .xoa {
      background-color: #f44336;
      color: white;
    }
    .xem{
        background-color: #4868f5;
        color: white;
    }
    textarea {
        width: 100%;
        min-height: 60px;
        resize: vertical;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-family: Arial, sans-serif;
        font-size: 14px;
        box-sizing: border-box;
    }
    form {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    h1 {
        margin-bottom: 20px;
    }
    .select-hover select {

  pointer-events: none;
  position: relative;
}

.select-hover:hover select {

  pointer-events: auto;
}
  </style>
</head>
<body>
  <h1>Phản hồi</h1>
  <table>
    <thead>
      <tr>
        <th class="select-hover">
            <span class="hint">Lọc</span>
            <select>
                <option>Mới nhất</option>
                <option>Sửa gần nhất</option>
                <option>Đã duyệt</option>
            </select>
        </th>
        <th>Tiêu đề hỗ trợ</th>
        <th>Họ và tên</th>
        <th>Nội dung chi tiết</th>
        <th>Feedback</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Giả lập dữ liệu
      $baiviet = [
        ['Giới thiệu về NukeViet', '09:20 03/08/17','Nguyễn Thị Ngọc Trầm'],
        ['Giới thiệu về NukeViet CMS', '09:20 03/08/17','Đoàn Công Nguyên'],
        ['Logo và tên gọi NukeViet', '09:20 03/08/17','Phạm Hoàng Long'],
        ['Giấy phép sử dụng NukeViet', '09:20 03/08/17','Trần Trí Quý'],
        ['Những tính năng của NukeViet CMS 4.0', '09:20 03/08/17','Trần Băng Băng'],
        ['Yêu cầu sử dụng NukeViet 4', '09:20 03/08/17','Công Ngọc Hoàng'],
        ['Giới thiệu về Công ty cổ phần phát triển nguồn mở Việt Nam', '09:20 03/08/17','Ẩn danh'],
      ];

      foreach ($baiviet as $index => $bv) {
        echo "<tr>
                <td>{$bv[1]}</td>
                <td>{$bv[0]}</td>
                <td>{$bv[2]}</td>
                <td>{$bv[0]}</td>
                <td>
                  <form method='POST' action=''>
                    <textarea name='feedback' rows='2' cols='30' placeholder='Nhập phản hồi...'></textarea>
                    <button type='submit' class='btn sua'>Gửi</button>
                  </form>
                </td>
              </tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
