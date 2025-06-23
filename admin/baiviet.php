<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Bài viết</title>
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
  <h1>Danh sách bài viết</h1>
  <table>
    <thead>
      <tr>
        <th>Thứ tự</th>
        <th>Tiêu đề</th>
        <th>Thời gian đăng</th>
        <th>Cập nhật lần cuối</th>
        <th>Trạng thái</th>
        <th>Chức năng</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Giả lập dữ liệu
      $baiviet = [
        ['Giới thiệu về NukeViet', '09:20 03/08/17'],
        ['Giới thiệu về NukeViet CMS', '09:20 03/08/17'],
        ['Logo và tên gọi NukeViet', '09:20 03/08/17'],
        ['Giấy phép sử dụng NukeViet', '09:20 03/08/17'],
        ['Những tính năng của NukeViet CMS 4.0', '09:20 03/08/17'],
        ['Yêu cầu sử dụng NukeViet 4', '09:20 03/08/17'],
        ['Giới thiệu về Công ty cổ phần phát triển nguồn mở Việt Nam', '09:20 03/08/17'],
        ['Ủng hộ, hỗ trợ và tham gia phát triển NukeViet', '09:20 03/08/17'],
      ];

      foreach ($baiviet as $index => $bv) {
        echo "<tr>
                <td>" . ($index + 1) . "</td>
                <td>{$bv[0]}</td>
                <td>{$bv[1]}</td>
                <td>{$bv[1]}</td>
                <td>
                  <select>
                    <option>Hoạt động</option>
                    <option>Tạm ẩn</option>
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
