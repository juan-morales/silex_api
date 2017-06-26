# README #

General project schema to create a PHP Silex Project (REST APIs) using an Services-Controller architecture and JSON responses.

### Main Idea ###

* Having a code Schema, ready to Add Services and Controllers.

* In one Controller, you may use many Service Methods.

* Example:
*	Create Services for Users
*	Create Services for Sessions

*	Then you can have Controllers, that use the services to manage users and sessions and another ones depending on the pourpuse of the Controller.

### What is this repo for? ###

* Project Schema in order to create a Services-Controller driven REST API webapp using PHP/Silex.
* JSON responses.
* Version 1.0

### Test Routes
+ Hello World   -parameter: name
> > ####  http://localhost/silex_api/web/index.php/api/v1/helloworld

+ Create a Product in DB   -parameter: product_name
> > ####  http://localhost/silex_api/web/index.php/api/v1/product/create

+ Update a Product in DB   -parameter: product_id, product_name
> > ####  http://localhost/silex_api/web/index.php/api/v1/product/update

+ Delete a Product in DB   -parameter: product_id
> > ####  http://localhost/silex_api/web/index.php/api/v1/product/delete

+ Select a Product or all products in DB   -parameter: product_id or null
> > ####  http://localhost/silex_api/web/index.php/api/v1/product/


### Install ###

* Copy this folder project into your "htdocs"
* Change your DataBase parameters in app.php
* Use your favorite API Client like:
*	POSTMAN
*	Advanced REST Client.


### Dev/Prod ###

* To create predefined settings in webapp environments (Dev & Prod), check the files in:
* ./resources/config


### Main WebApp code ###

* The main code of the app is in the ./src directory. Feel free to modify anything.

### Check Points ###
* Dont forget to enable/disable the "//CORS SECTION" in the main app.php file.