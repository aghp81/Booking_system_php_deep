<?php
session_start();
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header('Location: dashboard.php');
        exit;
    } else {
        echo "نام کاربری یا رمز عبور اشتباه است!";
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ورود</title>
</head>
<body>
    <h1>فرم ورود</h1>
    <form method="POST">
        <label for="username">نام کاربری:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">رمز عبور:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">ورود</button>
    </form>
</body>
</html>