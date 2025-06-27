<?php
include 'connect.php';

$sort = $_GET['sort'] ?? null;
$follower_id = $_GET['followed_by'] ?? null;
$search = $_GET['search'] ?? null;
$current_id = $_SESSION['User_ID'] ?? null;

// Truy vấn
if ($follower_id) {
    $follower_id = intval($follower_id);
    $sql = "SELECT u.*
            FROM users u
            JOIN followers f ON u.User_ID = f.followed_id
            WHERE f.follower_id = $follower_id";

    if ($search) {
        $search = $conn->real_escape_string($search);
        $sql .= " AND u.User_name LIKE '%$search%'";
    }

    if ($sort == 'az') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) ASC";
    } elseif ($sort == 'za') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) DESC";
    }
} else {
    $sql = "SELECT * FROM users";

    if ($search) {
        $search = $conn->real_escape_string($search);
        $sql .= " WHERE User_name LIKE '%$search%'";
    }

    if ($sort == 'az') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) ASC";
    } elseif ($sort == 'za') {
        $sql .= " ORDER BY SUBSTRING_INDEX(User_name, ' ', -1) DESC";
    }
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Người dùng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/user.css">
</head>

<body>
    <div class="main">
        <div class="users">
            <h1>Người dùng</h1>

            <!-- Tìm kiếm và sắp xếp -->
            <div class="tim-xep">
                <div class="fas fa-search">
                    <form method="GET" action="index.php">
                        <input type="hidden" name="page" value="user">
                        <?php if ($follower_id): ?>
                            <input type="hidden" name="followed_by" value="<?= $follower_id ?>">
                        <?php endif; ?>
                        <input type="text" id="searchInput" name="search" placeholder="Tìm kiếm..." value="<?= htmlspecialchars($search ?? '') ?>" />
                    </form>
                </div>
                <div class="sap-xep">
                    <b>Tìm kiếm theo TOP |</b>
                    <span><a href="#">Kinh Nghiệm</a></span>
                    <span><a href="#">Rate</a></span>
                    <span><a href="#">Theo dõi</a></span>
                </div>
            </div>

            <!-- Sắp xếp -->
            <div class="time">
                <div class="sub-time">
                    <?php if ($current_id != null) { ?>
                        <a href="index.php?page=user&followed_by=<?= $current_id ?>"><span>Người đang theo dõi bạn</span></a>
                    <?php } ?>
                    <a href="index.php?page=user&sort=az<?= $search ? '&search=' . urlencode($search) : '' ?>"><span>A-Z</span></a>
                    <a href="index.php?page=user&sort=za<?= $search ? '&search=' . urlencode($search) : '' ?>"><span>Z-A</span></a>
                </div>
            </div>

            <!-- Danh sách người dùng -->
            <div class="trang-user" id="userList">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $user_id = htmlspecialchars($row["User_ID"]);
                        if ($user_id != $current_id):
                            echo '
                                <a href="index.php?page=user_infor&user_id=' . $user_id . '" class="user-link">
                                    <div class="user">
                                        <div class="anh"><img src="' . htmlspecialchars($row["avatar"]) . '" alt=""></div>
                                        <div class="thongtin">
                                            <h4 class="user-name">' . htmlspecialchars($row["User_name"]) . '</h4>
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
                    echo "<p>Không tìm thấy người dùng nào.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </div>
</body>
<script>
document.getElementById("searchInput").addEventListener("input", function () {
    const keyword = this.value.toLowerCase();
    const users = document.querySelectorAll("#userList .user");

    users.forEach(user => {
        const name = user.querySelector(".user-name").textContent.toLowerCase();
        if (name.includes(keyword)) {
            user.parentElement.style.display = "block"; // a tag bao quanh
        } else {
            user.parentElement.style.display = "none";
        }
    });
});
</script>

</html>
