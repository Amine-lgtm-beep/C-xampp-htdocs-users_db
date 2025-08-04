<?php
session_start();

// التحقق إذا كان المستخدم مسجلاً دخوله
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // إعادة التوجيه إلى صفحة تسجيل الدخول إذا لم يكن المستخدم مسجلاً دخوله
    exit();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #45a049;
        }

        /* إضافة تصميم لزر الخروج */
        .logout-btn {
            background-color: #f44336;
            margin-top: 10px;
        }

        .logout-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>مرحباً، <?php echo $_SESSION['username']; ?>!</h1>
        <p>هذه الصفحة الرئيسية بعد تسجيل الدخول بنجاح.</p>
        <a href="logout.php" class="logout-btn">تسجيل الخروج</a>
    </div>

</body>
</html>

