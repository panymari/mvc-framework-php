# mvc-framework-php
Create a form for working with users using MVC, the data source is a MySQL database

In the developed application, you must be able to add new users, edit user data, delete users, view the list of all users. You design the interface of the application and the structure of the MySQL database yourself.
Use the following data to work with users
email field "Email", name="email" - key field
text field "Your first and last name", name="name"
drop-down list "Gender" ( male, female ), name="gender"
drop-down list "Status" ( active, inactive ), name="status"

Prerequisites:
use Bootstrap
store data in MySQL
make checks for field completeness and data correctness using JS and PHP

When we start editing user data, the editable fields must be pre-filled with current data. For the "Delete" button, add a deletion confirmation using javascript code.
You should implement this application in OOP. Split logic and templates into separate files.
Logic files should contain PHP code only.
Use separate CSS files for styles.

# run the application
* run `composer install`
* run migration of creating users table by executing `composer create-users-table` from the project root directory
* run migration of full feeling the db tables by executing `composer seed-users` from the project root directory
* start php server by running command `php -S 127.0.0.1:8080`
* Open in browser http://127.0.0.1:8080/user
