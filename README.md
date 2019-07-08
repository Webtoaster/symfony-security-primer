
# Symfony Security Primer
(github.com/webtoaster/symfony-security-primer)

Symfony 4.3 implementation of User Security, and Email Verification with Initial Data Fixtures and Form Model implementation.  This will get you started quickly using Symfony 4 on PHP 7.3.  Additionally, it has PDO based sessions and built upon Bootstrap 4.3 and Symfony's Encore/Webpack.

This application is the foundation to a community/hoa (homeowners association) voting application I am in the the process of writing.   So this is the foundation for the user entities and security implementation. 

More and Better documentation is to come.

## Installation

### 1 - Composer
Install dependencies for the Symfony Application using Composer.

`composer install`

### 2 - Composer Updates
Install any updates to the current code in the composer.json file so the application will be most up to date.
 
`composer update`

### 3 - Node Library Installation
Install the Node modules for Webpack, your Javascript and your CSS tools.  If you have Yarn installed, use Yarn, else, use NPM.

`yarn install`  or  `npm install`

### 4 - Node Library Updates
See if there are updates to the node libraries.  Run those updates as needed.

`yarn upgrade` or `npm update`

### 5 - Database Implementation

**`IMPORTANT` : Change the settings in the .env file located in the root of the project to get started. 
 - Create the database:
 
 `php bin/console doctrine:database:create`
 - Update the database :
 
`php bin/console doctrine:migration:migrate`
 - Install the base super user using fixtures.  Note, this will pull the username and password from the .env file in the root of the application. 
 
`php bin/console doctrine:fixtures:load`

### 6 - Launch the Local PHP Server
Launch server.

`php bin/console server:run`
