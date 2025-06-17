<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- <link rel="stylesheet" href="style/user.css"> -->
    <style>
        body{
            margin: 10%;
        }
        .main{
            display: flex;
            justify-content: center;
            padding: 0 20px 20px 20px;
        }
        .users{
            width: 100%;
            height: 100%;
            max-width: 960px;

        }
        .tim-xep{
            display: flex;
            justify-content: space-between;
        }
        .tim-xep input{
            width: 100%;
            padding: 12px 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .sap-xep{
            display: flex;
            justify-content: space-between;
            gap: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
        }
        .sap-xep a{
            text-decoration: none;
        }
        .sap-xep span{
            padding: 10px;
            border-radius: 6px;
        }
        .sap-xep span:hover{
            background-color: #ccc;
            padding: 10px;
            border-radius: 6px;
        }
        .time{
            display: flex;
            justify-content: end;
            padding: 5px;
        }
        .time .sub-time{
            display: flex;
            gap: 20px;
            height: 25px; /* hàng dễ vỡ, đừng đụng vào height này */
        }
        .sub-time a{
            padding: 5px;
            text-decoration: none;
        }
        .sub-time a:hover{
            border-bottom: 1px solid rgb(216, 79, 79) ;
        }
        .trang-user{
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px; 
        }
        .user {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 10px;
            gap: 10px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .anh {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
            border-radius: 50%;
            overflow: hidden;
            border: 1px solid #ccc;
        }

        .anh img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
        }
        .thongtin h4{
            margin-top: 0;
            margin-bottom: 0;
        }
        .sidebar{
            padding: 20px;
        }
    </style>
</head>
<?php include 'header.php'?>
<body>
    <?php include 'nav.php'?>
    <div class="main">
        <div class="users">
            <h2>Users</h2>
                <div class="tim-xep">
                    <form><input type="text" placeholder="Tìm kiếm..." /></form>
                    <div class="sap-xep">
                        <a href=""><span>người dùng mới</span></a>
                        <a href=""><span>độ uy tín</span></a>
                        <a href=""><span>votes</span></a>
                    </div>
                    
                </div>
            <div class="time">
                <div class="sub-time">
                    <a href=""><span>tuần</span></a>
                    <a href=""><span>tháng</span></a>
                </div>
            </div>
            <div class="trang-user">
                <div class="user">
                    <div class="anh"><img src="Anh/Hina_(Dress).png" alt=""></div>
                        <div class="thongtin">
                            <h4>Hina_Dress</h4>
                            <div class="sex">Nữ</div>
                            <div class="vi-tri">Striker</div>
                            <div class="rate">8 sao</div>
                        </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Saori_(Dress).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Saori_Dress</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hanako_(Swimsuit).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Hanako_Swimsuit</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hoshino_(Battle).jpg" alt=""></div>
                    <div class="thongtin">
                        <h4>Hoshino_Battle</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hoshino_(Swimsuit).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Hoshino_Swimsuit</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Iroha.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Iroha</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Ibuki.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Ibuki</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Mika.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Mika</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Shiroko-terror.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Shiroko-terror</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Wakamo.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Wakamo</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Kisaki.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Kisaki</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Special</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Rio.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Rio</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Special</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Seia.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Seia</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hikari.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Hikari</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Nozomi.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Nozomi</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Mari_(Idol).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Mari_Idol</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hina_(Dress).png" alt=""></div>
                        <div class="thongtin">
                            <h4>Hina_Dress</h4>
                            <div class="sex">Nữ</div>
                            <div class="vi-tri">Striker</div>
                            <div class="rate">8 sao</div>
                        </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Saori_(Dress).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Saori_Dress</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hanako_(Swimsuit).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Hanako_Swimsuit</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hoshino_(Battle).jpg" alt=""></div>
                    <div class="thongtin">
                        <h4>Hoshino_Battle</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hoshino_(Swimsuit).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Hoshino_Swimsuit</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Iroha.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Iroha</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Ibuki.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Ibuki</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Mika.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Mika</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Shiroko-terror.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Shiroko-terror</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Wakamo.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Wakamo</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Kisaki.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Kisaki</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Special</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Rio.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Rio</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Special</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Seia.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Seia</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Hikari.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Hikari</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Nozomi.png" alt=""></div>
                    <div class="thongtin">
                        <h4>Nozomi</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
                <div class="user">
                    <div class="anh"><img src="Anh/Mari_(Idol).png" alt=""></div>
                    <div class="thongtin">
                        <h4>Mari_Idol</h4>
                        <div class="sex">Nữ</div>
                        <div class="vi-tri">Striker</div>
                        <div class="rate">8 sao</div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    
</body>
<?php include 'footer.php';?>
</html>