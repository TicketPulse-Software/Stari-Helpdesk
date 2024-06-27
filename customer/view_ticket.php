<?php
include_once '../includes/auth.php';
include_once '../includes/tickets.php';
check_login();

if ($_SESSION['role'] !== 'customer') {
    header('Location: /public/login.php');
    exit();
}

$ticket_id = $_GET['id'];
$ticket = get_ticket($ticket_id);
$replies = get_replies($ticket_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['message'];
    add_reply($ticket_id, $_SESSION['user_id'], $message);
    header("Location: view_ticket.php?id=$ticket_id&success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Ticket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">View Ticket</h1>
    <h2><?= $ticket['title'] ?></h2>
    <p><?= $ticket['description'] ?></p>
    <hr>
    <h3>Replies</h3>
    <?php foreach ($replies as $reply): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= $reply['username'] ?></h5>
                <p class="card-text"><?= $reply['message'] ?></p>
                <p class="card-text"><small class="text-muted"><?= $reply['created_at'] ?></small></p>
            </div>
        </div>
    <?php endforeach; ?>
    <hr>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="message" class="form-label">Reply</label>
            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
