<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: list_ads.php');
    exit;
}

$ad_id = $_GET['id'];

// Fetch ad details
$stmt = $conn->prepare("SELECT * FROM ads WHERE id = :id");
$stmt->execute(['id' => $ad_id]);
$ad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ad) {
    header('Location: list_ads.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $link = $_POST['link'];
    $image_path = $ad['image_path'];

    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "/uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;
    }

    $stmt = $conn->prepare("UPDATE ads SET category_id = :category_id, image_path = :image_path, link = :link, title = :title, description = :description WHERE id = :id");
    $stmt->execute([
        'category_id' => $category_id,
        'image_path' => $image_path,
        'link' => $link,
        'title' => $title,
        'description' => $description,
        'id' => $ad_id,
    ]);

    header('Location: list_ads.php');
}

$categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class="container mt-5">
        <h1>Edit Ad</h1>
        <form method="POST" action="edit_ad.php?id=<?php echo $ad['id']; ?>" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php if ($ad['category_id'] == $category['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($ad['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($ad['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="link" class="form-label">Link</label>
                <input type="text" id="link" name="link" class="form-control" value="<?php echo htmlspecialchars($ad['link']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image" class="form-control">
                <img src="<?php echo $ad['image_path']; ?>" alt="Ad Image" class="mt-3" width="150">
            </div>
            <button type="submit" class="btn btn-primary">Update Ad</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>