## Larauser

Larauser is a simple user profile package for Laravel applications.

## Installation

### Composer

Require this package with composer:

```
composer require christhompsontldr/larauser
```

### Service Provider

After updating composer, add the ServiceProvider to the providers array in config/app.php

#### Laravel 5.x:

```
Christhompsontldr\Larauser\ServiceProvider::class,
```

### Config

Now move the config files from the package into your application

```
php artisan vendor:publish
```

This will create `config/larauser.php`.  If you want to modify settings, now is the time to do it.

### Setup

The next command will create the migration file.

```
php artisan larauser:setup
```

#### Want to create migrations before running setup?

This will allow you to create the migrations only.  You can then modify them.  Run this before the `larauser:setup` command.

```
php artisan larauser:migrations
```

### Migrate

Run the migrations

```
php artisan migrate
```

### Notice

By default, Laravel's Auth system creates a users table that has a non-nullable field `name`.  You'll want change that to be nullable, or make sure your user register form has that field.

### HTML & Forms
The [Laravel Collective](https://laravelcollective.com/) package is utilizes for building HTML and forms.  If you aren't already using it, no worries, Laraboard will install it.