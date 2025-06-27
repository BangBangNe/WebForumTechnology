<?php
// Kết nối CSDL
$conn = mysqli_connect("localhost", "root", "", "datadiendan");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$sql = "SELECT User_ID, user_name, location, avatar FROM users";
$result = mysqli_query($conn, $sql);
?>

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

    th.ID{
      width: 5%;
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
      border-radius: 4px;
      font-size: 14px;
    }

    .sua {
      background-color: #4CAF50;
      color: white;
    }

    .xoa {
      background-color: #f44336;
      color: white;
    }

    h1 {
      margin-bottom: 20px;
      text-align: center;
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
  <h1>Quản lý thành viên</h1>
  <table>
    <thead>
      <tr>
        <th class = "ID">ID thành viên</th> 
        <th>Avatar</th>
        <th>Tên thành viên</th>
        <th>Địa điểm</th>
        <th>Tuỳ chỉnh</th>
      </tr>
    </thead>
    <tbody>
      <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?= $row['User_ID'] ?></td> 
            <td>
              <img src="Anh/<?= $row['avatar'] ? $row['avatar'] : 'default.png' ?>" alt="avatar" class="avatar">
            </td>
            <td><?= htmlspecialchars($row['user_name']) ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td>
              <a href="delete_user.php?id=<?= $row['User_ID'] ?>" class="btn xoa" onclick="return confirm('Bạn có chắc muốn xóa thành viên này không?')">Xóa tài khoản</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6">Không có thành viên nào.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>

<?php mysqli_close($conn); ?>
