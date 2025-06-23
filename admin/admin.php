<?php
  $current_page = basename($_SERVER['PHP_SELF']); // Lấy tên file hiện tại, ví dụ: "index.php"
?>
<?php
//dữ liệu từ database
$labels = ['Tháng 1', 'Tháng 2', 'Tháng 3'];
$values = [8000, 200, 150];
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
            <span>Hello phamhoanglong</span>
        </div>
    </div>
        
    <div class="main">
        <div class="sidebar">
        <ul>
            <li class="active" data-url="tongquan.php">Tổng quan</li>
            <li data-url="thongke.php">Thống kê</li>
            <li data-url="baiviet.php">Bài viết</li>
            <li data-url="binhluan.php">Bình luận</li>
            <li data-url="phanhoi.php">Phản hồi</li>
            <li data-url="thanhvien.php">Thành viên</li>
        </ul>
        </div>
        <div class="content" id="content-area">
            <?php include 'tongquan.php'; ?>
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
                if (url === "thongke.php" && document.getElementById("barChart")) {
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
            const labels = <?= json_encode($labels); ?>;
            const values = <?= json_encode($values); ?>;

            const barCtx = document.getElementById("barChart")?.getContext("2d");
            const pieCtx = document.getElementById("pieChart")?.getContext("2d");

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Doanh thu',
                    data: values,
                    backgroundColor: 'rgba(255, 159, 64, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }]
            };

            if (barCtx) {
                new Chart(barCtx, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Doanh thu theo tháng'
                            }
                        }
                    }
                });
            }

            if (pieCtx) {
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Tỷ lệ doanh thu',
                            data: values,
                            backgroundColor: [
                                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                '#9966FF', '#FF9F40', '#66FF66', '#FF6666'
                            ]
                            
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Tỷ lệ doanh thu các tháng'
                            }
                        }
                    }
                });
            }
        }
    </script>
</html>
