<?php
include 'db_connect.php';

// Lấy user có ID = 1
$user_id = 6;
$user_result = mysqli_query($link, "SELECT * FROM users WHERE User_ID = $user_id");
$user = mysqli_fetch_assoc($user_result);

// Lấy câu hỏi mới nhất của user
$question_result = mysqli_query($link, "SELECT * FROM questions WHERE ID_user = $user_id ORDER BY Date_tao DESC LIMIT 1");
$question = mysqli_fetch_assoc($question_result);

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
// Lấy level của user
$level_result = mysqli_query($link, "SELECT level FROM users WHERE User_ID = $user_id");
$level = mysqli_fetch_assoc($level_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <link rel="stylesheet" href="user_infor.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="infor">
        <header class="header">
            <nav class="header_navbar">
                StackOverflow
            </nav>
        </header>

        <div class="container">
            <div class="container_left">
                <ul class="left_menu">
                    <li><ion-icon name="home-outline"></ion-icon> Home</li>
                    <li><ion-icon name="person-outline"></ion-icon> Trang cá nhân</li>
                    <li><ion-icon name="pricetags-outline"></ion-icon> Tags</li>
                    <li><ion-icon name="pencil-outline"></ion-icon> Bàn luận vấn đề</li>
                    <li><ion-icon name="chatbox-outline"></ion-icon> Chat</li>
                    <li><ion-icon name="search-circle-outline"></ion-icon> Users</li>
                </ul>
            </div>

            <div class="container_right">
                <div class="container_avata">
                    <img src="<?= $user['avatar'] ?? 'test.jpg' ?>" alt="" class="avata">
                </div>

                <div class="container_name">
                    <b><?= $user['User_name'] ?></b>
                    <p>Email: <?= $user['email'] ?? '' ?></p>
                    <p>phone:<?= $user['phone_number'] ?? '' ?></p>
                    <p>Location:<?= $user['location'] ?? '' ?></p>
                    <p>Bio:<?= $user['bio'] ?? ''?></p>
                </div>

                <div class="flower" id="followerCount"><?= $user['follow'] ?? 0 ?></div>
                <div class="button" id="followBtn">Flow me</div>

                <!-- Chat -->
                <div class="container_chat">Chat</div>

                <!-- Khung chat -->
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
                        <div class="chat_message received">
                            <div class="message_text">Xin chào</div>
                        </div>
                        <div class="chat_message sent">
                            <div class="message_text">Chào bạn</div>
                        </div>
                    </div>

                    <form action="" class="chat_input">
                        <input type="hidden" name="message_id" value="123" id="message_id">
                        <input type="text" class="chat_input_box" placeholder="Nhập tin nhắn..." required>
                        <button type="submit" class="send_btn"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>

                <div class="container_stats">
                    <p>Thời gian hoạt động</p>
                    <p>Level: <?= $user['level'] ?? 'Chưa xác định' ?></p>
                    <p>Rate</p>
                    <p>Số cmt</p>
                </div>

                <div class="container_about">
                    <ul>
                        <?= $user['About'] ?? 'Chưa xác định' ?>
                    </ul>
                </div>

                <!-- Bài viết -->
                <div class="container_post">
                    <div class="post_header">
                        <img src="<?= $user['avatar'] ?? 'test.jpg' ?>" alt="" class="post_avata">
                        <div class="post_user_infor">
                            <h3><?= $user['User_name'] ?></h3>
                            <p><?= $question['Date_tao'] ?? 'Không rõ ngày' ?> . <i class="fas fa-globe-asia"></i></p>
                        </div>
                    </div>

                    <div class="post_content">
                        <p class="post_text"><?= $question['Mo_ta'] ?? 'Không có nội dung câu hỏi' ?></p>
                    </div>

                    <div class="post_stats">
                        <div class="likes_count"><i class="fas fa-thumbs-up"></i> 42</div>
                        <div class="comments_count"><?= count($comments) ?> bình luận</div>
                    </div>

                    <div class="post_actions">
                        <div class="action_btn like_btn" onclick="toggleLike(this)">
                            <i class="far fa-thumbs-up"></i>
                            <span>Thích</span>
                        </div>
                        <div class="action-btn comment-btn" onclick="focusComment()">
                            <i class="far fa-comment"></i>
                            <span>Bình luận</span>
                        </div>
                        <div class="action_btn share_btn">
                            <i class="far fa-share-square"></i>
                            <span>Chia sẻ</span>
                        </div>
                    </div>

                    <div class="comment_section">
                        <div class="comment_input">
                            <img src="<?= $user['avatar'] ?? 'test.jpg' ?>" alt="" class="comment_avata">
                            <textarea name="comment" class="comment_input_box" placeholder="Viết bình luận ....." rows="1"></textarea>
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
                                            <div class="comment_actions">
                                                <span class="comment_action">Thích</span>
                                                <span class="comment_action">Phản hồi</span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="user_infor.js"></script>
        <footer class="footer"></footer>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
