<?php
require_once 'includes/header.php';
require_once 'classes/Database.php';

if (isset($_SESSION['kullanici_id'])) {
    header("Location: dashboard.php");
    exit;
}

$hata = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kullanici_adi = trim($_POST['kullanici_adi']);
    $sifre = $_POST['sifre'];

    if (empty($kullanici_adi) || empty($sifre)) {
        $hata = "Tüm alanları doldurun.";
    } else {
        $db = new Database();
        $kullanici = $db->getRow("SELECT * FROM kullanicilar WHERE kullanici_adi = ?", [$kullanici_adi], "s");

        if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
            $_SESSION['kullanici_id'] = $kullanici['id'];
            $_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];
            header("Location: dashboard.php");
            exit;
        } else {
            $hata = "Kullanıcı adı veya şifre hatalı.";
        }
        $db->close();
    }
}
?>

<h4>Giriş Yap</h4>

<?php if ($hata): ?>
    <p style="color:red;"><?= $hata ?></p>
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
    <button type="submit" class="btn btn-success">Giriş Yap</button>
</form>

<p><a href="register.php">Hesabın yok mu? Kayıt ol</a></p>

<?php require_once 'includes/footer.php'; ?>