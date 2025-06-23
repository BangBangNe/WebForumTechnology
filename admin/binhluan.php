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
    h1 {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <h1>Bình luận</h1>
  <table>
    <thead>
      <tr>
        <th>Thời gian đăng</th>
        <th>Nội dung</th>
        <th>Tên thành viên</th>
        <th>Trạng thái</th>
        <th>Tùy chỉnh</th>
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
        ['Ủng hộ, hỗ trợ và tham gia phát triển NukeViet', '09:20 03/08/17','Ẩn Danh'],
      ];

      foreach ($baiviet as $index => $bv) {
        echo "<tr>
                <td>{$bv[1]}</td>
                <td>{$bv[0]}</td>
                <td>{$bv[2]}</td>
                <td>
                  <select>
                    <option>Chưa được duyệt</option>
                    <option>Đã duyệt</option>
                  </select>
                </td>
                <td>
                  <a href='#' class='btn sua'>Sửa</a>
                  <a href='#' class='btn xoa'>Xóa</a>
                  <a href='#' class='btn xem'>Xem</a>
                </td>
              </tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
