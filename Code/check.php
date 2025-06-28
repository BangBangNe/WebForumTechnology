<?php
session_start();
// Nếu có user_id → chuyển đến trang thông tin người dùng
if (isset($_GET['user_id'])) {
    $user_id = (int)$_GET['user_id'];
    echo "<script>window.location.href = '../index.php?page=user_infor&user_id=$user_id';</script>";
    exit();
}

// Nếu chưa đăng nhập → chuyển về đăng nhập
if (!isset($_SESSION['User_ID'])) {
    echo "<script>window.location.href = 'Code/signInUP.php';</script>";
    exit();
}

// Nếu không có user_id → về trang chính
echo "<script>window.location.href = 'index.php?page=user_infor';</script>";
exit();
?>
