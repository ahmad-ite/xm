## Welcome To  XM APP

# PHP - LARAVEL - Blade, JQuery - AJAX - chart.js - Datatable - APIs- MYSQL- Unit Test - Integration Test- DOCKER 

## Base Repo


Following things are ready to be used directly with the project.
- Migration
- Seeders
- Unit test
- Integration Test
- Docker
- Restful APIs
- Filters



## Usage 

- Clone/Download a repo.
- Run `cd {project folder}`
- Run `cp .env.sample .env`
- update `.env` file with db info, smtp info and RapidAPI
- create new database   `{xm-db}`
- Run `composer install`
- Run `php artisan key:generate`  
- Run `php artisan migrate` for Migration 
- Run `php artisan db:seed` 
- Run `php artisan serve` and start







## Unit Test
- update configration in   `.env.testing` file
- create  `testing` DB 
- run `php artisan test`

## Docker
- run `docker-compose up -d`

## Scheduler
- update crontab by the following command
` * * * * * cd /{path_to_project}&& php artisan schedule:run >> /dev/null 2>&1`


Contact: ahmad.alhourani.ite90@gmail.com

