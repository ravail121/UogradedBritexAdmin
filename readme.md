Custom Directories

public/temp = used to save temporary .csv files, they get deleted after user gets download option.
### Install Vendor Libraries

    composer install

### Generate Application Key

    php artisan key:generate

### Clear Configuration Cache

    php artisan config:clear
    php artisan config:cache

### Troubleshooting

For Mail SSL error in local environment, comment line number 39 ($customSmtp['encryption']) in DynamicSmtpMailChannel.php file