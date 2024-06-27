<?php
include_once 'db.php';
include_once 'email.php';

function create_ticket($title, $description, $customer_id) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO tickets (title, description, customer_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $description, $customer_id);
    $stmt->execute();
    $stmt->close();

    // Get customer email
    $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    // Send notification email
    $subject = "New Ticket Created: $title";
    $body = "Your ticket has been created with the following details:<br><br>Title: $title<br>Description: $description";
    send_email($email, $subject, $body);

    $conn->close();

    header('Location: ../admin/manage_tickets.php?success=true');
    exit();
}

function add_reply($ticket_id, $user_id, $message) {
    $conn = db_connect();
    $stmt = $conn->prepare("INSERT INTO replies (ticket_id, user_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $ticket_id, $user_id, $message);
    $stmt->execute();
    $stmt->close();

    // Get ticket and user email
    $stmt = $conn->prepare("SELECT title, customer_id FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $stmt->bind_result($title, $customer_id);
    $stmt->fetch();
    $stmt->close();

    // Get customer email
    $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    // Send notification email
    $subject = "New Reply to Ticket: $title";
    $body = "A new reply has been added to your ticket:<br><br>Message: $message";
    send_email($email, $subject, $body);

    $conn->close();

    header("Location: ../admin/view_ticket.php?id=$ticket_id&success=true");
    exit();
}
?>
