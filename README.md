E-commerce Project BookStore using laravel 8
#bookstore laravel 8


A book store created where admin is able to create, edit, update, delete book.

Users are able to store the book into the cart and buy them.


Step 1: Firstly install all the required dependencies composer install or composer update (if not working)
Step 2: rename .env.example to .env file
Step 3.1: setup the database that is comfortable to you
Step 3.2: In order to generate the app_key, please run php artisan key:generate
Step 3.3: change name of database in .env file
Step 4: Migrate the database : php artisan migrate
Step 5: php artisan db:seed UserSeeder
Step 6: php artisan serve to run the program

---------
admin@admin.com:12345678 || user@user.com:12345678
--------
