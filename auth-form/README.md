# authorisation form
Create an authentication form. 

Authentication form must contain name, email and password fields. Password typing should be hidden, using function
`password_hash()`. Therefore to check the correctness of the hash filed use `password_verify()` function.
Make validation of fields with corresponding error message. Enable the submit button only if all fields are filled in together.

Don't use AJAX to send requests to the back-end.

Authenticate user over the file below:

```
<?php
declare(strict_types=1);
return [
'user1@test.com' => [
'name' => 'John',
'password' => 'your_hash_here1', // use password_hash() to generate password in your code
],
'user2@test.com' => [
'name' => 'Jane',
'password' => 'your_hash_here2', // use
password_hash() to generate password in your code
],
];
```

Use `session_start` to start the session and set the value of user’s email to global variable of session.

If the user authenticated successfully,
greet him by message 'Welcome back, {user name}!'. If no, show the message 'Login is incorrect.'.
After getting the greet message, user should have an opportunity to press the log out button that
clear the session and redirect user to the home page.

You should implement this application in OOP. Implement MVC pattern for this application. 
For the View part you must use the Twig Template Engine, loaded through Composer. Use separate CSS files for styles.

# run the application
* run `composer install`
* run migration of creating users table by executing `composer create-users-table` from the project root directory
* run migration of full feeling the db tables by executing `composer seed-users` from the project root directory
* start php server by running command `php -S 127.0.0.1:8080`
* Open in browser http://127.0.0.1:8080/user
