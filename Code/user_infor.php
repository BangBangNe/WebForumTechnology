<?php
include 'db_connect.php';


$you_id=$_GET['user_id'] ?? null; // ID người bạn muốn nhắn tin, nếu không có thì sẽ lấy ID của người đang đăng nhập
$user_id=$_SESSION['User_ID']?? $you_id; // Người đang đăng nhập



if($you_id == null ) {
    $you_id=$user_id; // Nếu không có ID người bạn muốn nhắn tin, thì lấy ID của người đang đăng nhập
}
$user_result = mysqli_query($link, "SELECT * FROM users WHERE User_ID = $user_id");
$user = mysqli_fetch_assoc($user_result);

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

// Kiểm tra xem người dùng đã theo dõi chưa
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
    <div class="infor">
        <div class="container">
            <div class="container_infor">
                <div class="container_up">

                    <div class="container_avata">
                        <img src="<?php echo $user['avatar'] ?? '../WebForumTechnology/icon/test.jpg' ?>" alt="Ảnh">
                        <?php if ($you_id == $user_id): ?>
                            <form id="avatarForm" action="Code/xuly_anh.php" method="POST" enctype="multipart/form-data" style="margin-top: 10px;">
                                <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;" onchange="document.getElementById('avatarForm').submit();">
                                <button type="button" onclick="document.getElementById('avatarInput').click();">Đổi ảnh đại diện</button>
                            </form>
                        <?php endif; ?>
                        <!-- Theo doi -->
                        <div class="count" style="text-align: left;">
                            <div class="num" id="followerCount"><?= $follower_count ?? 0 ?></div>
                            <div class="text">nguời theo dõi</div>
                        </div>
                        <?php if ($you_id != $user_id): ?>
                            <div class="button" id="followBtn"><?= $is_following ? 'Đang theo dõi' : 'Theo dõi' ?></div>
                        <?php endif;?>

                        <!-- Chat -->
                        <?php if ($you_id != $user_id): ?>>
                            <div class="container_chat">Nhắn tin</div>
                        <?php endif; ?>
                    </div>
                    <div class="chat_box">
                        <div class="chat_box_header">
                            <img src="<?= $user['avatar'] ?? 'test.jpg' ?>" alt="" class="chat_avata">
                            <div class="chat_infor">
                                <h3><?= $user['User_name'] ?></h3>
                                <p>2 giờ trước.<i class="fas fa-globe-asia"></i></p>
                            </div>
                            <div class="chat_actions">
                                <button class="chat_mini">-</button>
                                <button class="chat_close">x</button>
                            </div>
                        </div>
                        <div class="chat_content">
                            <?php foreach ($chat_messages as $msg): ?>
                                <?php $msg_class = ($msg['sender_id'] == $user_id) ? 'sent' : 'received'; ?>
                                <div class="chat_message <?= $msg_class ?>">
                                    <div class="message_text"><?= htmlspecialchars($msg['message']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <form action="" class="chat_input">
                            <input type="hidden" id="sender_id" value="<?= $user_id ?>"> <!-- có thể đổi -->
                            <input type="hidden" id="receiver_id" value="<?= $you_id ?>"> <!-- có thể đổi -->
                            <input type="text" class="chat_input_box" id="chatInput" placeholder="Nhập tin nhắn." required>
                            <button type="submit" class="send_btn" id="sendBtn"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                    <div class="space"> </div>

                    <div class="container_name">
                        <div class="infor1"> <b><?= $user['User_name'] ?></b> </div>
                        <div class="infor2">
                            <div class="field">
                                <p>Email: </p>
                                <p>Số điện thoại: </p>
                                <p>Địa chỉ: </p>
                                <p>Chức vụ: </p>
                            </div>
                            <div class="data">
                                <p><i><?= $user['email'] ?? '' ?></i></p>
                                <p><i><?= $user['phone_number'] ?? '' ?></i></p>
                                <p><i><?= $user['location'] ?? '' ?></i></p>
                                <p><i><?= $user['bio'] ?? '' ?></i></p>
                            </div>
                        </div>
                        <div class="container_stats">
                            <p>Đã tham gia từ: <?= $user['created_at'] ?? 'Chưa xác định' ?></p>
                            <p>Tổng số bài viết: </p>
                            <p>Tổng số câu hỏi: <?= count($questions) ?? 'Chưa xác định' ?></p>
                        </div>
                    </div>

                </div>

                <div class="container_about"> <?= $user['About'] ?? 'Chưa xác định' ?> </div>
            </div>

            <div class="layout">
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
                                <img src="<?php echo $user['avatar'] ?? '../WebForumTechnology/icon/test.jpg' ?>" alt="Ảnh">
                                <div class="post_user_infor">
                                    <h3><?= $user['User_name'] ?></h3>
                                    <p><?= $question['Date_tao'] ?? 'Không rõ ngày' ?> . <i class="fas fa-globe-asia"></i></p>
                                </div>
                            </div>

                            <div class="post_content">
                                <p class="post_text"><?= $question['Mo_ta'] ?? 'Không có nội dung câu hỏi' ?></p>
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
                                    <img src="<?php echo $user['avatar'] ?? '../WebForumTechnology/icon/test.jpg' ?>" alt="Ảnh">
                                    <textarea name="comment" class="comment_input_box" data-ques-id="<?= $question['ID_Ques'] ?>" placeholder="Viết bình luận ....."></textarea>
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
                                                    <div class="comment_text"><?= htmlspecialchars($c['Comment']) ?></div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
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