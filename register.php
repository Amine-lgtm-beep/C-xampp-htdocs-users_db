<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // تشفير كلمة المرور

    // التحقق مما إذا كان اسم المستخدم أو البريد الإلكتروني موجودًا مسبقًا
    $check_user = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $check_user);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "اسم المستخدم أو البريد الإلكتروني مستخدم بالفعل.";
    } else {
        $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['success'] = "تم إنشاء الحساب بنجاح.";
            header("Location: login.php"); // إعادة التوجيه إلى صفحة تسجيل الدخول
            exit();
        } else {
            $_SESSION['error'] = "خطأ في إنشاء الحساب: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب جديد</title>
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
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .error, .success {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        input[type="text"], input[type="email"], input[type="password"] {
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
        <h2>إنشاء حساب جديد</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <label>اسم المستخدم:</label><br>
            <input type="text" name="username" required><br>
            <label>البريد الإلكتروني:</label><br>
            <input type="email" name="email" required><br>
            <label>كلمة المرور:</label><br>
            <input type="password" name="password" required><br>
            <button type="submit">إنشاء الحساب</button>
        </form>
        <p>هل لديك حساب؟ <a href="login.php">تسجيل الدخول</a></p>
    </div>

</body>
</html>

