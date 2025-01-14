<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // دریافت اطلاعات کاربر
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    // بررسی رمز عبور فعلی
    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            // هش کردن رمز عبور جدید
            $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

            // به‌روزرسانی رمز عبور در دیتابیس
            $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
            $stmt->execute([$new_password_hash, $_SESSION['user_id']]);

            $success = "رمز عبور با موفقیت تغییر کرد!";
        } else {
            $error = "رمز عبور جدید و تکرار آن مطابقت ندارند!";
        }
    } else {
        $error = "رمز عبور فعلی اشتباه است!";
    }
}

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<div class="main-content">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">تغییر رمز عبور</h3>
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label for="current_password" class="form-label">رمز عبور فعلی</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">رمز عبور جدید</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">تکرار رمز عبور جدید</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary">تغییر رمز عبور</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>