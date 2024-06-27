<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Google\Client as GoogleClient;
use Google\Service\Gmail as GoogleGmail;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Message;

require '../vendor/autoload.php';
require 'email_template.php';

function send_email($to, $subject, $body, $provider = 'smtp') {
    if ($provider == 'gmail') {
        send_gmail_api_email($to, $subject, $body);
    } elseif ($provider == 'outlook') {
        send_outlook_api_email($to, $subject, $body);
    } else {
        send_smtp_email($to, $subject, $body);
    }
}

function send_smtp_email($to, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        // Default SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'user@example.com';
        $mail->Password = 'secret';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('from@example.com', 'Helpdesk');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = get_email_template($subject, $body);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function send_gmail_api_email($to, $subject, $body) {
    $client = new GoogleClient();
    $client->setClientId(GMAIL_CLIENT_ID);
    $client->setClientSecret(GMAIL_CLIENT_SECRET);
    $client->setRedirectUri(GMAIL_REDIRECT_URI);
    $client->addScope(GoogleGmail::MAIL_GOOGLE_COM);
    $client->setAccessType('offline');

    // Assuming you have the OAuth2 token saved in the session
    $client->setAccessToken($_SESSION['gmail_access_token']);

    if ($client->isAccessTokenExpired()) {
        $refreshToken = $client->getRefreshToken();
        $client->fetchAccessTokenWithRefreshToken($refreshToken);
        $_SESSION['gmail_access_token'] = $client->getAccessToken();
    }

    $gmail = new GoogleGmail($client);

    $message = new Google\Service\Gmail\Message();
    $rawMessageString = "From: from@example.com\r\n";
    $rawMessageString .= "To: $to\r\n";
    $rawMessageString .= "Subject: $subject\r\n\r\n";
    $rawMessageString .= get_email_template($subject, $body);
    $rawMessage = base64_encode($rawMessageString);
    $rawMessage = str_replace(array('+', '/', '='), array('-', '_', ''), $rawMessage);
    $message->setRaw($rawMessage);

    try {
        $gmail->users_messages->send('me', $message);
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Gmail API Error: {$e->getMessage()}";
    }
}

function send_outlook_api_email($to, $subject, $body) {
    $graph = new Graph();
    $graph->setAccessToken($_SESSION['outlook_access_token']);

    $message = new Message();
    $message->setSubject($subject);
    $message->setBody(new \Microsoft\Graph\Model\ItemBody(['ContentType' => 'HTML', 'Content' => get_email_template($subject, $body)]));
    $message->setToRecipients([['EmailAddress' => ['Address' => $to]]]);

    try {
        $graph->createRequest("POST", "/me/sendMail")
              ->attachBody(['Message' => $message, 'SaveToSentItems' => true])
              ->execute();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Outlook API Error: {$e->getMessage()}";
    }
}
?>
