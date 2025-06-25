<?php include 'connect.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../Style/mainPost.css">
  <title>Stack Overflow - Thảo luận</title>
</head>

<body>
  <div class="container-wrapper">
    <div class="main-content">

      <!-- Nội dung chính -->
      <div class="posts-header">
        <h2>Diễn đàn thảo luận.</h2>
        <div class="user-actions">
          <button class="ask-btn">Tạo bài viết</button>
          <button id="toggleFilterBtn" class="filter-toggle-btn">Lọc</button>
          <div class="user-avatar" title="User profile"></div>
        </div>
      </div>
      <div style="color: gray; text-align:justify;">
        <i>Nơi người dùng cùng thảo luận về các vấn đề liên quan đến công nghệ.</i>
        <!-- Đếm số lượng bài viết -->
        <?php
        $count = "SELECT p.post_id
                  FROM posts p";
        $count_ques = $conn->query($count);
        echo '<p>Hiện tại đang có ' . $count_ques->num_rows . ' câu hỏi.</p>';
        ?>
      </div>
      <br>

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
        $where[] = "p.post_id NOT IN (SELECT post_id FROM answers)";
      }

      if (!empty($_GET['tag'])) {
        $tag = $conn->real_escape_string($_GET['tag']);
        $where[] = "t.Name LIKE '%$tag%'";
      }

      $whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

      $sql = "SELECT p.post_id, p.title, p.content, t.Name AS tag_name, u.User_name
            FROM posts p
            JOIN tags t ON p.tag_id = t.ID_tag
            JOIN users u ON p.user_id = u.User_ID
            $whereSql
            ORDER BY p.post_id DESC";


      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<div class="question-item">';

          echo '<a class="question-title" href="Code/Post.php?id=' . htmlspecialchars($row['post_id']) . '">' . htmlspecialchars($row['title']) . '</a>';
          echo '<div class="meta">0 comments | 2 views</div>';
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