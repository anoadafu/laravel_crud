Simple CRUD application on [Laravel 7](https://laravel.com)
- Use [Doctrine ORM](https://www.doctrine-project.org/index.html) for DB queries
- Use [Twig](https://twig.symfony.com/) for templates
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
Configure server and DB. For more information look [Documentation](https://laravel.com/docs/7.x). 
Another detailed example of configuration [Laravel with LEMP](https://www.digitalocean.com/community/tutorials/how-to-install-and-configure-laravel-with-lemp-on-ubuntu-18-04)

Because we use Doctrine ORM instead of Eloquent execute this command to create tables in your database:
```bash
php artisan doctrine:schema:create
```
Add link to local storage by running:
```bash
php artisan storage:link
```
And run, to auto generat application key:
```bash
php artisan key:generate 
```