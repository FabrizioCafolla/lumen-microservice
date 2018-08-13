# DevOps Microservice Lumen Project
[build] [stable]

[version] [v0.0.6 beta]

##### Why use it?
>Microservice Lumen allows you to start from a solid foundation to build your backend. Using packages, services and patterns you'll be able to implement your app in an easy and efficient way. With this framework you can build your REST API in a few steps using artisan commands to create the Controller, the Repository linked to the data model and the Trasformer for data display. The microservice communicates with the outside through HTTP API calls with JWT authentication (stateless token). It implements base services for API controller, response and helpers.

## Official Documentation
[wiki] [https://github.com/FabrizioCafolla/microservice-lumen/wiki]

![](.github/Microservice%20Lumen.png)

## Features 
   ##### v0.0.6 beta
    -Add cache service (file cache)
    -Add Redis package
    -Fixed docker directory
    -Fixed Alias load
    
   ##### v0.0.5 beta
    -Fixed ACL service (ACL for Admin and ACL for controll)
    -Fixed auth service and included ACL when users registered
    -New version docker-compose, update dockerfile 
    
   ##### v0.0.4 beta
    -Add laravel-permission package for ACL
    -Create and register service for ACL
    -Add Facades and fixed alias 
    
   ##### v0.0.3 beta
    -Fixed artisan commands with Storage class
    -Add filesystem configuration
    
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


## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
