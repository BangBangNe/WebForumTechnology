<?php
include 'db_connect.php'; // tạo biến $conn (PDO)

$user_id = $_SESSION['User_ID'] ;

// Lấy thông tin người dùng từ DB
$query = "SELECT * FROM users WHERE User_ID = ?";
$stmt = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("Không tìm thấy người dùng.");
}
?>

<link rel="stylesheet" href="../Style/user_infor.css">

<div class="container_infor">
    <form id="updateForm" action="Code/xuly_capnhat.php" method="POST" enctype="multipart/form-data">
        <div class="container_up">
            <div class="container_avata">
                <img src="<?= htmlspecialchars($user['avatar'] ?? '../WebForumTechnology/icon/test.jpg') ?>" alt="Ảnh" style="width:100px; height:100px; border-radius: 50%;">
                <label for="avatarInput">Ảnh đại diện mới:</label>
                <input type="file" name="avatar" id="avatarInput" accept="image/*">
            </div>

            <div class="container_name">
                <div class="infor1">
                    <b><input type="text" name="User_name" value="<?= htmlspecialchars($user['User_name']) ?>" required></b>
                </div>

                <div class="infor2">
                    <div class="field">
                        <p>Email:</p>
                        <p>Số điện thoại:</p>
                        <p>Địa chỉ:</p>
                        <p>Chức vụ:</p>
                    </div>
                    <div class="data">
                        <p><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></p>
                        <p><input type="text" name="phone_number" value="<?= htmlspecialchars($user['phone_number']) ?>"></p>
                        <p><input type="text" name="location" value="<?= htmlspecialchars($user['location']) ?>"></p>
                        <p><input type="text" name="bio" value="<?= htmlspecialchars($user['bio']) ?>"></p>
                    </div>
                </div>

                <div class="container_stats">
                    <p>Đã tham gia từ: <?= htmlspecialchars($user['created_at']) ?></p>
                    <p>Tổng số câu hỏi: <?= htmlspecialchars($user['ID_Ques'] ?? 'Không rõ') ?></p>
                </div>
            </div>
        </div>

        <div class="container_about">
            <label for="about">Giới thiệu:</label>
            <textarea name="About" id="about" rows="4"><?= htmlspecialchars($user['About']) ?></textarea>
        </div>

        <div style="text-align:center; margin-top:20px;">
            <input type="hidden" name="User_ID" value="<?= $user['User_ID'] ?>">
            <button type="submit" name="update">Cập nhật thông tin</button>
        </div>
    </form>
</div>
