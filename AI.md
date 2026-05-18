# AI.md - Yapay Zeka Bildiri Kısmı

Bu projede Claude, ChatGPT, Gemini yapay zeka araçlarından yardım aldım.

---

## Soru 1

**Ben:** php de veritabanı bağlantısı nasıl yapılıyo

**Claude:** mysqli kullanabilirsin, şöyle bir bağlantı kodu yaz:

$conn = new mysqli("localhost", "root", "", "botanik");

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

---

## Soru 2

**Ben:** şifreyi direk kaydetme dedi hoca ne yapacam

**ChatGPT:** password_hash kullanman lazım:

$sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

Bunu veritabanına kaydet. Giriş yaparken de password_verify ile kontrol et:

if (password_verify($sifre, $kullanici['sifre'])) {
    // giriş başarılı
}

---

## Soru 3

**Ben:** prepared statement nedir nasıl kullanıyom

**Claude:** Şöyle kullanıyorsun, soru işareti koyuyorsun verinin yerine,
sonra bind_param ile veriyorsun:

$stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
$stmt->bind_param("s", $kullanici_adi);
$stmt->execute();
$result = $stmt->get_result();
$kullanici = $result->fetch_assoc();

s harfi string demek, i olsa integer demek oluyor.

---

## Soru 4

**Ben:** session kullanımı nasıl hoca çerez kullanma dedi ya

**Claude:** session_start() yazman lazım sayfanın en üstüne, sonra şöyle kullanıyorsun:

session_start();
$_SESSION['kullanici_id'] = $kullanici['id'];
$_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];

Çıkış yaparken:

session_start();
session_destroy();
header("Location: login.php");

---

## Soru 5

**Ben:** giriş yapmadan sayfaya girmesin nasıl yapıcam

**Gemini:** Her korumalı sayfanın en üstüne şunu ekle:

if (!isset($_SESSION['kullanici_id'])) {
    header("Location: login.php");
    exit;
}

---

## Soru 6

**Ben:** insert sorgusu nasıldı ya hatırlamıyorum

**Gemini:** Prepared statement ile şöyle yazıyorsun:

$stmt = $conn->prepare("INSERT INTO bitkiler (kullanici_id, bitki_adi, tur_adi, bakim_notu, sulama_periyodu) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("issss", $kullanici_id, $bitki_adi, $tur_adi, $bakim_notu, $sulama_periyodu);
$stmt->execute();

---

## Soru 7

**Ben:** başka kullanıcının bitkisini silemesin diye ne yapmalıyım

**Claude:** Silme sorgusuna kullanici_id şartı ekle:

$stmt = $conn->prepare("DELETE FROM bitkiler WHERE id = ? AND kullanici_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['kullanici_id']);
$stmt->execute();

Böylece kendi bitkisi değilse silemiyor.

---

## Soru 8

**Ben:** update sorgusu nasıl yazılıyo

**ChatGPT:** WHERE şartını unutma, hangi bitkiyi güncelleyeceğini belirtmen lazım:

$stmt = $conn->prepare("UPDATE bitkiler SET bitki_adi=?, tur_adi=?, bakim_notu=?, sulama_periyodu=? WHERE id=? AND kullanici_id=?");
$stmt->bind_param("ssssii", $bitki_adi, $tur_adi, $bakim_notu, $sulama_periyodu, $id, $_SESSION['kullanici_id']);
$stmt->execute();

---

## Soru 9

**Ben:** bootstrapu nasıl eklicem indirmem mi lazım

**ChatGPT:** İndirmene gerek yok, head kısmına şunu ekle:

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

Tablo için table table-bordered,
butonlar için btn btn-success gibi classlar kullanıyorsun.

---

## Soru 10

**Ben:** düzenleme sayfasında eski bilgiler formda gözüksün nasıl yapıcam

**Claude:** Önce veritabanından o bitkiyi çek, sonra input un value kısmına yaz:

$stmt = $conn->prepare("SELECT * FROM bitkiler WHERE id = ? AND kullanici_id = ?");
$stmt->bind_param("ii", $id, $_SESSION['kullanici_id']);
$stmt->execute();
$bitki = $stmt->get_result()->fetch_assoc();

Sonra formda:

<input type="text" name="bitki_adi" value="<?= htmlspecialchars($bitki['bitki_adi']) ?>">

---

## Soru 11

**Ben:** htmlspecialchars ne ya neden kullanıyoruz

**Claude:** Kullanıcının girdiği veriyi ekrana basarken güvenli hale getiriyor.
Mesela biri input a script etiketi yazarsa düz metin olarak gösteriyor, çalıştırmıyor.
Ekrana kullanıcı verisi basacağın her yerde kullanman iyi olur.

---

## Soru 12

**Ben:** php de form dan gelen veriyi nasıl alıyorum

**Claude:** $_POST ile alıyorsun, form method POST olmalı:

$bitki_adi = $_POST['bitki_adi'];

Güvenli kullanmak için trim da ekleyebilirsin:

$bitki_adi = trim($_POST['bitki_adi']);

trim baştaki ve sondaki boşlukları temizliyor.

---

## Soru 13

**Ben:** veritabanından tüm kayıtları çekmek için ne yazıyorum

**Gemini:** fetch_all kullanıyorsun, döngüyle de ekrana basıyorsun:

$stmt = $conn->prepare("SELECT * FROM bitkiler WHERE kullanici_id = ?");
$stmt->bind_param("i", $_SESSION['kullanici_id']);
$stmt->execute();
$bitkiler = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

foreach ($bitkiler as $bitki) {
    echo $bitki['bitki_adi'];
}