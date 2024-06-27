<?php
include_once '../includes/auth.php';
include_once '../includes/integrations.php';
check_login();

if ($_SESSION['role'] !== 'admin') {
    header('Location: /public/login.php');
    exit();
}

$id = $_GET['id'];
$integration = get_integration($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provider = $_POST['provider'];
    $client_id = $_POST['client_id'];
    $client_secret = $_POST['client_secret'];
    $redirect_uri = $_POST['redirect_uri'];
    update_integration($id, $provider, $client_id, $client_secret, $redirect_uri);
    header('Location: integrations.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Integration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Edit Integration</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="provider" class="form-label">Provider</label>
            <input type="text" class="form-control" id="provider" name="provider" value="<?= $integration['provider'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="client_id" class="form-label">Client ID</label>
            <input type="text" class="form-control" id="client_id" name="client_id" value="<?= $integration['client_id'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="client_secret" class="form-label">Client Secret</label>
            <input type="text" class="form-control" id="client_secret" name="client_secret" value="<?= $integration['client_secret'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="redirect_uri" class="form-label">Redirect URI</label>
            <input type="text" class="form-control" id="redirect_uri" name="redirect_uri" value="<?= $integration['redirect_uri'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Integration</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
