<?php
include_once '../includes/auth.php';
include_once '../includes/integrations.php';
check_login();

if ($_SESSION['role'] !== 'admin') {
    header('Location: /public/login.php');
    exit();
}

$integrations = get_integrations();
$shopify_integrations = get_shopify_integrations();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Integrations</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
    <h1 class="mt-5">Manage Integrations</h1>
    <a href="add_integration.php" class="btn btn-primary mb-3">Add Integration</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Provider</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($integrations as $integration): ?>
                <tr>
                    <td><?= $integration['id'] ?></td>
                    <td><?= $integration['provider'] ?></td>
                    <td>
                        <a href="edit_integration.php?id=<?= $integration['id'] ?>" class="btn btn-secondary">Edit</a>
                        <a href="delete_integration.php?id=<?= $integration['id'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php foreach ($shopify_integrations as $integration): ?>
                <tr>
                    <td><?= $integration['id'] ?></td>
                    <td>Shopify (<?= $integration['shop_name'] ?>)</td>
                    <td>
                        <a href="delete_shopify_integration.php?id=<?= $integration['id'] ?>" class="btn btn-danger">Delete</a>
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
