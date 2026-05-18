<?php
require_once 'includes/header.php';
require_once 'classes/Database.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$toplam = $db->getRow("SELECT COUNT(*) as sayi FROM bitkiler WHERE kullanici_id = ?", [$_SESSION['kullanici_id']], "i");
$db->close();
?>

<h4>Hoş geldin, <?= htmlspecialchars($_SESSION['kullanici_adi']) ?>!</h4>
<p>Toplam kayıtlı bitki sayısı: <?= $toplam['sayi'] ?></p>

<a href="bitki_ekle.php" class="btn btn-success">Bitki Ekle</a>
<a href="bitki_listesi.php" class="btn btn-secondary">Bitkilerimi Gör</a>
<a href="logout.php" class="btn btn-danger">Çıkış Yap</a>

<?php require_once 'includes/footer.php'; ?>