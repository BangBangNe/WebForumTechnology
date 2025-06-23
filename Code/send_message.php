<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

require 'db_connect.php';

// Kiểm tra dữ liệu đầu vào
if (!isset($_POST['sender_id'], $_POST['receiver_id'], $_POST['message'])) {
    http_response_code(400);
    exit(json_encode(['error' => 'Thiếu thông tin bắt buộc']));
}

// Làm sạch
$sender_id = (int)$_POST['sender_id'];
$receiver_id = (int)$_POST['receiver_id'];
$message = trim($_POST['message']);

if ($sender_id <= 0 || $receiver_id <= 0) {
    http_response_code(400);
    exit(json_encode(['error' => 'ID người dùng không hợp lệ']));
}
if (empty($message)) {
    http_response_code(400);
    exit(json_encode(['error' => 'Tin nhắn không được để trống']));
}
if (strlen($message) > 500) {
    http_response_code(400);
    exit(json_encode(['error' => 'Tin nhắn quá dài (tối đa 500 ký tự)']));
}

// Kiểm tra user tồn tại
$check = $link->prepare("SELECT User_ID FROM users WHERE User_ID IN (?, ?)");
$check->bind_param("ii", $sender_id, $receiver_id);
$check->execute();
$res = $check->get_result();
if ($res->num_rows < 2) {
    http_response_code(400);
    exit(json_encode(['error' => 'Một trong hai người dùng không tồn tại']));
}

// Kiểm tra conversation đã tồn tại chưa
$min_id = min($sender_id, $receiver_id);
$max_id = max($sender_id, $receiver_id);
$stmt = $link->prepare("SELECT id FROM conversations WHERE min_user_id = ? AND max_user_id = ?");
$stmt->bind_param("ii", $min_id, $max_id);
$stmt->execute();
$stmt->bind_result($conversation_id);

if (!$stmt->fetch()) {
    $stmt->close();
    $stmt = $link->prepare("INSERT INTO conversations (user1_id, user2_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $sender_id, $receiver_id);
    if (!$stmt->execute()) {
        http_response_code(500);
        exit(json_encode(['error' => 'Lỗi khi tạo conversation: ' . $stmt->error]));
    }
    $conversation_id = $stmt->insert_id;
} else {
    $stmt->close();
}

// Gửi tin nhắn
$stmt = $link->prepare("INSERT INTO messages (conversation_id, sender_id, message) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $conversation_id, $sender_id, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => 'Tin nhắn đã được gửi', 'message_id' => $stmt->insert_id]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Lỗi khi gửi tin nhắn: ' . $stmt->error]);
}
$stmt->close();
?>
