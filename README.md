# CODEGYM's Laravel Project Sample [![Build Status](https://travis-ci.org/vuhuyhien/cslp.svg?branch=master)](https://travis-ci.org/vuhuyhien/cslp) 

If you want running project manually, please read [here](www/README.md) 

## Overview

1. [Install prerequisites](#install-prerequisites)

    Before installing project make sure the following prerequisites have been met.

2. [Clone the project](#clone-the-project)

    We’ll download the code from its repository on GitHub.

3. [Run the application](#run-the-application)

    By this point we’ll have all the project pieces in place.

4. [PHPMyadmin](#phpmyadmin) [`Optional`]

    Manage database with phpmyadmin

___
## Install prerequisites

For now, this project has been mainly created for Unix `(Linux/MacOS)`. Perhaps it could work on Windows.

All requisites should be available for your distribution. The most important are :

* [Git](https://git-scm.com/downloads)
* [Docker](https://docs.docker.com/engine/installation/)
* [Docker Compose](https://docs.docker.com/compose/install/)

Check if `docker-compose` is already installed by entering the following command : 

```sh
which docker-compose
```

Check Docker Compose compatibility :

* [Compose file version 3 reference](https://docs.docker.com/compose/compose-file/)

The following is optional but makes life more enjoyable :

```sh
which make
```

On Ubuntu and Debian these are available in the meta-package build-essential. On other distributions, you may need to install the GNU C++ compiler separately.

```sh
sudo apt install build-essential
```

### Images to use

* [Nginx](https://hub.docker.com/_/nginx/)
* [MariaDB](https://hub.docker.com/_/mariadb/)
* [PHP](https://hub.docker.com/_/php/)
* [PHPMyAdmin](https://hub.docker.com/r/phpmyadmin/phpmyadmin/)

You should be careful when installing third party web servers such as MariaDB or Nginx.

This project use the following ports :

| Server     | Port  |
|------------|-------|
| MySQL      | 33060 |
| PHPMyAdmin | 8999  |
| Nginx      | 8880  |

___

## Clone the project

To install [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git), download it and install following the instructions :

```sh
git clone https://github.com/vuhuyhien/cslp.git
```

Go to the project directory :

```sh
cd cslp
```

## Run the application

1. Create the docker environment file : 

    ```sh
    cp .env.docker .env
    ```

2. Init project and seeding data :

    ```sh
    sudo docker-compose up laravel_init
    ```
    
    *You should taking a coffee, composer is very slow...*

3. Running laravel :

    ```sh
    sudo docker-compose up -d web
    ```
    
    *Please wait this might take a several minutes*

4. Open your favorite browser :

    * [http://localhost:8880](http://localhost:8880/)
    
    * Admin account : 
        - login url: {APP_URL}/admin
        - email: cslp.manager@gmail.com
        - password : secret
        - password gmail: 123456Aa@
    
5. Stop and clear services :

    ```sh
    sudo docker-compose down -v
    ```
    
___

### PHPMyadmin
1. Start container:

    ```sh
    sudp docker-compose up -d phpmyadmin
    ```
    
2. Login:

    [http://localhost:8999](http://localhost:8999)
    - host: ${MYSQL_HOST} (defined in .env)
    - user: ${MYSQL_USER} (defined in .env)
    - pass: ${MYSQL_PASSWORD} (defined in .env)