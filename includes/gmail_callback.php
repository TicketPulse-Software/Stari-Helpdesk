<?php
require '../vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

session_start();

$provider = new Google([
    'clientId'     => GMAIL_CLIENT_ID,
    'clientSecret' => GMAIL_CLIENT_SECRET,
    'redirectUri'  => GMAIL_REDIRECT_URI,
]);

if (!isset($_GET['code'])) {
    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    // State is invalid, possible CSRF attack in progress
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Use this to interact with an API on the users behalf
    try {
        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create the email configuration, or log the user in
        echo 'Hello, ' . $user->getEmail();
    } catch (Exception $e) {
        // Failed to get user details
        exit('Oh dear...');
    }
}
?>
