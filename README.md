# Stari-Helpdesk

Welcome to Stari-Helpdesk, an efficient and user-friendly helpdesk system created by TicketPulse Software. This software is designed to help organizations manage customer support tickets, knowledge bases, and integrations with various services.

## Features

- **Ticket Management**: Manage support tickets with ease.
- **Knowledge Base**: Create and maintain a knowledge base for self-service support.
- **Integrations**: Integrate with various services like Gmail and Outlook.
- **User Roles**: Admin, agent, and customer roles with specific functionalities for each.

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL or MariaDB
- Web server (Apache, Nginx, etc.)

### Steps

1. **Clone the repository**:
    ```bash
    git clone https://github.com/TicketPulse-Software/Stari-Helpdesk.git
    ```

2. **Navigate to the project directory**:
    ```bash
    cd stari-helpdesk/Helpdesk
    ```

3. **Configure the database**:
    - Open `config.php` and set your database credentials.

4. **Set up the database**:
    - Import the SQL file to set up the necessary database tables.

5. **Set up the web server**:
    - Ensure your web server is pointing to the `public` directory.
    - If using Apache, make sure to include the `.htaccess` file for proper URL routing.

6. **Install dependencies**:
    ```bash
    composer install
    ```

7. **Run the application**:
    - Access the application via your web browser.

## Directory Structure

- `admin/`: Contains admin functionalities.
- `agent/`: Contains agent functionalities.
- `customer/`: Contains customer functionalities.
- `includes/`: Contains PHP scripts for various operations like email, authentication, and integrations.
- `public/`: Public-facing scripts, including login, registration, and index pages.

## Configuration

- **Database Configuration**: Located in `config.php`.
- **Subdomain Routing**: Managed by `subdomain_router.php`.
- **Email Templates**: Customize email templates in `includes/email_template.php`.

## Integrations

### Gmail Integration

1. **Set up a Google Cloud project**:
    - Go to the [Google Cloud Console](https://console.cloud.google.com/).
    - Create a new project.
    - Enable the Gmail API.

2. **Create OAuth 2.0 credentials**:
    - Go to the Credentials page.
    - Create OAuth 2.0 Client IDs and download the JSON file.
    - Place the JSON file in the `includes` directory and rename it to `credentials.json`.

3. **Update the Gmail callback**:
    - Ensure `includes/gmail_callback.php` is configured with the correct redirect URI.

### Outlook Integration

1. **Register your application with Azure AD**:
    - Go to the [Azure Portal](https://portal.azure.com/).
    - Register a new application.
    - Configure API permissions to use the Microsoft Graph API.

2. **Create client secret**:
    - Create a client secret and note it down.

3. **Update the Outlook callback**:
    - Ensure `includes/outlook_callback.php` is configured with your client ID, client secret, and redirect URI.

### SMTP Integration

1. **Configure SMTP settings**:
    - Open `config.php` and add your SMTP server details, including server address, port, username, and password.

## Usage

### Admin

- **Manage Tickets**: View and respond to all tickets.
- **Manage Knowledge Base**: Create, edit, and delete knowledge base articles.
- **Integrations**: Add, edit, and delete integrations.
- **Status Page**: View the status of all tickets.

### Agent

- **View Tickets**: View and respond to tickets assigned to them.
- **Knowledge Base**: Access the knowledge base.
- **Status Page**: View the status of tickets assigned to them.

### Customer

- **Submit Tickets**: Create new support tickets.
- **View Tickets**: View their submitted tickets and responses.
- **Knowledge Base**: Access the knowledge base for self-help.

## Contributing

We welcome contributions from the community. To contribute:

1. Fork the repository.
2. Create your feature branch:
    ```bash
    git checkout -b feature/YourFeature
    ```
3. Commit your changes:
    ```bash
    git commit -m 'Add some feature'
    ```
4. Push to the branch:
    ```bash
    git push origin feature/YourFeature
    ```
5. Open a pull request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Support

For support, please contact support@ticketpulsesoftware.com or visit our [support page](https://www.ticketpulsesoftware.com/support).

## Acknowledgements

- **Open Source Libraries**: We thank the developers of the open-source libraries used in this project.
- **Community Contributions**: We appreciate contributions from the community that help improve this project.

## Roadmap

- **Future Integrations**: Plan to integrate with more services such as Shopify.
- **Mobile Support**: Develop dedicated apps for MacOS, iPadOS, and iOS.
- **Performance Enhancements**: Continuous improvements to ensure optimal performance.
- **ClickSend and Twilio Integration**: Add support for ClickSend and Twilio for enhanced communication.
- **SMTP Integration**: Implement a flexible SMTP integration for email notifications.
- **Enhanced Status Page**: Develop a comprehensive status page for admins and agents to monitor ticket status.
