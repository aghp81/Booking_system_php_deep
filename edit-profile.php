<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'includes/db.php';

$error = '';
$success = '';

// دریافت اطلاعات کاربر فعلی
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // بررسی تکراری نبودن نام کاربری
    if ($username !== $user['username']) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $error = 'نام کاربری قبلاً استفاده شده است!';
        }
    }

    // بررسی تکراری نبودن ایمیل
    if ($email !== $user['email']) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'ایمیل قبلاً استفاده شده است!';
        }
    }

    // بررسی تکراری نبودن شماره موبایل
    if ($phone !== $user['phone']) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE phone = ?');
        $stmt->execute([$phone]);
        if ($stmt->fetch()) {
            $error = 'شماره موبایل قبلاً استفاده شده است!';
        }
    }

    // اگر خطایی وجود نداشت، اطلاعات کاربر رو به‌روزرسانی کن
    if (empty($error)) {
        $stmt = $pdo->prepare('UPDATE users SET username = ?, email = ?, phone = ? WHERE id = ?');
        $stmt->execute([$username, $email, $phone, $_SESSION['user_id']]);

        $success = 'اطلاعات شما با موفقیت به‌روزرسانی شد!';
        // به‌روزرسانی اطلاعات کاربر در session
        $_SESSION['username'] = $username;
        // دریافت اطلاعات به‌روزرسانی شده
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
    }
}

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<div class="main-content">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">ویرایش پروفایل</h3>
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
                    <label for="username" class="form-label">نام کاربری</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">ایمیل</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">شماره موبایل</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>