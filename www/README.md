#Running project sample manually

## Install prerequisites
Before installing project make sure the following prerequisites have been met.
1. PHP-FPM version 7.2+
2. [MariaDB](https://mariadb.org/) or MySQL
3. [Composer](https://getcomposer.org/)
4. [Web Server using Apache or Nginx](https://laravel.com/docs/5.6/installation#web-server-configuration)

----

## Clone the project

To install [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git), download it and install following the instructions :

```sh
git clone https://github.com/vuhuyhien/cslp.git
```

Go to the project directory :

```sh
cd cslp\www
```

--- 

## Setup database

(uhm....)

## Setup
Step 1: update via composer

    ```sh
    php composer update
    php composer dump-autoload
    ```
 
Step 2: Create .env file from .env.example

Step 3: Artisan CLI

    ```sh
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    php artisan serve
    php artisan storage:link
    ```
