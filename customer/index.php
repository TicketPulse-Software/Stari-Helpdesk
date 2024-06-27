<?php
include_once '../includes/auth.php';
check_login();

if ($_SESSION['role'] !== 'customer') {
    header('Location: /public/login.php');
    exit();
}

$tickets = get_tickets($_SESSION['user_id'], $_SESSION['role']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Customer Dashboard</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tickets as $ticket): ?>
                <tr>
                    <td><?= $ticket['id'] ?></td>
                    <td><?= $ticket['title'] ?></td>
                    <td><?= $ticket['status'] ?></td>
                    <td>
                        <a href="view_ticket.php?id=<?= $ticket['id'] ?>" class="btn btn-primary">View</a>
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
