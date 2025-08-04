<?php
session_start();

// تدمير الجلسة عند تسجيل الخروج
session_unset();
session_destroy();

header("Location: login.php"); // إعادة التوجيه إلى صفحة تسجيل الدخول
exit();
?>
