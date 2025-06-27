<?php
session_start();
  $current_page = basename($_SERVER['PHP_SELF']); // Lấy tên file hiện tại, ví dụ: "index.php"
include '../code/connect.php'?>


<?php
    $sql = "
    SELECT tags.Name AS tag_name, COUNT(posts.post_id) AS post_count
    FROM tags
    LEFT JOIN posts ON tags.ID_tag = posts.tag_id
    GROUP BY tags.ID_tag, tags.Name
    ORDER BY post_count DESC
    ";

    $result = $conn->query($sql);

    $labelstron = [];
    $valuestron = [];

    if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labelstron[] = $row['tag_name'];
        $valuestron[] = (int)$row['post_count'];
    }
    } else {
    $labelstron = ['Không có dữ liệu'];
    $valuestron = [0];
    }

    // Đếm bài viết theo tháng
    $sql_months = "
        SELECT 
            MONTH(created_at) AS month,
            COUNT(*) AS post_count
        FROM posts
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ";

    $result_months = $conn->query($sql_months);

    $labelscot = [];
    $valuescot = [];

    $month_names = [
        1 => 'Tháng 1', 2 => 'Tháng 2', 3 => 'Tháng 3', 4 => 'Tháng 4',
        5 => 'Tháng 5', 6 => 'Tháng 6', 7 => 'Tháng 7', 8 => 'Tháng 8',
        9 => 'Tháng 9', 10 => 'Tháng 10', 11 => 'Tháng 11', 12 => 'Tháng 12'
    ];

    if ($result_months && $result_months->num_rows > 0) {
        while ($row = $result_months->fetch_assoc()) {
            $month_num = (int)$row['month'];
            $labelscot[] = $month_names[$month_num];
            $valuescot[] = (int)$row['post_count'];
        }
    } else {
        $labelscot = ['Không có dữ liệu'];
        $valuescot = [0];
    }

    if (!isset($_SESSION['Admin_ID'])) {
        header("Location: admin_login.php");
        exit();
    }


?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".sidebar li").forEach(item => {
        item.addEventListener("click", function () {
        const url = this.getAttribute("data-url");

        fetch(url)
            .then(res => res.text())
            .then(html => {
            document.getElementById("content-area").innerHTML = html;

            document.querySelectorAll(".sidebar li").forEach(li => li.classList.remove("active"));
            this.classList.add("active");
            })
            .catch(err => {
            document.getElementById("content-area").innerHTML = "<p>Không thể tải nội dung</p>";
            console.error(err);
            });
        });
    });
    });
</script>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    body, html {
        font-family: Arial, sans-serif;
        height: 100%;
    }

    .topbar {
        background: #1e1e2d;
        color: #fff;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .topbar .left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .topbar .left button {
        background: #4f46e5;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }
    .right{
        display: flex;
        gap: 20px;
    }

    .main {
        display: flex;
        height: calc(100vh - 50px);
    }

    .sidebar {
        background-color: rgb(29, 27, 39);
        width: 220px;
        padding: 20px 0;
    }

    .sidebar ul {
        list-style: none;
    }

    .sidebar li {
        padding: 12px 20px;
        cursor: pointer;
        color: aliceblue;
    }


    .sidebar li:hover {
        background-color: rgba(255, 255, 255, 0.1);   
    }

    .content {
        flex: 1;
        padding: 30px;
        background-color: #f4f4f4;
    }
    .sidebar li.active {
        background-color: #4f46e5; /* Màu nền nổi bật */
        color: white;
        font-weight: bold;
    }

  </style>
</head>
<body>
    <div class="topbar">
        <div class="left">
            <strong>Dashboard</strong>
            <button>Nâng cấp</button>
            <button>Tạo mới</button>
        </div>
        <div class="right">
            <span>xem trang web</span>
            <span>Hello  <?php echo htmlspecialchars($_SESSION['Admin_Name']);?></span>
        </div>
    </div>
        
    <div class="main">
        <div class="sidebar">
        <ul>
            <li class="active" data-url="tongquan.php">Tổng quan</li>
            <li data-url="baiviet.php">Bài viết</li>
            <li data-url="cauhoi.php">Câu hỏi</li>
            <li data-url="binhluan.php">Bình luận</li>
            <li data-url="phanhoi.php">Phản hồi</li>
            <li data-url="thanhvien.php">Thành viên</li>
        </ul>
        </div>
        <div class="content" id="content-area">
            <?php
                $page = $_GET['page'] ?? 'tongquan';
                $allowed_pages = ['tongquan', 'baiviet', 'binhluan', 'phanhoi', 'thanhvien','cauhoi.php'];

                if (in_array($page, $allowed_pages)) {
                    include $page . '.php';
                } else {
                    echo "<p>Trang không hợp lệ.</p>";
                }
            ?>
        </div>
    </div>

</body>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".sidebar li").forEach(item => {
            item.addEventListener("click", function () {
            const url = this.getAttribute("data-url");

            fetch(url)
                .then(res => res.text())
                .then(html => {
                const contentArea = document.getElementById("content-area");
                contentArea.innerHTML = html;

                document.querySelectorAll(".sidebar li").forEach(li => li.classList.remove("active"));
                this.classList.add("active");

                // ✅ Nếu nội dung có thẻ canvas với id là barChart thì vẽ lại biểu đồ
                if (url === "tongquan.php" && document.getElementById("barChart")) {
                    drawChart();
                }
                })
                .catch(err => {
                document.getElementById("content-area").innerHTML = "<p>Không thể tải nội dung</p>";
                console.error(err);
                });
            });
        });
        });

        // ✅ Hàm vẽ biểu đồ Chart.js
        function drawChart() {
    const pieLabels = <?= json_encode($labelstron); ?>;
    const pieValues = <?= json_encode($valuestron); ?>;
    const barLabels = <?= json_encode($labelscot); ?>;
    const barValues = <?= json_encode($valuescot); ?>;

    const barCtx = document.getElementById("barChart")?.getContext("2d");
    const pieCtx = document.getElementById("pieChart")?.getContext("2d");

    if (barCtx) {
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Số bài viết theo tháng',
                    data: barValues,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Thống kê số bài viết theo tháng'
                    }
                }
            }
        });
    }

    if (pieCtx) {
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Thẻ tags',
                    data: pieValues,
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                        '#9966FF', '#FF9F40', '#66FF66', '#FF6666', '#C03931'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Số lượng tags trong bài viết'
                    }
                }
            }
        });
    }
}

    </script>
    
</html>
