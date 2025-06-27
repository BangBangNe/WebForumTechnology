<?php
include 'connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['User_ID'])) {
    header('Location: signInUP.php');
    exit();
}

// Xử lý khi submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tag_id = $_POST['tag_id'];
    $user_id = $_SESSION['User_ID'];
    $created_at = date('Y-m-d H:i:s');
    $last_updated = date('Y-m-d H:i:s');
    $status = 1;

    $stmt = $conn->prepare("INSERT INTO posts (user_id, tag_id, title, content, created_at, last_updated, status) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Lỗi prepare: " . $conn->error);
    }

    $stmt->bind_param("iissssi", $user_id, $tag_id, $title, $content, $created_at, $last_updated, $status);


    if ($stmt->execute()) {
        header('Location: ../index.php');
        echo "Thêm bài viết thành công!";
    } else {
        echo "Lỗi khi thêm: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo bài viết</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

        .container {
            margin: 40px auto;
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            color: #555;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        .btn-submit {
            background-color: #1976d2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #1565c0;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #1976d2;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Tạo bài viết mới</h2>

        <?php if (isset($error)) echo '<div class="error">' . htmlspecialchars($error) . '</div>'; ?>

        <form method="POST" action="">
            <label for="title">Tiêu đề bài viết:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Nội dung:</label>
            <textarea id="content" name="content" required></textarea>

            <label for="tag_id">Chọn thẻ (Tag):</label>
            <select name="tag_id" id="tag_id" required>
                <option value="">-- Chọn tag --</option>
                <?php
                $result = $conn->query("SELECT * FROM tags");
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row['ID_tag'] . '">' . htmlspecialchars($row['Name']) . '</option>';
                }
                ?>
            </select>

            <button type="submit" class="btn-submit">Đăng bài</button>
        </form>

        <a href="../mainPost.php" class="back-link">&larr; Quay lại trang bài viết</a>
    </div>
</body>

</html>
