<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'includes/db.php';
require 'includes/header.php';
require 'includes/sidebar.php';
?>

<div class="main-content">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">داشبورد کاربری</h3>
        </div>
        <div class="card-body">
            <p>خوش آمدید، <?= htmlspecialchars($_SESSION['username']) ?>!</p>
            <p>نقش شما: <?= htmlspecialchars($_SESSION['role']) ?></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>