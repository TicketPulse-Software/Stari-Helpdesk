<?php
$subdomain = $_GET['subdomain'] ?? 'public';

switch ($subdomain) {
    case 'admin':
        include 'admin/index.php';
        break;
    case 'agent':
        include 'agent/index.php';
        break;
    case 'customer':
        include 'customer/index.php';
        break;
    default:
        include 'public/index.php';
        break;
}
?>
