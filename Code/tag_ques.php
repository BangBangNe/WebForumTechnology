<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Câu hỏi theo Tag</title>
  <link rel="stylesheet" href="../Style/tag.css">
</head>
<body>

<div class="container-wrapper">
  <div class="main-tagques">
    <?php
    $tagName = $_GET['tag'] ?? '';

    if (!$tagName) {
        echo "<p>Không tìm thấy tag phù hợp.</p>";
        exit;
    }

    echo "<h2>Câu hỏi chủ đề: <span style='color:#0074cc'>" . htmlspecialchars($tagName) . "</span></h2>";

    

    $tagSafe = $conn->real_escape_string($tagName);

    $sql = "SELECT q.ID_Ques, q.Mo_ta, q.Hinh_anh, t.Name AS tag_name, u.User_name
            FROM questions q
            JOIN tags t ON q.ID_Tags = t.ID_tag
            JOIN users u ON q.ID_user = u.User_ID
            WHERE t.Name LIKE '%$tagSafe%'
            ORDER BY q.ID_Ques DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="question-item">';
            echo '<a class="question-title" href="Code/Ques.php?id=' . $row['ID_Ques'] . '">' . htmlspecialchars($row['Mo_ta']) . '</a>';
            echo '<div class="meta">0 votes | 0 answers</div>';
            echo '<div class="tags"><span class="tag">' . htmlspecialchars($row['tag_name']) . '</span></div>';
            echo '</div>';
        }
    } else {
        echo "<p>Không có câu hỏi nào với tag này.</p>";
    }

  // Nút quay lại danh sách tag
  echo '<p><a href="index.php?page=tag" class="back-button">← Quay lại danh sách chủ đề</a></p>';

    $conn->close();
    ?>
  </div>
</div>

</body>
</html>
