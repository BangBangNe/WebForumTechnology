<?php
// Kết nối đến cơ sở dữ liệu
$link = mysqli_connect("localhost", "root", "", "datadiendan");

if (!$link) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Kiểm tra tính hợp lệ của dữ liệu nhập vào
    if (empty($name) || empty($email) || empty($password)) {
        echo "Vui lòng điền đầy đủ thông tin.";
    } else {
        // Kiểm tra xem email đã tồn tại chưa
        $sql = "SELECT * FROM Users WHERE email = '$email'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "Email đã tồn tại. Vui lòng thử email khác.";
        } else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $sql = "INSERT INTO Users (User_name, email, password) VALUES ('$name', '$email', '$password')";

            if (mysqli_query($link, $sql)) {
                echo "Đăng ký thành công!";
                header("Location: SignInUp.php");
                exit();
            } else {
                echo "Lỗi khi thêm dữ liệu: " . mysqli_error($link);
            }
        }
    }
}

mysqli_close($link);
?>