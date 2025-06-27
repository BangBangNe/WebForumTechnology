<?php
include '../code/connect.php';

// Gửi phản hồi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_index'])) {
    $filter = $_GET['filter'] ?? '';
    $i = (int)$_POST['submit_index'];
    $phanhoi = $conn->real_escape_string($_POST['feedback'][$i] ?? '');
    $id_baiviet = (int)$_POST['feedback_id'][$i];

    $check = $conn->query("SELECT * FROM feedback_response WHERE feedback_id = $id_baiviet");

    if($check == true){
      echo "loi";
    }

    echo "<pre>";
print_r($check);
echo "</pre>";

    if ($check && $check->num_rows > 0) {
        // Cập nhật phản hồi đã tồn tại
        $sql = "UPDATE feedback_response 
                SET response = '$phanhoi', status = 'đã phản hồi', responded_at = NOW()
                WHERE feedback_id = $id_baiviet";
    } else {
        // Chưa có phản hồi → thêm mới
        $sql = "INSERT INTO feedback_response (feedback_id, response, status, responded_at)
                VALUES ($id_baiviet, '$phanhoi', 'đã phản hồi', NOW())";
    }

    if (!$conn->query($sql)) {
        die("Lỗi query: " . $conn->error); // Gợi ý: dùng `die()` nếu bạn muốn dừng luôn
    } else {
        header("Location: ?page=phanhoi" . ($filter ? "&filter=$filter" : ""));
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>binhluan</title>
<style>
    table {
      border-collapse: collapse;
      width: 100%;
      background: white;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #f5f5f5;
    }

    tr:hover {
      background-color: #f0f8ff;
    }

    select {
      padding: 5px;
      width: 5%;
    }

    .btn {
      text-decoration: none;
      padding: 4px 8px;
      border-radius: 4px;
      margin: 0 2px;
    }

    .sua {
      background-color: #4CAF50;
      color: white;
    }

    .xoa {
      background-color: #f44336;
      color: white;
    }
    .xem{
      background-color: #4868f5;
      color: white;
    }
    textarea {
      width: 100%;
      min-height: 60px;
      resize: vertical;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      box-sizing: border-box;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }
    h1 {
      margin-bottom: 20px;
    }
    .select-hover select {
      pointer-events: none;
      position: relative;
    }
    .select-hover:hover select {
    pointer-events: auto;
    }
</style>
</head>
<body>
<h1>Phản hồi</h1>

<table>
  <thead>
    <tr>
      <th>Ngày gửi</th>
      <th>Tiêu đề hỗ trợ</th>
      <th>Họ và tên</th>
      <th>Nội dung chi tiết</th>
      <th>Duyệt</th>
    </tr>
  </thead>
  <tbody>
<?php
// Xử lý lọc
$filter = $_GET['filter'] ?? '';
$baiviet = [];

// Truy vấn cơ bản
$sql = "SELECT f.feedback_id, f.subject, f.message, f.posted_at,
               r.response, r.status
        FROM feedback f
        LEFT JOIN feedback_response r ON f.feedback_id = r.feedback_id";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    $baiviet[] = [
        'id' => $row['feedback_id'],
        'subject' => $row['subject'],
        'message' => $row['message'],
        'posted_at' => $row['posted_at'],
        'phanhoi' => $row['response'] ?? '',
        'trangthai' => $row['status'] ?? ''
    ];

    }
}

// Hiển thị bảng
foreach ($baiviet as $index => $bv):
?>
<tr>
  <td><?= $bv['posted_at'] ?></td>
  <td><?= $bv['subject'] ?></td>
  <td><?= $bv['message'] ?></td>
  <td>
     <?php if ($bv['trangthai'] !== 'đã phản hồi') { ?>
      <form method="POST" action="?page=phanhoi<?= $filter ? '&filter=' . $filter : '' ?>">
          <textarea name="feedback[<?= $index ?>]" placeholder="Nhập phản hồi..."></textarea>
          <input type="hidden" name="submit_index" value="<?= $index ?>">
          <input type="hidden" name="feedback_id[<?= $index ?>]" value="<?= $bv['id'] ?>">
          <button type="submit" class="btn sua">Gửi</button>
      </form>
     <?php }else { ?>
      <form method="POST" action="?page=phanhoi<?= $filter ? '&filter=' . $filter : '' ?>">
        <?= htmlspecialchars($bv['phanhoi']) ?>
      </form>
      <?php } ?>
  </td>
  <td><?= $bv['trangthai'] ?: 'Đang xử lý' ?></td>


</tr>
<?php endforeach; ?>

  </tbody>
</table>
</body>
</html>
