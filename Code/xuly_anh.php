<?php
include 'db_connect.php'; // kết nối CSDL để có biến $link
session_start(); // Bắt đầu phiên làm việc

$upload_dir = '../uploads/avatar/';
$avatar = '';

if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['avatar']['tmp_name'];
    $file_name = basename($_FILES['avatar']['name']);
    $file_type = mime_content_type($file_tmp);
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($file_type, $allowed_types)) {
        die("Chỉ cho phép ảnh định dạng JPG, PNG hoặc GIF.");
    }

    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $new_file_name = uniqid('avatar_', true) . '.' . $file_ext;
    $destination = $upload_dir . $new_file_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        $avatar = str_replace('../', '', $destination);

        // Giả sử bạn có sẵn User_ID trong session hoặc POST
        $user_id = $_SESSION['User_ID'] ; // ví dụ gán tạm là 1

        $sql = "UPDATE users SET avatar = '$avatar' WHERE User_ID = $user_id";
        if (!mysqli_query($link, $sql)) {
            die("Lỗi cập nhật CSDL: " . mysqli_error($link));
        }

        echo "Cập nhật ảnh thành công.";
        header("Location: ../index.php");
    } else {
        die("Lỗi khi tải ảnh lên.");
    }
}
?>