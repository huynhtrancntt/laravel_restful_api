composer create-project laravel/laravel laravel_restful_api 10.2.2

php artisan make:controller UserController --model=User --resource --requests

php artisan make:controller UserController --resource --requests

php artisan migrate

php artisan db:seed

php artisan make:request UserRequest

---

php artisan make:model Customer --all
php artisan make:model Invoice --all
php artisan migrate:fresh

php artisan db:seed --class=CustomerSeeder
php artisan db:seed --class=InvoiceSeeder

php artisan make:resource v1/CustomerResource
php artisan make:resource v1/CustomerCollection

php artisan make:resource v1/InvoiceResource
php artisan make:resource v1/InvoiceCollection
