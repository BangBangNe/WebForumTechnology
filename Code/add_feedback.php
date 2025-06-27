<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['User_ID'])) {
        die("Bạn chưa đăng nhập.");
    }

    $user_id = $_SESSION['User_ID'];
    $subject = $_POST['title'];   // Tiêu đề phản hồi
    $message = $_POST['content']; // Nội dung phản hồi
    $topic = $_POST['topic'];     // Chủ đề phản hồi
    $posted_at = date('Y-m-d H:i:s'); // Thời gian gửi

    // Nếu bạn có cột full_name hay details, bạn có thể sửa thêm
    $full_name = $_SESSION['User_name'];
    $details = "Phản hồi từ người dùng qua form.";

    $sql = "INSERT INTO feedback (user_id, subject, message, posted_at, full_name, details)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $subject, $message, $posted_at, $full_name, $details);

    if ($stmt->execute()) {
        echo "<script>alert('Gửi phản hồi thành công!'); window.location.href='../index.php';</script>";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>