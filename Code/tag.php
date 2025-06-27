<?php include 'connect.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Tags - Stack Overflow Clone</title>
  <link rel="stylesheet" href="../Style/tag.css">
</head>
<body>
  <div class="main_tag">
    <h2>🧩 Danh sách chủ đề </h2>
    <p class="description">Khám phá các chủ đề phổ biến trên diễn đàn.</p>
    
    <div class="tag-grid">
      <?php
      $sql = "SELECT t.ID_tag, t.Name, COUNT(q.ID_Ques) AS total_questions
              FROM tags t
              LEFT JOIN questions q ON t.ID_tag = q.ID_Tags
              GROUP BY t.ID_tag, t.Name
              ORDER BY total_questions DESC";

      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          while ($tag = $result->fetch_assoc()) {
            echo '<a class="question-title tag-card" href="../WebForumTechnology/Code/tag_ques.php?tag=' . urlencode($tag['Name']) . '">';

              echo '<div class="tag-title">' . htmlspecialchars($tag['Name']) . '</div>';
              echo '<div class="tag-count">' . $tag['total_questions'] . ' câu hỏi</div>';
              echo '</a>';
          }
      } else {
          echo '<p>Không có tag nào.</p>';
      }
    


      $conn->close();
      ?>
    </div>
  </div>
</body>
</html>
