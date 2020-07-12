# LaraLog

Develop description

## Installation

You can install this package quickly and easily with Composer.

`composer require pavel-one/lara-log`

### Laravel integration

LaraLog supports laravel integration. Best practice to use the library 
in Laravel is to add the ServiceProvider and Facade of the Lara Log Class.

Open your Laravel config file `config/app.php` and add the following lines.

`\LaraSU\Logger\Providers\LogServiceProvider::class`

Add the facade of this package to the $aliases array.

`'LaraLog' => \LaraSU\Logger\Facades\LaraLog::class,`

And publish config file:

`php artisan vendor:publish --tag=lara-log`

### Native PHP integration or other frameworks


## Usage

### Laravel use

### Native php use