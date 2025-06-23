<?php
include 'db_connect.php';

header('Content-Type: application/json');

// Nhận dữ liệu
$user_id = $_POST['user_id'] ?? 0;
$followed_id = $_POST['followed_id'] ?? 0;


// Kiểm tra
if($user_id <= 0 || $followed_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin user']);
    exit;
}

try {
    // Kiểm tra đã follow chưa
    $check = mysqli_query($link, "SELECT * FROM followers 
              WHERE follower_id = $user_id AND followed_id = $followed_id");
    
    if(mysqli_num_rows($check) > 0) {
        // Hủy follow
        mysqli_query($link, "DELETE FROM followers 
              WHERE  follower_id = $user_id AND followed_id = $followed_id");
        $is_following = false;

    } else {
        // Thêm follow
        mysqli_query($link, "INSERT INTO followers (follower_id, followed_id) 
               VALUES ($user_id, $followed_id)"); 
        $is_following = true;
    }
    
    // Đếm lại số follower
    $count = mysqli_query($link, "SELECT COUNT(*) as count FROM followers 
              WHERE followed_id = $followed_id");
    $count_data = mysqli_fetch_assoc($count);
    
    echo json_encode([
        'success' => true,
        'is_following' => $is_following,
        'follower_count' => $count_data['count']
    ]);
    
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}