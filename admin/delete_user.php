<?php
$conn = mysqli_connect("localhost", "root", "", "datadiendan");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

$id = intval($_GET['id']);

// Kiểm tra xem user còn bài viết không
$checkPosts = mysqli_query($conn, "SELECT * FROM posts WHERE user_id = $id");
if (mysqli_num_rows($checkPosts) > 0) {
    echo "<script>
        alert('Không thể xóa user này vì còn bài viết. Hãy xóa tất cả bài viết của họ trước.');
        window.location.href = 'admin.php'; 
    </script>";
    exit;
}

// Tiếp tục xóa nếu không có bài viết
$sql = "DELETE FROM users WHERE User_ID = $id";
if (mysqli_query($conn, $sql)) {
    echo "<script>
        alert('Xóa user thành công.');
        window.location.href = 'admin.php';
    </script>";
} else {
    echo "Lỗi khi xóa user: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
