## Alfa Cash

After successfully installation
Run this commands:

`cd ./backend && composer install`

`cd ./frontend && npm install`

In backend folder

`php artisan serve --port=8001`

`php artisan migrate`

`php artisan app:fetch-sheepy-currencies-command`

`php artisan app:fetch-binance-currencies-command`

In frontend 

`npm run dev`
