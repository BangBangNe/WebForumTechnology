<?php
session_start();
include 'db_connect.php'; // Bạn đã có file này

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment = trim($_POST['comment'] ?? '');
    $id_ques = intval($_POST['id_ques'] ?? 0);
    // $id_user = $_SESSION['user_id'] ?? 0;
     $id_user = 6; // Giả sử bạn đã đăng nhập và có ID người dùng là 6

    if ($comment !== '' && $id_ques > 0 && $id_user > 0) {
        // Chèn vào CSDL
        $stmt = mysqli_prepare($link, "INSERT INTO comments (Comment, ID_User, ID_Ques) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sii", $comment, $id_user, $id_ques);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            echo 'success';
        } else {
            echo 'db_error';
        }
    } else {
        echo 'missing_data';
    }
} else {
    echo 'invalid_method';
}
?>

