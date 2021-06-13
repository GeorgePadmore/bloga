<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Bloga

This is a sample site to demonstate the comments feature of a post.
Kindly follow the steps to deploy and get this project running on your localhost.

- git clone https://github.com/GeorgePadmore/bloga.git.
- composer install
- php artisan ui vue
- npm install && npm run dev
- create your database in mysql e.g. bloga_db 
- create .env file and use the database/mysql credentials
- php artisan migrate
- php artisan serve
- npm run watch
- url is http://localhost:8000


## Additional Info
- An Admin can login and make posts as well as delete a post.
- One can create an account at http://localhost:8000/register

## Guest
- List of obituaries: http://localhost:8000/obituary
- Guests can only book a condolence.