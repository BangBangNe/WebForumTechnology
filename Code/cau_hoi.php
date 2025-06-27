<?php

// Nếu chưa đăng nhập thì chuyển về trang đăng nhập
if (!isset($_SESSION['User_ID'])) {
    header("Location: signInUP.php");
    exit();
}

include 'connect.php';

$ID_user = $_SESSION['User_ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mo_ta = $conn->real_escape_string($_POST['mo_ta']);
    $id_tag = (int)$_POST['id_tag'];

    $hinh_anh = null;
    if (!empty($_FILES['hinh_anh']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        $file_name = basename($_FILES['hinh_anh']['name']);
        $target_file = $target_dir . time() . "_" . $file_name;
        move_uploaded_file($_FILES["hinh_anh"]["tmp_name"], $target_file);
        $hinh_anh = $target_file;
    }

    $sql = "INSERT INTO questions (Date_tao, Mo_ta, Hinh_anh, ID_Tags, ID_user, like_count)
            VALUES (CURDATE(), '$mo_ta', " . ($hinh_anh ? "'$hinh_anh'" : "NULL") . ", $id_tag, $ID_user, 0)";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt câu hỏi</title>
    <link rel="stylesheet" href="../Style/main.css">
    <style>
        body {
            background-color: #f1f2f3;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #232629;
        }
        
        .container-wrapper {
            margin: 0 auto;
            display: flex;
            justify-content: center;
        }
        
        .form-container {
            background: white;
            border-radius: 5px;
            padding: 24px;
            width: 100%;
            max-width: 800px;
        }
        
        .form-container h2 {
            font-size: 22px;
            margin-bottom: 20px;
            font-weight: 600;
            color: #242729;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 15px;
        }
        
        textarea, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #bbc0c4;
            border-radius: 3px;
            font-size: 14px;
            transition: border-color 0.15s ease-in-out;
        }
        
        textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        textarea:focus, select:focus {
            border-color: #6cbbf7;
            outline: none;
            box-shadow: 0 0 0 4px rgba(0, 149, 255, 0.15);
        }
        
        .file-input {
            margin-top: 8px;
        }
        
        .submit-btn {
            background-color: #0a95ff;
            color: white;
            border: none;
            padding: 10px 12px;
            border-radius: 3px;
            font-size: 13px;
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }
        
        .submit-btn:hover {
            background-color: #0077cc;
        }
        
        .form-footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e4e6e8;
            font-size: 13px;
            color: #6a737c;
        }
        
        @media (max-width: 768px) {
            .container-wrapper {
                padding: 10px;
            }
            
            .form-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <div class="form-container">
            <h2>Đặt câu hỏi mới</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="mo_ta">Mô tả câu hỏi</label>
                    <textarea id="mo_ta" name="mo_ta" required placeholder="Nhập chi tiết câu hỏi của bạn..."></textarea>
                </div>
                
                <div class="form-group">
                    <label for="id_tag">Thẻ (Tag)</label>
                    <select id="id_tag" name="id_tag" required>
                        <option value="">-- Chọn thẻ --</option>
                        <?php
                        $tag_q = $conn->query("SELECT * FROM tags");
                        while ($tag = $tag_q->fetch_assoc()) {
                            echo '<option value="' . $tag['ID_tag'] . '">' . htmlspecialchars($tag['Name']) . '</option>';
                        }
                        ?>
                    </select>
                    <small>Chọn thẻ phù hợp với chủ đề câu hỏi của bạn</small>
                </div>
                
                <div class="form-group">
                    <label>Hình ảnh minh họa (nếu có)</label>
                    <input type="file" name="hinh_anh" accept="image/*" class="file-input">
                </div>
                
                <button type="submit" class="submit-btn">Đăng câu hỏi</button>
            </form>
            
            <div class="form-footer">
                <p>Bằng cách đăng câu hỏi, bạn đồng ý với <a href="#">điều khoản sử dụng</a> và <a href="#">chính sách bảo mật</a> của chúng tôi.</p>
            </div>
        </div>
    </div>
</body>
</html>