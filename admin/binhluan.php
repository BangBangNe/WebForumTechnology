<?php
// Kết nối cơ sở dữ liệu
$conn = mysqli_connect("localhost", "root", "", "datadiendan");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

// Truy vấn lấy dữ liệu với JOIN 3 bảng
$sql = "SELECT c.ID_Comment, c.Comment, u.User_name, q.Mo_ta
        FROM comments c
        JOIN users u ON c.ID_User = u.User_ID
        JOIN questions q ON c.ID_Ques = q.ID_Ques
        ORDER BY c.ID_Comment DESC";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bình luận</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        h1 {
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:hover {
            background-color: #f0f8ff;
        }
        .btn {
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 4px;
            margin: 0 2px;
            display: inline-block;
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
        .them {
            background-color: #2196F3;
            color: white;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Danh sách bình luận</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nội dung bình luận</th>
                <th>Người bình luận</th>
                <th>Câu hỏi liên quan</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['ID_Comment'] ?></td>
                        <td><?= htmlspecialchars($row['Comment']) ?></td>
                        <td><?= htmlspecialchars($row['User_name']) ?></td>
                        <td><?= htmlspecialchars($row['Mo_ta']) ?></td>
                        <td>
                            <a href="delete_comment.php?id=<?= $row['ID_Comment'] ?>" class="btn xoa" onclick="return confirm('Bạn có chắc muốn xoá bình luận này?')">Xoá</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Không có bình luận nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>

<?php mysqli_close($conn); ?>