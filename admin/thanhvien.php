<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Thành viên</title>
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
      margin: 0 2px;
    }

    h1 {
      margin-bottom: 20px;
    }
    .avatar {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 50%;
      border: 1px solid #ddd;
    }
  </style>

</head>
<body>
  <h1>Thành viên</h1>
  <table>
    <thead>
      <tr>
        <th>Avata</th>
        <th>Tên thành viên</th>
        <th>Ngày sinh</th>
        <th>Trạng thái</th>
        <th>Trang cá nhân</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $baiviet = [
        ['Mika.png', '03/08/17', 'Nguyễn Thị Ngọc Trầm'],
        ['Hikari.png', '03/08/17', 'Đoàn Công Nguyên'],
        ['Ibuki.png',  '03/08/17', 'Phạm Hoàng Long'],
        ['Iroha.png',  '03/08/17', 'Trần Trí Quý'],
        ['Rio.png',    '03/08/17', 'Trần Băng Băng'],
        ['Seia.png',   '03/08/17', 'Công Ngọc Hoàng'],
        ['Wakamo.png',  '03/08/17', 'Ẩn danh'],
        ['Nozomi.png','03/08/17', 'Ẩn Danh'],
      ];

      foreach ($baiviet as $bv) {
        echo "<tr>
                <td><img src='Anh/{$bv[0]}' alt='avatar' class='avatar'></td>
                <td>{$bv[2]}</td>
                <td>{$bv[1]}</td>
                <td>
                  <select>
                    <option>...</option>
                    <option>cấm chat</option>
                    <option>cấm đăng bài</option>
                    <option>cấm cả hai</option>
                  </select>
                  <select>
                    <option>...</option>
                    <option>24 giờ</option>
                    <option>1 tuần</option>
                    <option>30 ngày</option>
                    <option>vĩnh viễn</option>
                  </select>
                </td>
                <td>
                  <a href='#' class='btn'>Xem</a>
                </td>
              </tr>";
      }
      ?>
    </tbody>
  </table>
</body>
</html>
