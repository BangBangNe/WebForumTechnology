<?php 
$conn = mysqli_connect("localhost", "root", "", "datadiendan");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$sql = "SELECT * FROM questions";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách câu hỏi</title>
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
        .btn {
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 4px;
            margin: 0 2px;
            display: inline-block;
        }
        .sua { background-color: #4CAF50; color: white; }
        .xoa { background-color: #f44336; color: white; }
        .them { background-color: #2196F3; color: white; }
        h1 { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>Danh sách câu hỏi</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nội dung</th>
                <th>Ngày tạo</th>
                <th>Lượt like</th>
                <th>Tuỳ chỉnh</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['ID_Ques'] ?></td>
                        <td><?= htmlspecialchars($row['Mo_ta']) ?></td>
                        <td><?= $row['Date_tao'] ?></td>
                        <td><?= $row['like_count'] ?></td>
                        <td>
                            <a href="delete_ques.php?id=<?= $row['ID_Ques'] ?>" class="btn xoa" onclick="return confirm('Bạn có chắc muốn xoá?')">Xoá</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">Không có bài viết nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php mysqli_close($conn); ?>