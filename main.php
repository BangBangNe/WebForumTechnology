<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="Style/main.css">
  <link rel="stylesheet" href="Style/nav.css">
  <link rel="stylesheet" href="Style/header.css">
  <title>Stack Overflow - Newest Questions</title>
</head>
<body>
<header> <?php include 'Code/header.php'; ?> </header>

  <div class="container-wrapper">
    <nav class="navigate"> <?php include 'Code/nav.php'; ?> </nav>
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
      <div id="filterBox" class="filter-box" style="display: none;">
        <div class="filter-group">
          <h4>Filter by</h4>
          <label><input type="checkbox"> No answers</label><br>
          <label><input type="checkbox"> No accepted answer</label><br>
          <label><input type="checkbox"> No Staging Ground</label><br>
          <label><input type="checkbox"> Has bounty</label><br>
          <input type="text" placeholder="Days old" style="width: 80px; margin-top: 4px;">
        </div>

        <div class="filter-group">
          <h4>Sorted by</h4>
          <label><input type="radio" name="sort" checked> Newest</label><br>
          <label><input type="radio" name="sort"> Recent activity</label><br>
          <label><input type="radio" name="sort"> Highest score</label><br>
          <label><input type="radio" name="sort"> Most frequent</label><br>
          <label><input type="radio" name="sort"> Bounty ending soon</label><br>
          <label><input type="radio" name="sort"> Trending</label><br>
          <label><input type="radio" name="sort"> Most activity</label>
        </div>

        <div class="filter-group">
          <h4>Tagged with</h4>
          <label><input type="radio" name="tagged"> My watched tags</label><br>
          <label><input type="radio" name="tagged" checked> The following tags:</label><br>
          <input type="text" placeholder="e.g. javascript or python">
        </div>

        <div style="margin-top: 16px;">
          <button class="apply-btn">Apply filter</button>
          <button class="cancel-btn">Cancel</button>
        </div>
      </div>

      <!-- Danh sách câu hỏi -->
      <div class="question">
        <div class="meta">0 votes | 0 answers | 2 views</div>
        <a href="#" class="title">Selenium with Chrome user profile not loading WhatsApp Web URL, but works in CMD</a>
        <div class="tags">
          <span class="tag">python</span>
          <span class="tag">selenium-webdriver</span>
        </div>
      </div>
  
      <div class="question">
        <div class="meta">0 votes | 0 answers | 2 views</div>
        <a href="#" class="title">com.sun.xml.internal.ws.fault.ServerSOAPFaultException BusClient</a>
        <div class="tags">
          <span class="tag">soap-client</span>
          <span class="tag">java-web-start</span>
        </div>
      </div>
  
      <div class="question">
        <div class="meta">0 votes | 0 answers | 2 views</div>
        <a href="#" class="title">I want to connect elFinder library with OneDrive</a>
        <div class="tags">
          <span class="tag">php</span>
          <span class="tag">wordpress</span>
          <span class="tag">plugins</span>
        </div>

      </div>


    </div>
  </div>


  <script>
    document.getElementById("toggleFilterBtn").addEventListener("click", function () {
      var filterBox = document.getElementById("filterBox");
      if (filterBox.style.display === "none") {
        filterBox.style.display = "flex";
      } else {
        filterBox.style.display = "none";
      }
    });
  </script>

<footer><?php include 'Code/footer.php'; ?></footer>

</body>

</html>
