<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (:name)");
    $stmt->execute(['name' => $name]);
    header('Location: categories.php');
}

$categories = $conn->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Manage Categories</h1>
        <form method="POST" action="categories.php">
            <div class="mb-3">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>

        <h2 class="mt-5">Existing Categories</h2>
        <ul class="list-group">
            <?php foreach ($categories as $category): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php echo htmlspecialchars($category['name']); ?>
                    <button class="btn btn-outline-secondary copy-btn" data-category-code='<script src="http://yourdomain.com//show_random_ad.php?category=<?php echo $category['id']; ?>"></script>'>Copy Script</button>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <script>
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryCode = this.getAttribute('data-category-code');
                const tempInput = document.createElement('textarea');
                tempInput.value = categoryCode;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                alert('Category script copied to clipboard!');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>