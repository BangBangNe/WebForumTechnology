<?php include 'connect.php';
    
// Lấy câu hỏi
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>Không tìm thấy bài viết.</h2>";
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT q.ID_Ques, q.Mo_ta, q.Hinh_anh, t.Name AS tag_name, u.User_name
        FROM questions q
        JOIN tags t ON q.ID_Tags = t.ID_tag
        JOIN users u ON q.ID_user = u.User_ID
        WHERE q.ID_Ques = $id";

$result = $conn->query($sql);


$ques = mysqli_fetch_assoc($result);


// Lấy bình luận của câu hỏi
$link = "SELECT c.Comment, u.User_name, u.avatar
        FROM comments c
        JOIN users u ON c.ID_User = u.User_ID
        WHERE c.ID_Ques = $id";

$comments = mysqli_query($conn, $link);


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
                echo '<h1>' . htmlspecialchars($ques['Mo_ta']) . '</h1>';
                echo '<div class="meta">Người đăng: <strong>' . htmlspecialchars($ques['User_name']) . '</strong></div>';

                if (!empty($ques['Hinh_anh'])) {
                    echo '<img class="image" src="' . htmlspecialchars($ques['Hinh_anh']) . '" alt="Hình ảnh bài viết">';
                }

                echo '<div class="tag">#' . htmlspecialchars($ques['tag_name']) . '</div>';
            } else {
                echo "<h2>Không tìm thấy bài viết.</h2>";
            }
            ?>
                            </br></br></br></br></br>
            <div class="comment_section">
                <div class="comment_input">
                    <img src="<?= $user['avatar'] ?? 'test.jpg' ?>" alt="" class="comment_avata">
                    <textarea name="comment" class="comment_input_box" data-ques-id="<?= $ques['ID_Ques'] ?>" placeholder="Viết bình luận ....."></textarea>
                </div>
                <div class="comment_list">
                    <?php if (empty($comments)): ?>
                        <p>Chưa có bình luận nào.</p>
                    <?php else: ?>
                        <?php foreach ($comments as $c): ?>
                            <div class="comment_item">
                                <img src="<?= $c['avatar'] ?? 'test.jpg' ?>" alt="" class="comment_avata">
                                <div class="comment_content">
                                    <div class="comment_user"><?= htmlspecialchars($c['User_name']) ?></div>
                                    <div class="comment_text"><?= htmlspecialchars($c['Comment']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <a class="back-link" href="index.php">← Quay về danh sách</a>
        </div>

    </div>

</body>

</html>