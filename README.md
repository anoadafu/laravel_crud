Simple CRUD application using [Laravel 7](https://laravel.com)

- Use [Intervention Image](http://image.intervention.io/) for image thumbnails

Tested on php version 7.3.5, 7.4.3

## Requirements
- PHP >= 7.2.5
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- PHP Zip extension
- GD library

## Getting started
Just clone the project to anywhere in your computer. <br>
Run composer install ` composer install ` <br>
Rename ` .env.example ` to ` .env ` add your enviroment vars
Configure server and DB. For more information read [Laravel Documentation](https://laravel.com/docs/7.x). 

Add link to local storage:
```bash
php artisan storage:link
```
Migrate tables:
```bash
php artisan migrate
```
Create dummy data:
```bash
php artisan db:seed
```
Generat application key:
```bash
php artisan key:generate
```
Serving Laravel:
```bash
php artisan serve
```