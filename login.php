<?php
session_start();
include('db_config.php');

// التحقق مما إذا كان المستخدم قد سجل الدخول مسبقًا
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // إعادة التوجيه إلى الصفحة الرئيسية إذا كان المستخدم مسجلاً دخوله
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // استعلام للتحقق من وجود المستخدم
    $select_query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $select_query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php"); // إعادة التوجيه إلى الصفحة الرئيسية بعد تسجيل الدخول بنجاح
            exit();
        } else {
            $_SESSION['error'] = "كلمة المرور غير صحيحة.";
        }
    } else {
        $_SESSION['error'] = "اسم المستخدم غير موجود.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            font-size: 14px;
            color: #555;
            margin-top: 20px;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>تسجيل الدخول</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <label>اسم المستخدم:</label><br>
            <input type="text" name="username" required><br>
            <label>كلمة المرور:</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">دخول</button>
        </form>
        <p>ليس لديك حساب؟ <a href="register.php">إنشاء حساب جديد</a></p>
    </div>

</body>
</html>
