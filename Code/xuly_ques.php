<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['User_ID'])) {
    echo 'LOGIN_REQUIRED';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment'] ?? '');
    $ques_id = intval($_POST['ques_id'] ?? 0);
    $user_id = $_SESSION['User_ID'];

    if ($user_id && $comment && $ques_id) {

        $stmt = $conn->prepare("INSERT INTO comments (Comment, ID_User, ID_Ques) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Lỗi prepare: " . $conn->error);
        }
        $stmt->bind_param("sii", $comment, $user_id, $ques_id);
        $stmt->execute();

        // Lấy thông tin người dùng
        $result = $conn->query("SELECT User_name, avatar FROM users WHERE User_ID = $user_id");
        $user = $result->fetch_assoc();

        // Trả về HTML hiển thị bình luận mới
        echo '
        <div class="comment_item">
            <img src="' . htmlspecialchars($user['avatar'] ?? 'test.jpg') . '" alt="" class="comment_avata">
            <div class="comment_content">
                <div class="comment_user">' . htmlspecialchars($user['User_name']) . '</div>
                <div class="comment_text">' . htmlspecialchars($comment) . '</div>
            </div>
        </div>';
    } else {
        echo json_encode(['success' => false, 'error' => 'Thiếu dữ liệu']);
    }
}
?>