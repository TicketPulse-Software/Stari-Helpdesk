<?php
include_once '../includes/auth.php';
include_once '../includes/integrations.php';
check_login();

if ($_SESSION['role'] !== 'admin') {
    header('Location: /public/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $provider = $_POST['provider'];
    $client_id = $_POST['client_id'];
    $client_secret = $_POST['client_secret'];
    $redirect_uri = $_POST['redirect_uri'];
    add_integration($provider, $client_id, $client_secret, $redirect_uri);
    header('Location: integrations.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Integration</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
    <h1 class="mt-5">Add Integration</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="provider" class="form-label">Provider</label>
            <input type="text" class="form-control" id="provider" name="provider" required>
        </div>
        <div class="mb-3">
            <label for="client_id" class="form-label">Client ID</label>
            <input type="text" class="form-control" id="client_id" name="client_id" required>
        </div>
        <div class="mb-3">
            <label for="client_secret" class="form-label">Client Secret</label>
            <input type="text" class="form-control" id="client_secret" name="client_secret" required>
        </div>
        <div class="mb-3">
            <label for="redirect_uri" class="form-label">Redirect URI</label>
            <input type="text" class="form-control" id="redirect_uri" name="redirect_uri" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Integration</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
