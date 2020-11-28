## Инструкция по развертыванию

Для старта сервера требуется наличие выполняемого php cli.

1. В папке проекта выполнить composer install. Если нет composer - https://getcomposer.org/download/
1. Скопировать файл .env.example в .env
1. В папке проекта выполнить php artisan key:generate
1. В папке проекта выполнить php artisan migrate (Для этого должна быть создана на локале mysql база указаннаяа в env DB_DATABASE)
1. В папке проекта выполнить php artisan serve. После этого в браузере можно делать запросы на (127.0.0.1:{port}/api/auth/(login,sign-up,me)). Список роутов есть в папке routes/api.php 
