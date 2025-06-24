<?php
session_start();
header('Content-Type: application/json');
require 'db_connect.php';

if (!isset($_SESSION['User_ID']) || !isset($_POST['question_id'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin']);
    exit;
}

$user_id = (int) $_SESSION['User_ID']; // ✅ bạn nên dùng session thay vì fix cứng
$question_id = (int) $_POST['question_id'];

// Kiểm tra user đã like chưa
$check = mysqli_query($link, "
    SELECT * FROM question_likes 
    WHERE user_id = $user_id AND question_id = $question_id
");

if (!$check) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn kiểm tra']);
    exit;
}

if (mysqli_num_rows($check) > 0) {
    // Đã like → unlike
    mysqli_query($link, "
        DELETE FROM question_likes 
        WHERE user_id = $user_id AND question_id = $question_id
    ");
    
    mysqli_query($link, "
        UPDATE questions 
        SET like_count = GREATEST(like_count - 1, 0) 
        WHERE ID_Ques = $question_id
    ");

    echo json_encode([
        'success' => true,
        'status' => 'unliked',
        'totalLikes' => getLikeCount($link, $question_id)
    ]);
} else {
    // Chưa like → like
    mysqli_query($link, "
        INSERT INTO question_likes (user_id, question_id, liked_at) 
        VALUES ($user_id, $question_id, NOW())
    ");
    
    mysqli_query($link, "
        UPDATE questions 
        SET like_count = like_count + 1 
        WHERE ID_Ques = $question_id
    ");

    echo json_encode([
        'success' => true,
        'status' => 'liked',
        'totalLikes' => getLikeCount($link, $question_id)
    ]);
}

// Hàm đếm số like mới
function getLikeCount($link, $question_id) {
    $res = mysqli_query($link, "
        SELECT like_count FROM questions WHERE ID_Ques = $question_id
    ");
    $row = mysqli_fetch_assoc($res);
    return (int) ($row['like_count'] ?? 0);
}
