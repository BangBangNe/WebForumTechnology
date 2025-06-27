<?php
session_start();
require 'db_connect.php';

if (!$_SESSION['User_ID']) {
    header('location:signInUP.php');
    exit('Bạn chưa đăng nhập');
}

$current_user_id = $_SESSION['User_ID']; 
// Lấy danh sách đối tượng đã từng chat
$sql = "
    SELECT 
        c.id as conversation_id,
        u.User_ID,
        u.User_name,
        (SELECT message FROM messages WHERE conversation_id = c.id ORDER BY created_at DESC LIMIT 1) AS last_message
    FROM conversations c
    JOIN users u ON u.User_ID = IF(c.user1_id = ?, c.user2_id, c.user1_id)
    WHERE c.user1_id = ? OR c.user2_id = ?
    ORDER BY (SELECT MAX(created_at) FROM messages WHERE conversation_id = c.id) DESC
";
$stmt = $link->prepare($sql);
$stmt->bind_param("iii", $current_user_id, $current_user_id, $current_user_id);
$stmt->execute();
$res = $stmt->get_result();

$partners = [];
while ($row = $res->fetch_assoc()) {
    $partners[] = $row;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tin nhắn</title>
    <link rel="stylesheet" href="../Style/tro_chuyen.css">
</head>
<body>

<div class="sidebar">
    <h3>Tin nhắn</h3>
    <?php foreach ($partners as $p): ?>
        <div class="partner" onclick="loadChat(<?= $p['User_ID'] ?>, '<?= addslashes($p['User_name']) ?>')">
            <b><?= htmlspecialchars($p['User_name']) ?></b><br>
            <small><?= htmlspecialchars($p['last_message']) ?></small>
        </div>
    <?php endforeach; ?>
</div>

<div class="chat-box">
    <div class="chat-header" id="chatHeader">Chọn người để bắt đầu trò chuyện</div>
    <div class="messages" id="messages"></div>
    <div class="chat-input">
        <input type="text" id="msgInput" placeholder="Nhập tin nhắn..." />
        <button onclick="sendMessage()">Gửi</button>
    </div>
</div>

<script>
let receiverId = 0;

function loadChat(uid, name) {
    receiverId = uid;
    document.getElementById('chatHeader').innerText = "Đang trò chuyện với: " + name;

    fetch(`get_messages.php?sender_id=<?= $current_user_id ?>&receiver_id=${uid}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('messages').innerHTML = html;
            document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
        });

}

function sendMessage() {
    const content = document.getElementById('msgInput').value.trim();
    if (!receiverId || !content) return;

    fetch('send_message.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `sender_id=<?= $current_user_id ?>&receiver_id=${receiverId}&message=${encodeURIComponent(content)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('msgInput').value = '';
            loadChat(receiverId, document.getElementById('chatHeader').innerText.split(': ')[1]);
        } else {
            alert(data.message || 'Không gửi được');
        }
    });
}
</script>
<a href="../index.php" class="back-button">⟵ Quay về</a>
</body>
</html>
