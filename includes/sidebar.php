<div class="sidebar">
    <a href="dashboard.php" class="text-center mb-3">
        <i class="fas fa-user-circle fa-3x"></i>
        <p class="mt-2"><?= htmlspecialchars($_SESSION['username']) ?></p>
    </a>
    <a href="dashboard.php"><i class="fas fa-home"></i> داشبورد</a>
    <a href="change-password.php"><i class="fas fa-key"></i> تغییر رمز عبور</a>
    <a href="edit-profile.php"><i class="fas fa-user-edit"></i> ویرایش پروفایل</a>
    <?php if ($_SESSION['role'] === 'super_admin'): ?>
        <a href="users-list.php"><i class="fas fa-users"></i> لیست کاربران</a>
    <?php endif; ?>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> خروج</a>
</div>