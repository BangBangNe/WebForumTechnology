<?php
include 'db_connect.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'UI_ques';
$allowed_types = ['UI_ques', 'UI_post']; // an toàn tránh include linh tinh


$you_id = $_GET['user_id'] ?? $_SESSION['User_ID']; // ID người bạn muốn nhắn tin, nếu không có thì sẽ lấy ID của người đang đăng nhập
$user_id = $_SESSION['User_ID'] ?? $you_id; // Người đang đăng nhập


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

$posts_result = mysqli_query($link, "SELECT * FROM posts WHERE user_id = $you_id ORDER BY created_at DESC");
$posts = [];

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
    <div class="infor">
        <div class="container">
            <div class="container_infor">
                <div class="container_up">

                    <div class="container_avata">
                        <img src="<?php echo $user['avatar'] ?? '../WebForumTechnology/icon/test.jpg' ?>" alt="Ảnh">

                        <?php if ($you_id == $user_id && isset($_SESSION['User_ID'])): ?>
                            <form action="index.php?page=cap_nhat" method="POST" style="margin-top: 10px; margin-right: 10px;">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <button class="update" type="submit">Cập nhật thông tin cá nhân</button>
                            </form>
                        <?php endif; ?>

                        <!-- Theo doi -->
                        <div class="count" style="text-align: left;">
                            <div class="num" id="followerCount"><?= $follower_count ?? 0 ?></div>
                            <div class="text">nguời theo dõi</div>
                        </div>
                        <?php if ($you_id != $user_id): ?>
                            <div class="button" id="followBtn"><?= $is_following ? 'Đang theo dõi' : 'Theo dõi' ?></div>
                        <?php endif; ?>

                        <!-- Chat -->
                        <?php if ($you_id != $user_id): ?>
                            <div class="container_chat">Nhắn tin</div>
                        <?php endif; ?>
                    </div>
                    <div class="chat_box">
                        <div class="chat_box_header">
                            <img src="<?= $user['avatar'] ?? 'test.jpg' ?>" alt="" class="chat_avata">
                            <div class="chat_infor">
                                <h3><?= $user['User_name'] ?></h3>
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
                        <div class="infor2">
                            <div class="field">
                                <p>Đã tham gia từ:</p>
                                <p>Tổng số bài viết:</p>
                                <p>Tổng số câu hỏi:</p>
                            </div>
                            <div class="data">
                                <p><i><?= $user['created_at'] ?? 'Chưa xác định' ?></i></p>
                                <p><i><?= $posts_result->num_rows ?? 'Chưa xác định' ?></i></p>
                                <p><i><?= count($questions) ?? 'Chưa xác định' ?></i></p>
                            </div>
                        </div>
                    </div>

                </div><br><br>

                <div class="container_about"> <?= $user['About'] ?? 'Chưa xác định' ?> </div>
                <div class="sidebar" style="display: flex; background-color: transparent; gap: 15px;">
                    <?php $temp = $_GET['user_id']??$_SESSION['User_ID'];

                    if ($type === 'UI_ques') { ?>
                        <a style="background-color:gray; color:aliceblue;" class="btn-UI" href="index.php?page=user_infor&user_id=<?php echo $temp; ?>&type=UI_ques">Câu hỏi</a> <br>
                        <a class="btn-UI" href="index.php?page=user_infor&user_id=<?php echo $temp; ?>&type=UI_post">Bài viết</a><br>
                    <?php
                    } else { ?>
                        <a class="btn-UI" href="index.php?page=user_infor&user_id=<?php echo $temp; ?>&type=UI_ques">Câu hỏi</a> <br>
                        <a style="background-color:gray; color:aliceblue;" class="btn-UI" href="index.php?page=user_infor&user_id=<?php echo $temp; ?>&type=UI_post">Bài viết</a><br>
                    <?php };
                    ?>


                </div>
            </div>

            <div class="layout">
                <!-- Bài viết -->
                <div id="main-content" class="container">
                    <?php
                    if (in_array($type, $allowed_types)) {
                        include "Code/{$type}.php";
                    } else {
                        echo "<p>Không tìm thấy nội dung.</p>";
                    }
                    ?></div>

            </div>

            <div class="end"><br></div>
        </div>
    </div>


</body>

</html>