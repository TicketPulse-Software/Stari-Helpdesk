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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
