<?php include 'connect.php';
    
// Lấy câu hỏi
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>Không tìm thấy bài viết.</h2>";
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT q.Mo_ta, q.Hinh_anh, t.Name AS tag_name, u.User_name
        FROM questions q
        JOIN tags t ON q.ID_Tags = t.ID_tag
        JOIN users u ON q.ID_user = u.User_ID
        WHERE q.ID_Ques = $id";

$result = $conn->query($sql);

// Lấy bình luận của câu hỏi
$comments = [];
if ($question) {
    $ques_id = $question['ID_Ques'];
    $cmt_result = mysqli_query($link, "
        SELECT c.Comment, u.User_name, u.avatar
        FROM comments c
        JOIN users u ON c.ID_User = u.User_ID
        WHERE c.ID_Ques = $ques_id
    ");
    while ($row = mysqli_fetch_assoc($cmt_result)) {
        $comments[] = $row;
    }
}


?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết bài viết</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
        }

        h1 {
            color: #333;
        }

        .meta {
            color: #777;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .tag {
            background-color: #e0f0ff;
            padding: 5px 10px;
            border-radius: 4px;
            color: #0077cc;
            font-size: 14px;
            display: inline-block;
            margin-top: 10px;
        }

        .image {
            max-width: 100%;
            margin: 20px 0;
            border-radius: 6px;
        }

        a.back-link {
            display: inline-block;
            margin-top: 30px;
            text-decoration: none;
            color: #0077cc;
        }

        a.back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container-wrapper">
        <div class="post-container">
            <?php
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo '<h1>' . htmlspecialchars($row['Mo_ta']) . '</h1>';
                echo '<div class="meta">Người đăng: <strong>' . htmlspecialchars($row['User_name']) . '</strong></div>';

                if (!empty($row['Hinh_anh'])) {
                    echo '<img class="image" src="' . htmlspecialchars($row['Hinh_anh']) . '" alt="Hình ảnh bài viết">';
                }

                echo '<div class="tag">#' . htmlspecialchars($row['tag_name']) . '</div>';
            } else {
                echo "<h2>Không tìm thấy bài viết.</h2>";
            }

            $conn->close();
            ?>
            <a class="back-link" href="index.php">← Quay về danh sách</a>
        </div>

    </div>

</body>

</html>