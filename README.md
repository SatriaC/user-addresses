## Installing / Getting started

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x)

Clone the repository

    git clone https://github.com/SatriaC/user-addresses.git

Switch to the repo folder

    cd userAddress

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Generate the seeder

    php artisan db:seed

Generate a new Passport secret key

    php artisan passport:install

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000/api

**TL;DR command list**

    git clone https://github.com/SatriaC/user-addresses.git
    cd userAddress
    composer install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan db:seed
    php artisan passport:install
    php artisan serve

### Built With
    PHP 8.1.4
    Laravel 8

### Dummy User
    Admin :
    email => admin@test.com
    password => 1234567890
    Public User :
    email => john@test.com
    password => 1234567890

## Api Reference

This docs will help you to test API in Postman
> [Full API Spec](https://github.com/SatriaC/user-addresses.git/tree/main/postman)

You can view the following API routes:

1. Sign in: `POST` /api/auth/login

> API routes below can be accessed by public user

1. Get all user: `GET` /api/user, we also can put any letter for the parameter of email to find any user 
1. Get a single user: `GET` /api/user/{id}

1. Get all address: `GET` /api/address, we should put the parameter of user_id to get the addresses of certain user
1. Create a address: `POST` /api/address/add
1. Get a single address: `GET` /api/address/{id}
1. Update a address: `POST` /api/address/{id}/update
1. Set default address: `POST` /api/address/{id}/default
1. Delete a address: `POST` /api/address/{id}/delete

> Start from here you must have been authenticated as admin. Please make sure that you use the admin user

1. Create a user: `POST` /api/user/add
1. Update a user: `POST` /api/user/{id}/update
1. Delete a user: `POST` /api/user/{id}/delete

1. Approving user to delete the address: `POST` /api/address/{id}/approved
1. Get nearest location from the default address of user chosen by admin: `GET` /api/address/{id}/nearest, after the admin choose one of the user, this route will present the admin the data of nearest location from default address of user. Admin can also put the parameter of certain radius in km.

