<?php
include_once '../includes/auth.php';
include_once '../includes/shopify.php';
include_once '../includes/integrations.php';
check_login();

if ($_SESSION['role'] !== 'admin') {
    header('Location: /public/login.php');
    exit();
}

if (isset($_GET['shop']) && isset($_GET['code'])) {
    $shop = $_GET['shop'];
    $code = $_GET['code'];
    $access_token = get_shopify_access_token($shop, $code);
    if ($access_token) {
        add_shopify_integration($shop, $access_token);
        header('Location: integrations.php');
        exit();
    } else {
        echo 'Failed to obtain access token.';
    }
} else {
    echo 'Invalid request.';
}
?>
