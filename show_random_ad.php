<?php
require_once 'db.php';

$category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

if ($category_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM ads WHERE category_id = :category_id ORDER BY RAND() LIMIT 1");
    $stmt->execute(['category_id' => $category_id]);
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ad) {
        echo '<a href="' . htmlspecialchars($ad['link']) . '" target="_blank"><img src="' . htmlspecialchars($ad['image_path']) . '" alt="' . htmlspecialchars($ad['title']) . '"></a>';
    } else {
        echo 'No ads available.';
    }
}
