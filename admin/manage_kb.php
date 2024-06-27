<?php
include_once '../includes/auth.php';
include_once '../includes/knowledgebase.php';
check_login();

if ($_SESSION['role'] !== 'admin') {
    header('Location: /public/login.php');
    exit();
}

$articles = get_kb_articles();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Knowledge Base</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Manage Knowledge Base</h1>
    <a href="add_kb_article.php" class="btn btn-primary mb-3">Add Article</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= $article['id'] ?></td>
                    <td><?= $article['title'] ?></td>
                    <td>
                        <a href="edit_kb_article.php?id=<?= $article['id'] ?>" class="btn btn-secondary">Edit</a>
                        <a href="delete_kb_article.php?id=<?= $article['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
