<?php
require_once 'includes/header.php';
require_once 'classes/Database.php';

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$bitkiler = $db->getRows("SELECT * FROM bitkiler WHERE kullanici_id = ? ORDER BY eklenme_tarihi DESC", [$_SESSION['kullanici_id']], "i");
$db->close();
?>

<h4>Bitkilerim</h4>
<a href="bitki_ekle.php" class="btn btn-success mb-3">Yeni Bitki Ekle</a>

<?php if (empty($bitkiler)): ?>
    <p>Henüz bitki eklemedin.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Bitki Adı</th>
                <th>Tür Adı</th>
                <th>Sulama Periyodu</th>
                <th>Bakım Notu</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bitkiler as $i => $bitki): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($bitki['bitki_adi']) ?></td>
                <td><?= htmlspecialchars($bitki['tur_adi']) ?></td>
                <td><?= htmlspecialchars($bitki['sulama_periyodu']) ?></td>
                <td><?= htmlspecialchars($bitki['bakim_notu']) ?></td>
                <td>
                    <a href="bitki_duzenle.php?id=<?= $bitki['id'] ?>" class="btn btn-sm btn-primary">Düzenle</a>
                    <a href="bitki_sil.php?id=<?= $bitki['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğine emin misin?')">Sil</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>