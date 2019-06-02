#!/bin/bash

echo about to create storage files
mkdir storage
mkdir storage/app
mkdir storage/framework
mkdir storage/framework/cache
mkdir storage/framework/sessions
mkdir storage/framework/views
mkdir storage/logs
touch storage/logs/laravel.log
chmod -R 777 storage
echo successfully created storage files


composer update

read -p "Input your database: " database
read -p "Input your database username: " username
read -p "Input your database password: " password
read -p "Input your database port: " port
touch .env



touch .env
key_gen="$(php artisan key:generate)"
key="$(echo "$key_gen" | awk -F'[][]' '{print $2}')"
key_no_space="$(echo -e "${key}" | tr -d '[:space:]')"

echo "APP_NAME=
APP_ENV=local
APP_KEY=$key_no_space
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=$port
DB_DATABASE=$database
DB_USERNAME=$username
DB_PASSWORD=$password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=database

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
" > .env





touch public/.htaccess
echo "
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>" > public/.htaccess

rm .env.example

chmod -R 777 bootstrap
php artisan storage:link
