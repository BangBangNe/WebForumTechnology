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
        <h2>Câu hỏi mới nhất</h2>
        <div class="user-actions">
          <button class="ask-btn">Ask Question</button>
          <button id="toggleFilterBtn" class="filter-toggle-btn">lọc</button>
          <div class="user-avatar" title="User profile"></div>
        </div>
      </div>
      <p>24,234,007 câu hỏi </p>

      <!-- Bộ lọc -->
      <form method="GET">
        <div id="filterBox" class="filter-box" style="display: none;">
          <div class="filter-group">
            <h4>Lọc theo</h4>
            <label><input type="checkbox" name="no_answers" value="1" <?= isset($_GET['no_answers']) ? 'checked' : '' ?>> Không có câu trả lời</label><br>

            <label><input type="checkbox"> Không có câu trả lời được chấp nhận</label><br>
            <label><input type="checkbox"> Không có Staging Ground </label><br>
            <label><input type="checkbox"> Có bounty</label><br>
            <input type="text" placeholder="Days old" style="width: 80px; margin-top: 4px;">
          </div>

          <div class="filter-group">
            <h4>Sắp xếp theo</h4>
            <label><input type="radio" name="sort" checked> Mới nhất</label><br>
            <label><input type="radio" name="sort"> Hoạt động gần nhất </label><br>
            <label><input type="radio" name="sort"> Điểm cao nhất </label><br>
            <label><input type="radio" name="sort"> Thường xuyên nhất</label><br>
            <label><input type="radio" name="sort"> Bounty sắp kết thúc</label><br>
            <label><input type="radio" name="sort"> Xu hướng</label><br>
            <label><input type="radio" name="sort"> Hoạt động nhiều nhất</label>
          </div>

          <div class="filter-group">
            <h4>Tagged with</h4>
            <label><input type="radio" name="tagged"> My watched tags</label><br>
            <label><input type="radio" name="tagged" checked> The following tags:</label><br>
            <input type="text" name="tag" value="<?= htmlspecialchars($_GET['tag'] ?? '') ?>" placeholder="e.g. javascript or python">

          </div>

          <div style="margin-top: 16px;">
            <button class="apply-btn">Lọc</button>
            <button class="cancel-btn">Thoát</button>
          </div>
        </div>

      </form>

      <!-- Danh sách câu hỏi -->
      <?php
      $where = [];

      if (isset($_GET['no_answers']) && $_GET['no_answers'] == '1') {
        $where[] = "q.ID_Ques NOT IN (SELECT ID_Ques FROM answers)";
      }

      if (!empty($_GET['tag'])) {
        $tag = $conn->real_escape_string($_GET['tag']);
        $where[] = "t.Name LIKE '%$tag%'";
      }

      $whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

      $sql = "SELECT q.ID_Ques, q.Mo_ta, q.Hinh_anh, t.Name AS tag_name, u.User_name
            FROM questions q
            JOIN tags t ON q.ID_Tags = t.ID_tag
            JOIN users u ON q.ID_user = u.User_ID
            $whereSql
            ORDER BY q.ID_Ques DESC";


      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="question-item">';

          echo '<a class="question-title" href="#">' . htmlspecialchars($row['Mo_ta']) . '</a>';
          echo '<div class="meta">0 votes | 0 answers | 2 views</div>';
          echo '<div class="tags">';
          echo '<span class="tag">' . htmlspecialchars($row['tag_name']) . '</span>';
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