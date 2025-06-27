<?php
include 'connect.php';
session_start();
include 'db_connect.php';
if (!isset($_SESSION['User_ID'])) {
    echo 'LOGIN_REQUIRED';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment']);
    $post_id = intval($_POST['post_id']);
    $user_id = $_SESSION['User_ID'] ?? 0;

    if ($user_id && $comment && $post_id) {
        $stmt = $conn->prepare("INSERT INTO post_comments (content, post_id, user_id) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $comment, $post_id, $user_id);
        $stmt->execute();

        // Lấy tên người dùng và avatar
        $result = $conn->query("SELECT User_name, avatar FROM users WHERE User_ID = $user_id");
        $user = $result->fetch_assoc();

        // Trả về HTML hiển thị bình luận vừa thêm
        echo '
        <div class="comment_item">
            <img src="' . htmlspecialchars($user['avatar'] ?? 'test.jpg') . '" alt="" class="comment_avata">
            <div class="comment_content">
                <div class="comment_user">' . htmlspecialchars($user['User_name']) . '</div>
                <div class="comment_text">' . htmlspecialchars($comment) . '</div>
            </div>
        </div>';
    }
    else {
        echo json_encode(['success' => false, 'error' => 'Thiếu dữ liệu']);
    }
}
?>