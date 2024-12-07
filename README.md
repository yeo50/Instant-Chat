Making Chat App  Using TALL stack                                                                                                                 
 git clone "code url"                                                                       
 cd Instant-Chat  
 
 composer install
 npm install 
 make .env file in root folder
 
 copy all from .env.example to .env
 
 php artisan key:generate
 
 php artisan migrate
 
 php artisan serve
 
 npm run dev 
 
 php artisan queue:work 

 to enable realtime broadcasting feature 
 
 php artisan install:broadcasting
 
 composer require pusher/pusher-php-server
 
 npm install --save-dev laravel-echo pusher-js
 
 copy and paste .env configuration in laravel broadcasting  client side installation pusher channnel
 
 go to pusher website register and copy and paste . pusher app, key, id etc in you .env 
 
