<?php
session_start();
include 'db_connect.php'; // file này tạo $link

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $user_id = $_POST['User_ID'];
    $username = $_POST['User_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone_number'];
    $location = $_POST['location'];
    $bio = $_POST['bio'];
    $about = $_POST['About'];

    // Xử lý ảnh đại diện
    $avatar_path = null;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/avatar/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $tmp_name = $_FILES['avatar']['tmp_name'];
        $file_name = basename($_FILES['avatar']['name']);
        $new_filename = time() . "_" . $file_name;
        $target_file = $upload_dir . $new_filename;

        if (move_uploaded_file($tmp_name, $target_file)) {
            $avatar_path = 'uploads/avatar/' . $new_filename; // Lưu đường dẫn tương đối vào DB
        }
    }

    // Câu lệnh SQL cập nhật
    if ($avatar_path) {
        $query = "UPDATE users SET User_name=?, email=?, phone_number=?, location=?, bio=?, About=?, avatar=? WHERE User_ID=?";
    } else {
        $query = "UPDATE users SET User_name=?, email=?, phone_number=?, location=?, bio=?, About=? WHERE User_ID=?";
    }

    $stmt = mysqli_prepare($link, $query);

    if ($avatar_path) {
        mysqli_stmt_bind_param($stmt, "sssssssi", $username, $email, $phone, $location, $bio, $about, $avatar_path, $user_id);
    } else {
        mysqli_stmt_bind_param($stmt, "ssssssi", $username, $email, $phone, $location, $bio, $about, $user_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['update_success'] = "Cập nhật thành công!";
    } else {
        $_SESSION['update_error'] = "Lỗi khi cập nhật thông tin.";
    }

    header("Location: ../index.php");
    exit();
} else {
    die("Truy cập không hợp lệ.");
}
