<?php
include 'connect.php';
session_start(); // Bắt đầu phiên làm việc
// Lấy bài viết
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>Không tìm thấy bài viết.</h2>";
    exit;
}

$id = intval($_GET['id']);

$sql = "SELECT p.title, p.content, p.post_id, t.Name AS tag_name, u.User_name
        FROM posts p
        JOIN tags t ON p.tag_id = t.ID_tag
        JOIN users u ON p.user_id = u.User_ID
        WHERE p.post_id = $id";

$result = $conn->query($sql);

// Lấy post
$post = mysqli_fetch_assoc($result);


// Lấy bình luận của bài viết
$link = "SELECT c.content, u.User_name, u.avatar
            FROM post_comments c
            JOIN users u ON c.user_id = u.User_ID
            WHERE c.post_id = $id";

$comments = mysqli_query($conn, $link);

$user_id = $_SESSION['User_ID'] ; 
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE User_ID = $user_id");
$user = mysqli_fetch_assoc($user_result);

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
        <?php echo $post['post_id'] ?>
        <div class="post-container">
            <?php
            if ($result && $result->num_rows > 0) {

                echo '<h1>' . htmlspecialchars($post['title']) . '</h1>';
                echo '<div class="meta">Người đăng: <strong>' . htmlspecialchars($post['User_name']) . '</strong></div>';

                if (!empty($post['content'])) {
                    echo '<div>' . htmlspecialchars($post['content']) . '</div>';
                }

                echo '<div class="tag">#' . htmlspecialchars($post['tag_name']) . '</div>';
            } else {
                echo "<h2>Không tìm thấy bài viết.</h2>";
            }

            ?>
            </br></br></br></br></br>
            <div class="comment_section">
                <div class="comment_input">
                     <img src="<?php echo $user['avatar'] ?? '../WebForumTechnology/icon/test.jpg' ?>" alt="Ảnh" class="comment_avata">
                    <textarea name="comment" class="comment_input_box" data-post-id="<?= $post['post_id'] ?>" placeholder="Viết bình luận ....."></textarea>
                    <button class="send_comment_btn">Gửi bình luận</button>
                </div>
                <div class="comment_list">
                    <?php if (empty($comments)): ?>
                        <p>Chưa có bình luận nào.</p>
                    <?php else: ?>
                        <?php foreach ($comments as $c): ?>
                            <div class="comment_item">
                                <img src="<?php echo htmlspecialchars($c['avatar'] ?? '../WebForumTechnology/icon/test.jpg'); ?>" alt="Ảnh" class="comment_avata">
                                <div class="comment_content">
                                    <div class="comment_user"><?= htmlspecialchars($c['User_name']) ?></div>
                                    <div class="comment_text"><?= htmlspecialchars($c['content']) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>


        </div>
    </div>
    <script>
        document.querySelector('.send_comment_btn').addEventListener('click', function() {
            const textarea = document.querySelector('.comment_input_box');
            const comment = textarea.value.trim();
            const postId = textarea.dataset.postId;

            if (!comment) return;

            const formData = new FormData();
            formData.append('comment', comment);
            formData.append('post_id', postId);

            fetch('Code/xuly_post.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === 'LOGIN_REQUIRED') {
                        // ✅ Tự động nhảy sang trang đăng nhập
                        window.location.href = 'Code/signInUP.php';
                        return;
                    }

                    // Nếu login rồi thì xử lý bình luận
                    const commentList = document.querySelector('.comment_list');
                    commentList.insertAdjacentHTML('beforeend', data);
                    textarea.value = '';
                })
                .catch(err => {
                    console.error("Lỗi gửi bình luận:", err);
                });
        });
    </script>

</body>

</html>