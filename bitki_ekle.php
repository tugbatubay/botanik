<?php
require_once 'includes/header.php';
require_once 'classes/Database.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

$hata = "";
$basari = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bitki_adi = trim($_POST['bitki_adi']);
    $tur_adi = trim($_POST['tur_adi']);
    $bakim_notu = trim($_POST['bakim_notu']);
    $sulama_periyodu = trim($_POST['sulama_periyodu']);

    if (empty($bitki_adi) || empty($tur_adi)) {
        $hata = "Bitki adı ve tür adı zorunludur.";
    } else {
        $db = new Database();
        $db->query(
            "INSERT INTO bitkiler (kullanici_id, bitki_adi, tur_adi, bakim_notu, sulama_periyodu) VALUES (?, ?, ?, ?, ?)",
            [$_SESSION['kullanici_id'], $bitki_adi, $tur_adi, $bakim_notu, $sulama_periyodu],
            "issss"
        );
        $db->close();
        $basari = "Bitki eklendi!";
    }
}
?>

<h4>Bitki Ekle</h4>

<?php if ($hata): ?>
    <p style="color:red;"><?= $hata ?></p>
<?php endif; ?>

<?php if ($basari): ?>
    <p style="color:green;"><?= $basari ?> <a href="bitki_listesi.php">Listeye git</a></p>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Bitki Adı</label>
        <input type="text" name="bitki_adi" class="form-control">
    </div>
    <div class="mb-3">
        <label>Tür Adı</label>
        <input type="text" name="tur_adi" class="form-control">
    </div>
    <div class="mb-3">
        <label>Bakım Notu</label>
        <textarea name="bakim_notu" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Sulama Periyodu</label>
        <input type="text" name="sulama_periyodu" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Ekle</button>
    <a href="bitki_listesi.php" class="btn btn-secondary">Geri</a>
</form>

<?php require_once 'includes/footer.php'; ?>