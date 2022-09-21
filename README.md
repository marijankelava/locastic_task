## Setup

1. `git clone git@gitlab.com:marijankelava/symfony.develop.git`
2. create database
3. build docker containers `docker-compose build`
4. create docker-compose.yml and copy contents of docker-compose.yml.dist
5. run `docker-compose up`
6. login into web container `docker exec -it symfony_app1_web bash`
7. run migrations:
   `php bin/console do:sc:dr --force`, 
   `php bin/console do:sc:cr`
8. install dependecies `composer install`
9. create .env file and copy contents of .env.local
