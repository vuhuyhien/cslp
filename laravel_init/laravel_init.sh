#!/bin/bash

#install composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --filename=composer
php -r "unlink('composer-setup.php');"
chmod +x composer

#replace env file
envsubst < .env.example > .env

#
php composer update
php composer dump-autoload
php artisan key:generate
php artisan config:clear
php artisan config:cache
php artisan storage:link
php artisan migrate:fresh
php artisan db:seed