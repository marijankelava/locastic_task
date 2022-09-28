## Setup

# Locastic_task

This simple app is for importing and showing race results.

## Installation

Clone repository `git clone https://gitlab.com/marijan-kelava/locastic_task.git your-project`
Enter to project folder `cd your-project`
Checkout to master branch

## Docker Setup
 - create .env and copy contents of env.local
 - build docker containers `docker-compose build`
 - run `docker-compose up -d` to build up the containers 
 - login to `locastic_task_web` container `docker exec -it locastic_task_web bash` 
 - run commands:
    `composer install` ,
    `php bin/console do:sc:dr --force`,
    `php bin/console do:sc:cr`

## Default database credentials:
 - server: locastic_task_db
 - username: user
 - password: user
 - database: db

## Request URL example

http://localhost:8888

http://localhost:8888/results

http://localhost:8888/race/create

http:/localhost:8888/results/edit/id








