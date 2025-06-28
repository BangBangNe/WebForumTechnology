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
          <button class="ask-btn" onclick="location.href='index.php?page=bai_post'">Tạo bài viết</button>
          <button id="toggleFilterBtn" class="filter-toggle-btn">Lọc</button>
        </div>
      </div>
      <div style="color: gray; text-align:justify;">
        <i>Nơi người dùng cùng thảo luận về các vấn đề liên quan đến công nghệ.</i>
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
      $orderBy = "p.post_id DESC"; // mặc định: mới nhất

      // Lọc: không có câu trả lời (giả sử comment là bảng chứa trả lời)
      if (isset($_GET['answer_filter']) && $_GET['answer_filter'] === 'has') {
        $where[] = "p.post_id IN (SELECT DISTINCT post_id FROM post_comments)";
      } elseif (isset($_GET['answer_filter']) && $_GET['answer_filter'] === 'none') {
        $where[] = "p.post_id NOT IN (SELECT DISTINCT post_id FROM post_comments)";
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
            $orderBy = "p.post_id ASC";
            break;
          default:
            $orderBy = "p.post_id DESC";
        }
      }

      $whereSql = count($where) ? "WHERE " . implode(" AND ", $where) : "";

      $sql = "SELECT p.post_id, p.title, p.content, p.created_at, t.Name AS tag_name, u.User_name
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
          echo '<div class="meta">'.htmlspecialchars($row['created_at']).'</div>';  
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