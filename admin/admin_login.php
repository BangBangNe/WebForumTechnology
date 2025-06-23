<?php
$loginError = isset($_GET['error']) ? $_GET['error'] : '';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../Style/StyleAdmin.css">
</head>
<body>
    <div class="container">
        <form action="admins.php" method="POST">
            <h1>Admin Login</h1>
            <p>Sử dụng tài khoản admin của bạn để đăng nhập</p>
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <?php if ($loginError): ?>
                <p class="error-message">Invalid login. Please try again.</p>
            <?php endif; ?>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
