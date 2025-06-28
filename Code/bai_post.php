<?php
include 'connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['User_ID'])) {
    header('Location: Code/signInUP.php');
    exit();
}

// Xử lý khi submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tag_id = $_POST['tag_id'];
    $user_id = $_SESSION['User_ID'];
    $created_at = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO posts (user_id, tag_id, title, content, created_at) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Lỗi prepare: " . $conn->error);
    }

    $stmt->bind_param("iisss", $user_id, $tag_id, $title, $content, $created_at);


    if ($stmt->execute()) {
        echo "<script>window.location.href = 'index.php?page=mainPost';</script>";
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
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #232629;
        }

        .container-wrapper {
            display: flex;
            justify-content: left;
        }

        .container {
            width: 95%;
            background: white;
            border-radius: 8px;
            padding-top: 1%;
        }

        .form-container {
            background: white;
            border-radius: 5px;
            padding: 24px;
            max-width: 800px;
        }

        .form-container h2 {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #242729;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 15px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbc0c4;
            border-radius: 3px;
            font-size: 14px;
            transition: border-color 0.15s ease-in-out;
            margin-bottom: 2%;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        textarea:focus,
        select:focus {
            border-color: #6cbbf7;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 149, 255, 0.15);
        }

        .file-input {
            margin-top: 8px;
        }

        .btn-submit {
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #0077cc;
        }

        .form-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e4e6e8;
            font-size: 13px;
            color: #6a737c;
        }

        @media (max-width: 768px) {
            .container-wrapper {
                padding: 10px;
            }

            .form-container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container-wrapper">
        <div class="container">
            <h2>Tạo bài viết mới</h2>
            <br>
            <?php if (isset($error)) echo '<div class="error">' . htmlspecialchars($error) . '</div>'; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết:</label>
                    <input type="text" id="title" name="title" required>
                </div>

                <div class="form-group">
                    <label for="content">Nội dung:</label>
                    <textarea id="content" name="content" required></textarea>
                </div>

                <div class="form-group">
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
                </div>

                <button type="submit" class="btn-submit">Đăng bài</button>
            </form>
            <div class="form-footer">
                <p style="font-size: large;">Các nội dung thảo luận cần văn minh và chính xác!</p>
            </div>
        </div>
    </div>
</body>

</html>