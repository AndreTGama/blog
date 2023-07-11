# Blog Api

A new Laravel project.

## Getting Started
This is a laravel project for the purpose of writing a blog post. To learn more about Laravel visit what is just below.

- [Laravel](https://laravel.com/).


## Step One

Download composer on your machine com o link: https://getcomposer.org/download/

**note: composer needs PHP installed on the machine**

Make a clone of this project using the command

```
    git clone https://github.com/AndreTGama/blog.git
```

## Step Two

Run the command in your terminal

**note: the terminal needs is in the root of the project**

```
    composer install
```

## Step Three

Configure the .env file, if not, copy the .env-example file and rename it to .env and configure the database connection information

```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE={database name}
    DB_USERNAME=root
    DB_PASSWORD=
```

## Step four

Run command in terminal

```
    php artisan jwt:secret
```
**note: This command will create your JWT key, don't share it with anyone**

## Step five

Run command in terminal

```
    php artisan migrate:refresh --seed
```

## Step five

Run command in terminal

```
    php artisan serve
```

Use the routes that are in this link to see the api in action: [LINK UNDER CONSTRUCTION]
