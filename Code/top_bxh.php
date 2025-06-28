<?php
include 'connect.php'; // Kết nối đến cơ sở dữ liệu
$sql = "SELECT User_name, avatar, follow, User_ID FROM users ORDER BY follow DESC LIMIT 5";
$result = $conn->query($sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sidebar Navigation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="../Style/nav.css">
</head>

<body>
    <div class="top-follow-box">
        <h3>Top theo dõi</h3>
<ul class="top-follow-list">
    <?php
    $rank = 1;
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $avatar = !empty($row['avatar']) ? $row['avatar'] : 'uploads/icon/avatar_md.jpg';
            $name = htmlspecialchars($row['User_name']);
            $follow = number_format((int)$row['follow']);
            $user_id = (int)$row['User_ID'];
    ?>
            <li>
                <span class="rank"><?php echo str_pad($rank, 2, '0', STR_PAD_LEFT); ?></span>
                <img src="<?php echo $avatar; ?>" alt="Avatar">
                <div class="user-info">
                    <!-- Link chuyển sang check.php để xử lý trước khi nhảy -->
                    <a class="Top-name" href="Code/check.php?user_id=<?php echo $user_id; ?>">
                        <strong><?php echo $name; ?></strong>
                    </a>
                    <div><span class="follow"><?php echo $follow; ?> Followers</span></div>
                </div>
            </li>
    <?php
            $rank++;
        }
    } else {
        echo "<li>Không có dữ liệu.</li>";
    }
    ?>
</ul>

        </ul>
    </div>
</body>

</html>