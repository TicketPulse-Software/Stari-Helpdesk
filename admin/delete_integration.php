<?php
include_once '../includes/auth.php';
include_once '../includes/integrations.php';
check_login();

if ($_SESSION['role'] !== 'admin') {
    header('Location: /public/login.php');
    exit();
}

$id = $_GET['id'];
delete_integration($id);
header('Location: integrations.php');
?>
