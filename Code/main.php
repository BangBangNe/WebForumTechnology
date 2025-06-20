<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Stack Overflow - Newest Questions</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6f6f6;
      margin: 0;
    }
    header {
      background-color: white;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #ccc;
    }
    .questions-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    
    .user-actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    

    .logo {
      font-weight: bold;
      font-size: 24px;
      color: #f48024;
    }

    nav a {
      margin: 0 10px;
      color: #333;
      text-decoration: none;
    }

    .search-bar {
      flex-grow: 1;
      margin: 0 20px;
    }

    .search-bar input {
      width: 100%;
      padding: 6px;
      font-size: 14px;
    }

    .user-actions {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background-color: #bbb;
    }

    .ask-btn {
      padding: 6px 12px;
      background-color: #0a95ff;
      color: white;
      border: none;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
    }

    .container-wrapper {
      display: flex;
      justify-content: center;
      padding: 20px;
    }
    
    .main-content {
      width: 100%;
      max-width: 960px; /* hoặc 900px tuỳ bạn muốn rộng cỡ nào */
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    
    .container {
      max-width: 900px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 8px;
    }

    .sidebar {
      width: 200px;
      background-color: white;
      padding: 20px;
      border-right: 1px solid #ddd;
    }


    .main-content {
      flex-grow: 1;
      padding: 20px;
    }

    .right-sidebar {
      width: 250px;
      background-color: #fdf7e2;
      padding: 20px;
      border-left: 1px solid #ddd;
    }

    .question {
      border-bottom: 1px solid #e1e1e1;
      padding: 16px 0;
    }
    .question:last-child {
      border-bottom: none;
    }
    .meta {
      font-size: 12px;
      color: #888;
      margin-bottom: 6px;
    }
    .title {
      font-size: 18px;
      color: #0074cc;
      text-decoration: none;
      font-weight: bold;
    }
    .tags {
      margin-top: 8px;
    }
    .tag {
      display: inline-block;
      background: #e1ecf4;
      color: #39739d;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      margin-right: 6px;
    }

    .filter-box {
      display: flex;
      background-color: #f8f9f9;
      padding: 16px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      gap: 40px;
    }

    .filter-group {
      flex: 1;
      min-width: 180px;
    }

    .filter-group h4 {
      margin-top: 0;
      margin-bottom: 10px;
      font-size: 14px;
      color: #333;
    }

    .filter-box input[type="text"] {
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-top: 6px;
      font-size: 13px;
    }

    .apply-btn, .cancel-btn {
      padding: 6px 12px;
      margin-right: 10px;
      border: none;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
    }

    .apply-btn {
      background-color: #0a95ff;
      color: white;
    }

    .cancel-btn {
      background-color: #e1e1e1;
    }

    .filter-toggle-btn {
      padding: 6px 12px;
      background-color: #e1ecf4;
      color: #39739d;
      border: 1px solid #7aa7c7;
      border-radius: 4px;
      font-size: 13px;
      cursor: pointer;
      margin-left: 10px;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
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

<?php include 'footer.php'; ?>
</body>

</html>
