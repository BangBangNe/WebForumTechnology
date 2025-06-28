<?php
include 'db_connect.php'; // tạo biến $conn (PDO)

$user_id = $_SESSION['User_ID'];

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
                <img src="<?= htmlspecialchars($user['avatar'] ?? '../WebForumTechnology/icon/test.jpg') ?>" alt="Ảnh">
                <div style="padding: 20px;">
                    <input type="file" name="avatar" style="display: none;" id="avatarInput" accept="image/*">
                    <label for="avatarInput" class="custom-file-label">Thay avatar</label>
                </div>


            </div>
            <div class="space"> </div>
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

            </div>
        </div>

        <div class="container_about">
            <textarea oninput="autoResize(this)" onclick="autoResize2(this)"
             name="About" id="about" rows="4"><?= htmlspecialchars($user['About']) ?></textarea>
        </div>

        <div class="capnhat">
            <input type="hidden" name="User_ID" value="<?= $user['User_ID'] ?>">
            <button type="submit" name="update">Cập nhật thông tin</button>
        </div>
    </form>
</div>

  <script>
    function autoResize(el) {
      el.style.height = el.scrollHeight + 'px'; // đặt lại chiều cao theo nội dung
    }

    function autoResize2(el) {
      el.style.height = el.scrollHeight + 'px';
    }
  </script>