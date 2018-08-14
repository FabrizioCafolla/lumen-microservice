# DevOps Microservice Lumen Project
[build] [stable]

[version] [v1.0.0 beta]

##### Why use it?
>Microservice Lumen allows you to start from a solid foundation to build your backend. Using packages, services and patterns you'll be able to implement your app in an easy and efficient way. With this framework you can build your REST API in a few steps using artisan commands to create the Controller, the Repository linked to the data model and the Trasformer for data display. The microservice communicates with the outside through HTTP API calls with JWT authentication (stateless token). It implements base services for API controller, response and helpers.

## Official Documentation
[wiki] [https://github.com/FabrizioCafolla/microservice-lumen/wiki]

![](.github/Microservice%20Lumen.png)

## Features 
_The 1.0.0 beta version is the release that includes the following components in the framework:_

**Doker** to start the application with `Nginx`, `PHP 7`, `MySQL` and `Redis`;

**JWT** for the authentication of routes usable with the implemented service;

**Roles and Permissions** to assign them to users and manage routes with greater security;

**Services** implemented to facilitate work:

    -ResponseService to simplify the responses to the client
    -Auth to manage authentication by detaching methods from the controller
    -ACL to guarantee an abstraction of roles and permissions
    -ApiService to facilitate bee controllers through already implemented methods
    -HelpersService to easily use helpers throughout the app
    -CacheService to allow the use of the cache in a more simple and centralized way

**Repository pattern** implemented to manage the models in an abstract way and to allow the scalability of the business logic (used to guarantee also the code cleaning)

**Transformer** classes to manipulate data and better manage the recovery of related information (are transformed through functions implemented in ApiService)
  
**Artisan commands** to create Repository, ApiController and Transoformers

   ##### v1.0.0 beta
    -Fixed docker compose file
    -Fixed redis connection
    -Fixed phpunit command
    -Fixed .env file
    
   ##### v0.0.6 beta
    -Add cache service (file cache)
    -Add Redis package
    -Fixed docker directory
    -Fixed Alias load
    
   ##### v0.0.5 beta
    -Fixed ACL service (ACL for Admin and ACL for controll)
    -Fixed auth service and included ACL when users registered
    -New version docker-compose, update dockerfile 

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
