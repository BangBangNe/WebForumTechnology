<?php
include 'db_connect.php';


$you_id = $_GET['user_id'] ?? $_SESSION['User_ID']; // ID người bạn muốn nhắn tin, nếu không có thì sẽ lấy ID của người đang đăng nhập
$user_id = $_SESSION['User_ID'] ?? $you_id; // Người đang đăng nhập

$flag = false;
if (!isset($_SESSION['User_ID'])) {
    $flag = true;
}
$user_result = mysqli_query($link, "SELECT * FROM users WHERE User_ID = $you_id");
$user = mysqli_fetch_assoc($user_result);

$user2_result = mysqli_query($link, "SELECT * FROM users WHERE User_ID = $user_id");
$user2 = mysqli_fetch_assoc($user2_result);

// Lấy toàn bộ đoạn chat giữa $user_id và $you_id
$conv_result = mysqli_query($link, "
    SELECT id FROM conversations 
    WHERE (user1_id = $user_id AND user2_id = $you_id)
       OR (user1_id = $you_id AND user2_id = $user_id)
    LIMIT 1
");
$conversation = mysqli_fetch_assoc($conv_result);

$chat_messages = [];
if ($conversation) {
    $conv_id = $conversation['id'];
    $chat_result = mysqli_query($link, "
        SELECT * FROM messages 
        WHERE conversation_id = $conv_id 
        ORDER BY created_at ASC
    ") or die("Lỗi truy vấn chat: " . mysqli_error($link));

    while ($row = mysqli_fetch_assoc($chat_result)) {
        $chat_messages[] = $row;
    }
}


// Lấy câu hỏi và bài viết mới nhất của user
$posts_result = mysqli_query($link, "SELECT * FROM posts WHERE user_id = $you_id ORDER BY created_at DESC");
$posts = [];
if ($posts_result === false) {
    die("Lỗi truy vấn bài viết: " . mysqli_error($link));
}
while ($row = mysqli_fetch_assoc($posts_result)) {
    $posts[] = $row;
}

// Lấy số lượng người theo dõi
$follower_count = mysqli_query($link, "SELECT COUNT(*) as count FROM followers WHERE followed_id = $you_id");
$follower_count = mysqli_fetch_assoc($follower_count)['count'];

// Kiểm tra xem người dùng đã theo dõi chưaus
$is_following = mysqli_query($link, "SELECT * FROM followers WHERE follower_id = $user_id AND followed_id = $you_id");
$is_following = mysqli_num_rows($is_following) > 0;




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <link rel="stylesheet" href="../Style/user_infor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

    <!-- Bài viết -->
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <?php
            // Lấy comment riêng cho mỗi bài
            $p_id = $post['post_id'];
            $pc_result = mysqli_query($link, "
                            SELECT c.content, u.User_name, u.avatar
                            FROM post_comments c
                            JOIN users u ON c.user_id = u.User_ID
                            WHERE c.post_id = $p_id
                            ORDER BY c.created_at ASC
                        ");
            $comments = [];
            while ($row = mysqli_fetch_assoc($pc_result)) {
                $comments[] = $row;
            }
            $comment_count_result = mysqli_query($link, "SELECT COUNT(*) AS total_comments FROM post_comments WHERE post_id = $p_id");
            $comment_count = mysqli_fetch_assoc($comment_count_result)['total_comments'] ?? 0;
            ?>
            <div class="container_post">
                <div class="post_header">
                    <img src="<?php echo $user['avatar'] ?>" alt="Ảnh">


                    <div class="post_user_infor">
                        <h3><?= $user['User_name'] ?></h3>
                        <p><?= $post['created_at'] ?? 'Không rõ ngày' ?> . <i class="fas fa-globe-asia"></i></p>
                    </div>
                </div>

                <div class="post_content">
                    <div class="post_text">
                        <h2><?= $post['title'] ?? 'Không có nội dung câu hỏi' ?></h2>
                        <p><?= $post['content'] ?? 'Không có nội dung câu hỏi' ?></p>
                    </div>

                </div>

                <div class="post_actions">
                    <div class="frame">
                        <div style="display: flex; gap: 2%; width: 50%; color: #555;">
                            <div class="comments_count" id="commentCount_<?= $post['post_id'] ?>">
                                <?= isset($comments) ? count($comments) : 0 ?>
                            </div>
                            <div style="align-content: center;"> lượt bình luận</div>
                        </div>

                        <div class="action_btn comment-btn" onclick="focusComment()">
                            <i class="far fa-comment"></i>
                            <span>Bình luận</span>
                        </div>
                    </div>

                </div>

                <div class="comment_section">
                    <div class="comment_input">
                        <?php
                        if ($flag) { ?>
                            <img src="../WebForumTechnology/uploads/icon/avatar_md.jpg" alt="Ảnh">
                            <div name="comment" class="comment_input_box">Cần đăng nhập để bình luận</div>
                        <?php } else { ?>
                            <img src="<?php echo $user2['avatar'] ?>" alt="Ảnh">
                            <textarea name="comment" class="comment_input_box" data-ques-id="<?= $post['post_id'] ?>" placeholder="Viết bình luận ....."></textarea>
                        <?php };
                        ?>
                        
                        <button class="send_comment_btn">Gửi bình luận</button>
                    </div>

                    <div class="comment_list">
                        <?php if (empty($comments)): ?>
                            <p>Chưa có bình luận nào.</p>
                        <?php else: ?>
                            <?php foreach ($comments as $c): ?>
                                <div class="comment_item">
                                    <img src="<?php echo $user['avatar'] ?? '../WebForumTechnology/icon/test.jpg' ?>" alt="Ảnh">
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
            <br><br><br>
        <?php endforeach; ?>

    <?php endif; ?>

    </div>

    <div class="end"><br></div>

    <!-- <script src="Javascript/user_infor.js"></script> -->


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        document.querySelectorAll('.send_comment_btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const commentSection = btn.closest('.comment_section');
                const textarea = commentSection.querySelector('.comment_input_box');
                const comment = textarea.value.trim();
                const postId = textarea.dataset.quesId; // Bạn đang dùng data-ques-id, không phải data-post-id

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
                            window.location.href = 'Code/signInUP.php';
                            return;
                        }

                        const commentList = commentSection.querySelector('.comment_list');
                        commentList.insertAdjacentHTML('beforeend', data);
                        textarea.value = '';
                        const countEl = document.getElementById(`commentCount_${postId}`);
                        if (countEl) {
                            const current = parseInt(countEl.textContent) || 0;
                            countEl.textContent = current + 1;
                        }
                    })
                    .catch(err => {
                        console.error("Lỗi gửi bình luận:", err);
                    });
            });
        });
    </script>
    <script>
        // Chờ DOM tải xong
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy nút follow
            const followBtn = document.getElementById('followBtn');

            // Thêm sự kiện click
            followBtn.addEventListener('click', function() {
                // Lấy ID từ PHP (cần thêm vào HTML)
                const userId = <?= $user_id ?? 0 ?>;
                const followedId = <?= $you_id ?? 0 ?>;
                console.log('User ID:', userId, 'Followed ID:', followedId);

                // Hiển thị trạng thái loading
                followBtn.disabled = true;
                const originalText = followBtn.textContent;
                followBtn.textContent = '...';

                // Gửi request đến server
                fetch('Code/follow_action.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `user_id=${userId}&followed_id=${followedId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật text nút
                            followBtn.textContent = data.is_following ? 'Đang theo dõi' : 'Theo dõi';

                            // Cập nhật số lượng
                            document.getElementById('followerCount').textContent = data.follower_count;
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra');
                    })
                    .finally(() => {
                        followBtn.disabled = false;
                    });
            });
        });
    </script>

</body>

</html>