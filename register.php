<?php
require_once 'includes/header.php';
require_once 'classes/Database.php';

if (isset($_SESSION['kullanici_id'])) {
    header("Location: dashboard.php");
    exit;
}

$hata = "";
$basari = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici_adi = trim($_POST['kullanici_adi']);
    $sifre = $_POST['sifre'];
    $sifre_tekrar = $_POST['sifre_tekrar'];

    if (empty($kullanici_adi) || empty($sifre)) {
        $hata = "Tüm alanları doldurun.";
    } elseif ($sifre !== $sifre_tekrar) {
        $hata = "Şifreler eşleşmiyor.";
    } elseif (strlen($sifre) < 6) {
        $hata = "Şifre en az 6 karakter olmalı.";
    } else {
        $db = new Database();
        $mevcut = $db->getRow("SELECT id FROM kullanicilar WHERE kullanici_adi = ?", [$kullanici_adi], "s");

        if ($mevcut) {
            $hata = "Bu kullanıcı adı zaten alınmış.";
        } else {
            $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);
            $db->query("INSERT INTO kullanicilar (kullanici_adi, sifre) VALUES (?, ?)", [$kullanici_adi, $sifre_hash], "ss");
            $basari = "Kayıt başarılı!";
        }
        $db->close();
    }
}
?>

<h4>Kayıt Ol</h4>

<?php if ($hata): ?>
    <p style="color:red;"><?= $hata ?></p>
<?php endif; ?>

<?php if ($basari): ?>
    <p style="color:green;"><?= $basari ?> <a href="login.php">Giriş yap</a></p>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Kullanıcı Adı</label>
        <input type="text" name="kullanici_adi" class="form-control">
    </div>
    <div class="mb-3">
        <label>Şifre</label>
        <input type="password" name="sifre" class="form-control">
    </div>
    <div class="mb-3">
        <label>Şifre Tekrar</label>
        <input type="password" name="sifre_tekrar" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Kayıt Ol</button>
</form>

<p><a href="login.php">Zaten hesabın var mı? Giriş yap</a></p>

<?php require_once 'includes/footer.php'; ?>