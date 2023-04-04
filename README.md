#To Do List

1. First check your device have symfony,composer and PHP v8.0^ installed. if not kinldy refer https://symfony.com/doc/current/setup.html and https://getcomposer.org/download/.
2. Clone the code in your device 
3. Add Database in your SQL Server
4. Add DATABASE_URL="mysql://DATABASE_USER_NAME:DATABASE_PASSWORD@DATABASE_HOST/DATABASE_NAME?serverVersion=5.7"
5. Change APP_ENV from "dev"  to "prod"
6. Update Composer using "composer update" command
7. Update App using "composer require annotations" command
8. Make migratation using "php bin/console make:migration" command (it Prepare migration to be insert in DATABASE SERVER).
9.Process your migration with "php bin/console doctrine:migrations:migrate" command ( it simply add table in your DATABASE ). 
10.To start server use "symfony server:start" on localhost.
