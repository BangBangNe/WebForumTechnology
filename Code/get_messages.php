<?php
require "db_connect.php";

// Kiểm tra dữ liệu đầu vào
if (!isset($_GET['sender_id'], $_GET['receiver_id'])) {
    http_response_code(400);
    exit("Thiếu thông tin người dùng");
}

$sender_id = (int)$_GET['sender_id'];
$receiver_id = (int)$_GET['receiver_id'];

if ($sender_id <= 0 || $receiver_id <= 0) {
    http_response_code(400);
    exit("ID người dùng không hợp lệ");
}

$min_id = min($sender_id, $receiver_id);
$max_id = max($sender_id, $receiver_id);

// Lấy conversation
$stmt = $link->prepare("SELECT id FROM conversations WHERE min_user_id = ? AND max_user_id = ?");
$stmt->bind_param("ii", $min_id, $max_id);
$stmt->execute();
$stmt->bind_result($conversation_id);

if (!$stmt->fetch()) {
    $stmt->close();
    exit("<p class='no-messages'>Chưa có tin nhắn nào trong cuộc trò chuyện này</p>");
}
$stmt->close();

// Lấy tin nhắn
$stmt = $link->prepare("
    SELECT m.sender_id, m.message, m.created_at, u.User_name 
    FROM messages m 
    JOIN users u ON m.sender_id = u.User_ID 
    WHERE m.conversation_id = ? 
    ORDER BY m.created_at ASC
");

if (!$stmt) {
    die("Lỗi prepare: " . $link->error);
}

$stmt->bind_param("i", $conversation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p class='no-messages'>Chưa có tin nhắn nào trong cuộc trò chuyện này</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        $messageClass = $row['sender_id'] == $sender_id ? 'sent' : 'received';
        $time = date("H:i d/m/Y", strtotime($row['created_at']));
        echo "
        <div class='chat_message {$messageClass}'>
            <div class='message_text'>".nl2br(htmlspecialchars($row['message']))."</div>
           
        </div>";
    }
}

$stmt->close();
?>
