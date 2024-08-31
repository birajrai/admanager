<?php
session_start();
require_once '/db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login.php');
    exit;
}

if (isset($_GET['id'])) {
    $stmt = $conn->prepare("DELETE FROM ads WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
}

header('Location: list_ads.php');
exit;
?>
