# Meal recommendation API

> Laravel application for meal recommendation based on user and meal allergies. The app features a REST API with authentication.


**Features the API should have:**

1. The system should operate on three Allergies:
    1. Nut Allergy
    2. ShellFish Allergy
    3. SeaFood Allergy
2. Every user on the system should be able to pick their allergies (ranging from zero to all the allergies provided by the system).
3. The system should be able to accommodate at least 50 meals (Each meal should have a main item & at least 2 side items) at any time (with allergies for these meals)
4. The system should have the ability to recommend meals to users based on their allergies.
    1. For better clarity, this means:
        1. Every user has the ability to fetch meal recommendations at any time.
5. The system should also be able to fetch meal recommendations for more than one user at a time. (example: fetch meal recommendations for 10 users at a time)


### Clone

- Clone the repository using `git clone https://github.com/tosinibrahim96/Meal-recommendation-system.git`
- Create a `.env` file in the root folder and copy everything from `.env-sample` into it
- Fill the `.env` values with your Database details as required


### Setup

- Download WAMP or XAMPP to manage APACHE, MYSQL and PhpMyAdmin. This also installs PHP by default. You can follow [this ](https://youtu.be/h6DEDm7C37A)tutorial
- Download and install [composer ](https://getcomposer.org/)globally on your system

> install all project dependencies and generate application key

```shell
$ composer install
$ php artisan key:generate
```
> migrate all tables and seed required data into the database

```shell
$ php artisan migrate:fresh --seed
```
> start your Apache server and MySQL on WAMP or XAMPP interface
> serve your project using the default laravel PORT or manually specify a PORT

```shell
$ php artisan serve (Default PORT)
$ php artisan serve --port={PORT_NUMBER} (setting a PORT manually)
```

## Documentation

Documentation can be found [here](https://documenter.getpostman.com/view/16977306/TzskD34k).


### License

- **[MIT license](http://opensource.org/licenses/mit-license.php)**
- Copyright 2021 © <a href="https://tosinibrahim96.github.io/Resume/" target="_blank">Ibrahim Alausa</a>.
