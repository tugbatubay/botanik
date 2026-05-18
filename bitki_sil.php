<?php
session_start();
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
$db->query("DELETE FROM bitkiler WHERE id = ? AND kullanici_id = ?", [$id, $_SESSION['kullanici_id']], "ii");
$db->close();

header("Location: bitki_listesi.php");
exit;
?>