<?php
require_once 'includes/header.php';

if (isset($_SESSION['kullanici_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="text-center">Botanik Bahçesi Yönetim Sistemi</h3>
            <p class="text-center text-muted">Hoş geldiniz</p>
            <div class="d-grid gap-2 mt-3">
                <a href="login.php" class="btn btn-success">Giriş Yap</a>
                <a href="register.php" class="btn btn-outline-success">Kayıt Ol</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>