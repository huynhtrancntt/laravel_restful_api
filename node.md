composer create-project laravel/laravel laravel_restful_api 10.2.2

php artisan make:controller UserController --model=User --resource --requests

php artisan make:controller UserController --resource --requests

php artisan migrate

php artisan db:seed

php artisan make:request UserRequest
