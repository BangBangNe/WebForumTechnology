<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

$comment = trim($_POST['comment'] ?? '');
$id_ques = intval($_POST['id_ques'] ?? 0);
$id_user = 6; // giả sử đang login

if ($comment !== '' && $id_ques > 0 && $id_user > 0) {
    $stmt = mysqli_prepare($link, "INSERT INTO comments (Comment, ID_User, ID_Ques) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sii", $comment, $id_user, $id_ques);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        $stmt2 = mysqli_prepare($link, "SELECT User_name, avatar FROM users WHERE User_ID = ?");
        mysqli_stmt_bind_param($stmt2, "i", $id_user);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_bind_result($stmt2, $username, $avatar);
        mysqli_stmt_fetch($stmt2);

        echo json_encode([
            'user_name' => $username ?? 'Người dùng',
            'avatar' => $avatar ?? 'default.jpg',
            'text' => $comment,
            'time' => 'Vừa xong'
        ]);
    } else {
        echo json_encode(['error' => 'Lỗi ghi CSDL']);
    }
} else {
    echo json_encode(['error' => 'Thiếu dữ liệu']);
}
