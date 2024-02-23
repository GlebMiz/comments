## Comments SPA

This application allows the user to create comments as well as view them.

Application contains:
- List of comments, with filter and pagination
- Form for adding a comment with preview

The application is made using Laravel 10 and Vue.js

## How to start

1. First you should install required dependencies:
```shell
npm install
composer install
```
2. Make a copy of .env.example file as .env and configure it with your data
3. Run ```php artisan migrate``` to migrate required tables to your DB
4.  ``` php artisan storage:link ``` & ```php artisan key:generate``` as required commands for application
   
**Congratulation!** The application is ready to use.

Now you can run ```npm run dev``` for development mode or if application is ready for production ```npm run build```
You can also use ```php artisan serve``` to start the built-in PHP web server
