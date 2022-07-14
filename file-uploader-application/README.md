# file uploader application
Create an application that includes registration, authorization and file uploads
You need to combine the solutions from assignments 15-17 into one application using cookies and sessions.You should decide what data set in cookies and what in sessions. Authenticate user after they were registered successfully. Allow only 3 login attempts. If they fails, block user by IP on 15 minutes. Log this fact (log attacker IP-address and email, start and end blocking period) Only authenticated users should have access to File upload form and be able to upload files. Log successful upload operation (message format: {date}: {actual filename} - {filesize} - {archive name} - {archive filesize}) Log all errors and exceptions in separate storage. Implement 'Remember me' functionality and save authenticated user for 1 week.
You should implement this application in OOP. Implement MVC pattern for this application. For the View part you must use the Twig Template Engine, loaded through Composer. Use separate CSS files for styles.

**Tags:  PHP, OOP, MVC, Bootstrap, Twig, Composer, HTML, CSS, JS, GIT**

# run the application
* run `composer install`
* run migration of creating users table by executing `composer create-user-table` from the project root directory 
* run migration of creating users table by executing `composer create-file-table` from the project root directory
* run migration of full feeling the db tables by executing `composer seed-user` from the project root directory
* start php server by running command `php -S 127.0.0.1:8080`
* Open in browser http://127.0.0.1:8080/user
