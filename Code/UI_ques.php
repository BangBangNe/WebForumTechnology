<?php
include 'db_connect.php';

$you_id = $temp ?? null; // ID người bạn muốn nhắn tin, nếu không có thì sẽ lấy ID của người đang đăng nhập
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
$question_result = mysqli_query($link, "SELECT * FROM questions WHERE ID_user = $you_id ORDER BY Date_tao DESC");
$questions = [];
while ($row = mysqli_fetch_assoc($question_result)) {
    $questions[] = $row;
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
    <?php if (!empty($questions)): ?>
        <?php foreach ($questions as $question): ?>
            <?php
            // Lấy comment riêng cho mỗi bài
            $q_id = $question['ID_Ques'];
            $cmt_result = mysqli_query($link, "
                                SELECT c.Comment, u.User_name, u.avatar
                                FROM comments c
                                JOIN users u ON c.ID_User = u.User_ID
                                WHERE c.ID_Ques = $q_id
                            ");
            //Lấy số lượng like
            $like_result = mysqli_query($link, "SELECT like_count FROM questions WHERE ID_Ques = $q_id");
            $like_data = mysqli_fetch_assoc($like_result);
            $like_count = $like_data['like_count'] ?? 0;
            // Kiểm tra người dùng đã like bài viết chưa
            $hasLiked = false;
            if (isset($user['User_ID'])) {
                $userId = $user['User_ID'];
                $likeCheckQuery = mysqli_query($link, "
                                    SELECT 1 FROM question_likes 
                                    WHERE user_id = $userId AND question_id = $q_id
                                    LIMIT 1
                                ");

                if (!$likeCheckQuery) {
                    // Ghi log lỗi hoặc hiển thị ra để debug
                    echo "<p style='color:red;'>Lỗi truy vấn LIKE: " . mysqli_error($link) . "</p>";
                } else {
                    $hasLiked = mysqli_num_rows($likeCheckQuery) > 0;
                }
            }
            $comments = [];
            while ($row = mysqli_fetch_assoc($cmt_result)) {
                $comments[] = $row;
            }
            ?>
            <div class="container_post">
                <div class="post_header">
                    <img src="<?php echo $user['avatar'] ?? '../WebForumTechnology/uploads/icon/avatar_md.jpg' ?>" alt="Ảnh">
                    <div class="post_user_infor">
                        <h3><?= $user['User_name'] ?></h3>
                        <p><?= $question['Date_tao'] ?? 'Không rõ ngày' ?> . <i class="fas fa-globe-asia"></i></p>
                    </div>
                </div>

                <div class="post_content">
                    <div class="post_text">
                        <h2><?= $question['Mo_ta'] ?? 'Không có nội dung câu hỏi' ?></h2>
                        <p><?= $question['content'] ?? 'Không có nội dung câu hỏi' ?></p>
                    </div>
                    <div class="post_pic">
                        <img src="<?= $question['Hinh_anh'] ?? null ?>">
                    </div>

                </div>

                <div class="post_actions">
                    <div class="frame">
                        <div style="display: flex; gap: 2%; width: 50%; color: #555;">
                            <div class="likes_count"> <?= $like_count ?> </div>
                            <div style="align-content: center;"> lượt thích</div>
                        </div>

                        <div class="action_btn like_btn <?= $hasLiked ? 'active' : '' ?>"
                            onclick="toggleLike(this, <?= $question['ID_Ques'] ?>)">
                            <i class="<?= $hasLiked ? 'fas' : 'far' ?> fa-thumbs-up"></i>
                            <span><?= $hasLiked ? 'Đã thích' : 'Thích' ?></span>
                        </div>
                    </div>


                    <div class="frame">
                        <div style="display: flex; gap: 2%; width: 50%; color: #555;">
                            <div class="comments_count"><?= isset($comments) ? count($comments) : 0 ?> </div>
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
                            <textarea name="comment" class="comment_input_box" data-ques-id="<?= $question['ID_Ques'] ?>" placeholder="Viết bình luận ....."></textarea>
                        <?php };
                        ?>
                    </div>

                    <div class="comment_list">
                        <?php if (empty($comments)): ?>
                            <p>Chưa có bình luận nào.</p>
                        <?php else: ?>
                            <?php foreach ($comments as $c): ?>
                                <div class="comment_item">
                                    <img src="<?php echo $c['avatar'] ?? '../WebForumTechnology/icon/test.jpg' ?>" alt="Ảnh">
                                    <div class="comment_content">
                                        <div class="comment_user"><?= htmlspecialchars($c['User_name']) ?></div>
                                        <div class="comment_text"><?= htmlspecialchars($c['Comment']) ?></div>
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
    </div>

    <script src="Javascript/user_infor.js"></script>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
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