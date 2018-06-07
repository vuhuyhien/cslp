0. composer dump-autoload
1. Tạo .env theo file .env.example
2. php artisan key:generate
3. docker-compose up -d
4. php artisan migrate
5. php artisan db:seed
6. php artisan serve
7. php artisan storage:link

Admin account : 
    login url: {APP_URL}/admin
    email: cslp.manager@gmail.com
    password : secret
    password gmail: 123456Aa@

if you want fake some posts: php artisan db:seed --class=PostFakerTableSeeder