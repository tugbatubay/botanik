<?php
require_once 'includes/header.php';
require_once 'classes/Database.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: bitki_listesi.php");
    exit;
}

$id = (int)$_GET['id'];
$db = new Database();
$hata = "";
$basari = "";

$bitki = $db->getRow("SELECT * FROM bitkiler WHERE id = ? AND kullanici_id = ?", [$id, $_SESSION['kullanici_id']], "ii");

if (!$bitki) {
    header("Location: bitki_listesi.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bitki_adi = trim($_POST['bitki_adi']);
    $tur_adi = trim($_POST['tur_adi']);
    $bakim_notu = trim($_POST['bakim_notu']);
    $sulama_periyodu = trim($_POST['sulama_periyodu']);

    if (empty($bitki_adi) || empty($tur_adi)) {
        $hata = "Bitki adı ve tür adı zorunludur.";
    } else {
        $db->query(
            "UPDATE bitkiler SET bitki_adi=?, tur_adi=?, bakim_notu=?, sulama_periyodu=? WHERE id=? AND kullanici_id=?",
            [$bitki_adi, $tur_adi, $bakim_notu, $sulama_periyodu, $id, $_SESSION['kullanici_id']],
            "ssssii"
        );
        $basari = "Bitki güncellendi!";
        $bitki = $db->getRow("SELECT * FROM bitkiler WHERE id = ? AND kullanici_id = ?", [$id, $_SESSION['kullanici_id']], "ii");
    }
}

$db->close();
?>

<h4>Bitki Düzenle</h4>

<?php if ($hata): ?>
    <p style="color:red;"><?= $hata ?></p>
<?php endif; ?>

<?php if ($basari): ?>
    <p style="color:green;"><?= $basari ?> <a href="bitki_listesi.php">Listeye git</a></p>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Bitki Adı</label>
        <input type="text" name="bitki_adi" class="form-control" value="<?= htmlspecialchars($bitki['bitki_adi']) ?>">
    </div>
    <div class="mb-3">
        <label>Tür Adı</label>
        <input type="text" name="tur_adi" class="form-control" value="<?= htmlspecialchars($bitki['tur_adi']) ?>">
    </div>
    <div class="mb-3">
        <label>Bakım Notu</label>
        <textarea name="bakim_notu" class="form-control"><?= htmlspecialchars($bitki['bakim_notu']) ?></textarea>
    </div>
    <div class="mb-3">
        <label>Sulama Periyodu</label>
        <input type="text" name="sulama_periyodu" class="form-control" value="<?= htmlspecialchars($bitki['sulama_periyodu']) ?>">
    </div>
    <button type="submit" class="btn btn-success">Güncelle</button>
    <a href="bitki_listesi.php" class="btn btn-secondary">Geri</a>
</form>

<?php require_once 'includes/footer.php'; ?>