<?php
include_once '../includes/auth.php';
include_once '../includes/tickets.php';
check_login();

if ($_SESSION['role'] !== 'agent') {
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
    <title>Manage Tickets</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
          width: 100vw;
          height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
        }

        .checkmark {
          width: 56px;
          height: 56px;
          border-radius: 50%;
          display: block;
          stroke-width: 2;
          stroke: #fff;
          stroke-miterlimit: 10;
          box-shadow: inset 0px 0px 0px #7ac142;
          animation: fill 0.4s ease-in-out 0.4s forwards,
            scale 0.3s ease-in-out 0.9s both;
        }

        .checkmark__circle {
          stroke-dasharray: 166;
          stroke-dashoffset: 166;
          stroke-width: 2;
          stroke-miterlimit: 10;
          stroke: #7ac142;
          fill: none;
          animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .checkmark__check {
          transform-origin: 50% 50%;
          stroke-dasharray: 48;
          stroke-dashoffset: 48;
          animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        @keyframes stroke {
          100% {
            stroke-dashoffset: 0;
          }
        }

        @keyframes scale {
          0%,
          100% {
            transform: none;
          }
          50% {
            transform: scale3d(1.1, 1.1, 1);
          }
        }

        @keyframes fill {
          100% {
            box-shadow: inset 0px 0px 0px 30px #7ac142;
          }
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mt-5">Manage Tickets</h1>
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

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
                <h4 class="mt-3">Success!</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Show success modal after certain actions
        <?php if (isset($_GET['success'])): ?>
            $('#successModal').modal('show');
        <?php endif; ?>
    });
</script>
</body>
</html>
