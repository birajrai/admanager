<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: /login.php');
    exit;
}

$ads = $conn->query("SELECT ads.*, categories.name as category_name FROM ads JOIN categories ON ads.category_id = categories.id")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ads List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../navbar.php'; ?>
    <div class="container mt-5">
        <h1>Ads List</h1>
        <div class="row">
            <?php foreach ($ads as $ad): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($ad['image_path']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($ad['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($ad['title']); ?> (<?php echo htmlspecialchars($ad['category_name']); ?>)</h5>
                            <p class="card-text"><?php echo htmlspecialchars($ad['description']); ?></p>
                            <a href="<?php echo htmlspecialchars($ad['link']); ?>" class="btn btn-primary" target="_blank">Visit Link</a>
                            <button class="btn btn-outline-secondary mt-3 copy-btn" data-ad-code='<a href="<?php echo htmlspecialchars($ad['link']); ?>" target="_blank"><img src="<?php echo htmlspecialchars($ad['image_path']); ?>" alt="<?php echo htmlspecialchars($ad['title']); ?>"></a>'>Copy HTML Code</button>
                            <a href="edit_ad.php?id=<?php echo $ad['id']; ?>" class="btn btn-warning mt-3">Edit</a>
                            <a href="delete_ad.php?id=<?php echo $ad['id']; ?>" class="btn btn-danger mt-3" onclick="return confirm('Are you sure you want to delete this ad?');">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function() {
                const adCode = this.getAttribute('data-ad-code');
                const tempInput = document.createElement('textarea');
                tempInput.value = adCode;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                alert('Ad code copied to clipboard!');
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>