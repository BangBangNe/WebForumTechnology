<?php
include 'connect.php';

$sort = $_GET['sort'] ?? null;
$follower_id = $_GET['followed_by'] ?? null;
$current_id = $_SESSION['User_ID'] ?? null; // id user đang đăng nhập

// Nếu có lọc theo người đang theo dõi
if ($follower_id) {
    $follower_id = intval($follower_id);
    $sql = "SELECT u.*
            FROM users u
            JOIN followers f ON u.User_ID = f.followed_id
            WHERE f.follower_id = $follower_id";

    // Nếu có thêm sắp xếp A-Z hoặc Z-A
    if ($sort == 'az') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) ASC";
    } elseif ($sort == 'za') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) DESC";
    }
} else {
    // Không có lọc theo người đang theo dõi
    $sql = "SELECT * FROM users";

    if ($sort == 'az') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) ASC";
    } elseif ($sort == 'za') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) DESC";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/user.css">

</head>

<body>
    <div class="main">
        <div class="users">
            <h1>Người dùng</h1>
            <div class="tim-xep">
                <div class="fas fa-search">
                    <form><input type="text" placeholder="Tìm kiếm..." /></form>
                </div>
                <div class="sap-xep">
                    <b>Tìm kiếm theo TOP |</b>
                    <span><a href="">Kinh Nghiệm</a></span>
                    <span><a href="">Rate</a></span>
                    <span><a href="">Theo dõi</a></span>
                </div>
            </div>
            <div class="time">
                <div class="sub-time">
                    <?php if ($current_id != null) { ?>
                        <a href="index.php?page=user&followed_by=<?php echo $current_id; ?>"><span>Người đang theo dõi bạn</span></a>
                    <?php } ?>
                    <a href="index.php?page=user&sort=az"><span>A-Z</span></a>
                    <a href="index.php?page=user&sort=za"><span>Z-A</span></a>
                </div>
            </div>
            <div class="trang-user">
                <?php
                if ($result->num_rows > 0) {
                    // Lặp qua từng dòng dữ liệu
                    while ($row = $result->fetch_assoc()) {
                        $user_id = htmlspecialchars($row["User_ID"]);
                        if ($user_id != $current_id):
                            echo '
                    <a href="index.php?page=user_infor&user_id=' . $user_id . '" class="user-link">
                        <div class="user">
                            <div class="anh"><img src="' . htmlspecialchars($row["avatar"]) . '" alt=""></div>
                            <div class="thongtin">
                                <h4>' . htmlspecialchars($row["User_name"]) . '</h4>
                                <div class="vi-tri">Nơi ở: ' . htmlspecialchars($row["location"]) . '</div>
                                <div class="theo-doi">Lượt theo dõi: ' . htmlspecialchars($row["follow"]) . '</div>
                                <div class="chuyen-nganh">BIO: ' . htmlspecialchars($row["bio"]) . '</div>
                            </div>
                        </div>
                    </a>
                    ';
                        endif;
                    }
                } else {
                    echo "Không có dữ liệu.";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>

</body>

</html>