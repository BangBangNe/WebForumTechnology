<?php $loginError = isset($_GET['error']) ? $_GET['error'] : ''; ?>

<html>
<head>
    <title>Sign In/Up Form</title>
    <link rel="stylesheet" type="text/css" href="../Style/StyleSignInUp.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form action="signin.php" method="POST">
                <h1>Đăng Nhập</h1>
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Mật khẩu" required />
                <button type="submit" class="signup-btn">Đăng Nhập</button><br>
                <span>Chưa có tài khoản? <a href="#" id="signUp">Đăng ký</a></span>
            </form>
        </div>
        <div class="form-container sign-up-container">
            <form action="signup.php" method="POST">
                <h1>Đăng Ký</h1>
                <input type="text" name="name" placeholder="Name" required />
                <input type="email" name="email" placeholder="Email" required />
                <input type="password" name="password" placeholder="Mật khẩu" required />
                <button type="submit" class="signup-btn">Đăng Ký</button><br>
                <span>Đã có tài khoản? <a href="#" id="signIn">Đăng nhập</a></span>
            </form>
             </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Chào mừng bạn đã trở lại!</h1>
                    <p>Bạn đã có tài khoản? Đăng nhập ngay thôi.</p>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Chào bạn!</h1>
                    <p>Bạn chưa có tài khoản? Hãy đăng ký ngay để có những trải nghiệm tốt nhất!</p>
                </div>
            </div>
        </div>
        </div>
    </div>
    <?php if ($loginError): ?>
        <p style="color:red; text-align:center;"><?php echo $loginError; ?></p>
    <?php endif; ?>
    <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');

        signUpButton.addEventListener('click', () => container.classList.add('right-panel-active'));
        signInButton.addEventListener('click', () => container.classList.remove('right-panel-active'));
    </script>
</body>
</html>