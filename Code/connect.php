<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Mặc định là rỗng nếu dùng XAMPP
$db = 'datadiendan';

$conn = new mysqli($host, $user, $password, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
