Install xampp.

start apache2 and mysql server in xampp.

place the Task-Management folder in htdocs.

create a db name "taskdb" my phpmyadmin

run command "php artisan migrate"

create .env file from .env.example file add app_name and set database connection.

make sure the database name is same as .env file.

run "php artisan serve" on terminal inside RestApiUserAuth folder.

this will be base url http://127.0.0.1:8000/register

register new user.
 
create multiple tasks for the user.

rearrange the task order.

logout.

