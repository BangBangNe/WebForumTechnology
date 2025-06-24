<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Tags - Stack Overflow</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>
<h5>Danh sách Tags</h5>

<div class="tag-container">

<?php
$sql = "SELECT t.ID_tag, t.Name, COUNT(q.ID_Ques) AS total_questions
        FROM tags t
        LEFT JOIN questions q ON t.ID_tag = q.ID_Tags
        GROUP BY t.ID_tag, t.Name
        ORDER BY total_questions DESC";

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($tag = $result->fetch_assoc()) {
        echo '<div class="tag-box">';
        echo '<a class="tag-name" href="questions.php?tag=' . urlencode($tag['Name']) . '">' . htmlspecialchars($tag['Name']) . '</a>';
        echo '<div class="tag-count">' . $tag['total_questions'] . ' câu hỏi</div>';
        echo '</div>';
    }
} else {
    echo '<p style="padding-left:20px;">Không có tag nào.</p>';
}
$conn->close();
?>
</div>
</body>
</html>
