#!/bin/bash

# Executar o comando Laravel em segundo plano
/usr/local/bin/php /var/www/artisan queue:work --queue=rabbitmq &


# Iniciar o PHP-FPM
exec php-fpm
