<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    $stmt = $pdo->prepare('INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)');
    $stmt->execute([$username, $password, $email, $role]);

    echo "ثبت‌نام شما با موفقیت انجام شد!";
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>ثبت‌نام</title>
</head>
<body>
    <h1>فرم ثبت‌نام</h1>
    <form method="POST">
        <label for="username">نام کاربری:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">رمز عبور:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="email">ایمیل:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="role">نقش:</label>
        <select id="role" name="role" required>
            <option value="user">کاربر عادی</option>
            <option value="employee">کارمند</option>
            <option value="admin">مدیر</option>
            <option value="super_admin">سوپر ادمین</option>
            <option value="guest">مهمان</option>
        </select><br><br>

        <button type="submit">ثبت‌نام</button>
    </form>
</body>
</html>