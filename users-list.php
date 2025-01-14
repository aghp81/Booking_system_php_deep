<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'super_admin') {
    header('Location: login.php');
    exit;
}

require 'includes/db.php';
require 'includes/jdf.php'; // فراخوانی کتابخانه تبدیل تاریخ

// دریافت لیست همه کاربران
$stmt = $pdo->query('SELECT * FROM users');
$users_list = $stmt->fetchAll();

require 'includes/header.php';
require 'includes/sidebar.php';
?>

<div class="main-content">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">لیست کاربران</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام کاربری</th>
                            <th>ایمیل</th>
                            <th>نقش</th>
                            <th>تاریخ ثبت‌نام (شمسی)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users_list as $user): ?>
                            <?php
                            // تبدیل تاریخ میلادی به شمسی
                            $gregorian_date = strtotime($user['created_at']);
                            $jalali_date = jdate('Y/m/d H:i:s', $gregorian_date);
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['username']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($jalali_date) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>