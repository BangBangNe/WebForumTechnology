<?php
// Kết nối CSDL
session_start();
$link = mysqli_connect("localhost", "root", "") or die("Không thể kết nối đến server này!");
mysqli_select_db($link, "datadiendan") or die("Database này không tồn tại!");

// Kiểm tra xem form có được gửi qua phương thức POST hay không
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password']; 

    // Kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM admins WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($link, $sql);

    // Kiểm tra kết quả truy vấn
    if ($result === false) {
        die("Lỗi truy vấn SQL: " . mysqli_error($link));
    }

    if (mysqli_num_rows($result) > 0) {
    $admin = mysqli_fetch_assoc($result);

    // Lưu vào session
    $_SESSION['Admin_ID'] = $admin['admin_id'];         // hoặc tên cột phù hợp trong DB
    $_SESSION['Admin_Name'] = $admin['admin_name'];     // tên admin

    // Chuyển trang
    header("Location: admin.php");
    exit();
    } else {
        echo "Thông tin đăng nhập không chính xác. Vui lòng thử lại.";
    }
}