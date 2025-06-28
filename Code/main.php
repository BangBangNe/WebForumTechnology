<?php include 'connect.php'; ?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Style/main.css">
  <title>Stack Overflow - Newest Questions</title>
</head>

<body>
  <div class="container-wrapper">
    <div class="main-content">

      <!-- Nội dung chính -->
      <div class="questions-header">
        <h2>Diễn đàn câu hỏi</h2>
        <div class="user-actions">
          <button class="ask-btn" onclick="location.href='index.php?page=cau_hoi'">Đặt câu hỏi</button>
          <button id="toggleFilterBtn" class="filter-toggle-btn">Lọc</button>
        </div>
      </div>
      <div style="color: gray; text-align:justify;">
        <i>Nơi người dùng có thể đăng các câu hỏi để được giải đáp các thắc mắc về chủ đề liên quan đến công nghệ.</i>
      </div>
      <br>

      <!-- Bộ lọc -->
      <form method="GET">
        <div id="filterBox" class="filter-box" style="display: none;">
          <div class="filter-group">
            <h4>Lọc theo</h4>
            <label><input type="radio" name="answer_filter" value="all" <?= (!isset($_GET['answer_filter']) || $_GET['answer_filter'] == 'all') ? 'checked' : '' ?>> Tất cả</label><br>
            <label><input type="radio" name="answer_filter" value="has" <?= ($_GET['answer_filter'] ?? '') == 'has' ? 'checked' : '' ?>> Có câu trả lời</label><br>
            <label><input type="radio" name="answer_filter" value="none" <?= ($_GET['answer_filter'] ?? '') == 'none' ? 'checked' : '' ?>> Không có câu trả lời</label><br>

          </div>

          <div class="filter-group">
            <h4>Sắp xếp theo</h4>
            <label><input type="radio" name="sort" value="newest" <?= ($_GET['sort'] ?? '') == 'newest' ? 'checked' : '' ?>> Mới nhất</label><br>
            <label><input type="radio" name="sort" value="oldest" <?= ($_GET['sort'] ?? '') == 'oldest' ? 'checked' : '' ?>> Cũ nhất</label><br>
            <label><input type="radio" name="sort" value="likes" <?= ($_GET['sort'] ?? '') == 'likes' ? 'checked' : '' ?>> Thích nhiều nhất</label><br>
          </div>

          <div class="filter-group">
            <h4>Chủ đề</h4>
            <input type="text" name="tag" value="<?= htmlspecialchars($_GET['tag'] ?? '') ?>" placeholder="e.g. SQL">
          </div>

          <div style="margin-top: 16px;">
            <button class="apply-btn">Lọc</button>
          </div>
        </div>
      </form>


      <!-- Danh sách câu hỏi -->
      <?php
      $where = [];

      $where = [];
      $orderBy = "q.ID_Ques DESC"; // mặc định: mới nhất

      // Lọc: không có câu trả lời (giả sử comments là bảng chứa trả lời)
      if (isset($_GET['answer_filter']) && $_GET['answer_filter'] === 'has') {
        $where[] = "q.ID_Ques IN (SELECT DISTINCT ID_Ques FROM comments)";
      } elseif (isset($_GET['answer_filter']) && $_GET['answer_filter'] === 'none') {
        $where[] = "q.ID_Ques NOT IN (SELECT DISTINCT ID_Ques FROM comments)";
      }





      // Lọc theo tag
      if (!empty($_GET['tag'])) {
        $tag = $conn->real_escape_string($_GET['tag']);
        $where[] = "t.Name LIKE '%$tag%'";
      }

      // Sắp xếp theo lựa chọn
      if (isset($_GET['sort'])) {
        switch ($_GET['sort']) {
          case 'oldest':
            $orderBy = "q.ID_Ques ASC";
            break;
          case 'likes':
            $orderBy = "q.like_count DESC"; // giả sử có cột like_count
            break;
          default:
            $orderBy = "q.ID_Ques DESC";
        }
      }

      $whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

      $sql = "SELECT q.ID_Ques, q.Mo_ta, q.Hinh_anh, q.like_count, q.Date_tao, t.Name AS tag_name, u.User_name
        FROM questions q
        JOIN tags t ON q.ID_Tags = t.ID_tag
        JOIN users u ON q.ID_user = u.User_ID
        $whereSql
        ORDER BY $orderBy";


      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="question-item">';

          echo '<a class="question-title" href="Code/Ques.php?id=' . htmlspecialchars($row['ID_Ques']) . '">' . htmlspecialchars($row['Mo_ta']) . '</a>';
          echo '<div class="meta">'.htmlspecialchars($row['like_count']).' like | '.htmlspecialchars($row['Date_tao']).'</div>';
          echo '<div class="tags">';
          echo '<span class="tag">' . htmlspecialchars($row['tag_name']) . '</span>';
          echo '<br>';
          echo '<br>';
          echo '</div>';
          echo '</div>';
        }
      } else {
        echo 'Không có câu hỏi nào.';
      }
      $conn->close();
      ?>

    </div>


  </div>


  <script>
    document.getElementById("toggleFilterBtn").addEventListener("click", function() {
      var filterBox = document.getElementById("filterBox");
      if (filterBox.style.display === "none") {
        filterBox.style.display = "flex";
      } else {
        filterBox.style.display = "none";
      }
    });
  </script>


</body>

</html>