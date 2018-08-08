# DevOps Microservice Lumen Project
[build] [stable]

[version] [v0.0.2 beta]

##### Why use it?
>Microservice Lumen allows you to start with a solid base for the construction of your back end, through the use of packages, services and patterns you can implement your app easily and efficiently.
With this framework you can implement your REST APIs in just a few steps using artisan commands to create the Controller, the Repository connected to the data model and the Transformer for displaying data.
The microservice communicates with the outside through api http calls with JWT authentication (stateless token). Implement basic services for API controllers, for responses, and helpers.

## Official Documentation
[wiki] [https://github.com/FabrizioCafolla/microservice-lumen/wiki]

## Features 
   ##### v0.0.2 beta
    -Fixed Auth service to api controller
    -Create abstract auth service for authentication
    
   ##### v0.0.1 beta
    -Add JWT token auth
    -Create Middleware jwt (api.jwt)
    -Create Middleware dingo + jwt (api.auth)
    -Create Auth Service
    -Fixed errors
    -Add comment
    
   ##### v0.0.3 alpha
    -Create services Api and Reponse 
    -Add services to api base controll
    -Add service Response to abstract repository
   ##### v0.0.2 alpha
    -Add commands artisan create (Api controller, Transformer, Repository) 
    -Create ApiBaseController: with method transform and response
    -Create RepositoryAbstract: with method rest and response
    -Use Transformers
    -Create Database Seed
    -Add file config database and filesystem
    -Config file bootstrap with AppServiceProvider
   ##### v0.0.1 alpha
    -Config Docker contaneir MySLQ 5.7, PHP 7.2 and Nginx
    -Add and config Dingo for API managment
    -Add controller and routes for test Api
    -Add migration and database congig file

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
