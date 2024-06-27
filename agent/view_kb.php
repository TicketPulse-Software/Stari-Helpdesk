<?php
include_once '../includes/auth.php';
include_once '../includes/knowledgebase.php';
check_login();

$articles = get_kb_articles();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Knowledge Base</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Knowledge Base</h1>
    <div class="list-group">
        <?php foreach ($articles as $article): ?>
            <a href="view_kb_article.php?id=<?= $article['id'] ?>" class="list-group-item list-group-item-action">
                <?= $article['title'] ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
