<?php
function get_email_template($subject, $body) {
    return "
    <html>
    <head>
        <title>{$subject}</title>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
            .container { width: 80%; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 10px; }
            .header { background-color: #007bff; color: white; padding: 10px 20px; border-radius: 10px 10px 0 0; }
            .content { padding: 20px; }
            .footer { background-color: #f4f4f4; padding: 10px 20px; border-radius: 0 0 10px 10px; text-align: center; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>{$subject}</h1>
            </div>
            <div class='content'>
                <p>{$body}</p>
            </div>
            <div class='footer'>
                <p>&copy; " . date('Y') . " Your Company. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>
    ";
}
?>
