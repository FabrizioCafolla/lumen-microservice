# DevOps Microservice Lumen Project
[build] [stable]

\[version] [v1.4.1  beta]

##### Why use it?
>Microservice Lumen allows you to start from a solid foundation to build your backend. Using packages, services and patterns you'll be able to implement your app in an easy and efficient way. With this framework you can build your REST API in a few steps using artisan commands to create the Controller, the Repository linked to the data model and the Trasformer for data display. The microservice communicates with the outside through HTTP API calls with JWT authentication (stateless token). It implements base services for API controller, response and helpers.

## Official Documentation

![](.github/Microservice-lumen-image.jpg)

## Features 

**Doker** to start the application with `Nginx`, `PHP 7`, `MySQL` and `Redis`;

**JWT** for the authentication of routes usable with the implemented service;

**Services** implemented to facilitate work:

    -Api helpers function
    -Response method to manage error/success/exceptions responses
    -Auth for manage user and jwt token
    -ACL method for manipulate user roles and permissions
    -Log method to manage file log
    -Cache implements methods to manage File and Redis cache with serialization
    
**Roles and Permissions** to assign them to users and manage routes with greater security;

**Repository pattern** implemented to manage the models in an abstract way and to allow the scalability of the business logic (used to guarantee also the code cleaning)

**Transformer** classes to manipulate data and better manage the recovery of related information (are transformed through functions implemented in ApiService)
  
**Artisan commands** to create Repository, ApiController, Provider and Transoformers (Other commands to create example file view documentation)

[Wiki](https://github.com/FabrizioCafolla/microservice-lumen/wiki)

[Documentation Api](https://fabriziocafolla.com/microservice-lumen/docs/)

[File example](https://gist.github.com/FabrizioCafolla/b132d6eafbb5c851b7610f8cf927bdf4)

  ##### v1.4.1 beta
    -Fixed docker compose file
    -Fixed file with new method of package
    -Create response-http package for response
  
  ##### v1.4.0 beta
    -Create framework package
    -Fixed namespace
    -Fixed config
  
  ##### v1.3.1 beta
    -Fixed Response service
    -Fixed Handling
    -Add REST API
    -Fixed Middleware
    -Create policy
    
  ##### v1.3.0 beta
    -Add Folklore GraphQL package 
    -Add confiration package (with Provider and Config)
    -Remove folder Api
    -Add REST and GraphQL folder to App\Http
    -Fixed serializer
    -Fixed error storage
    -Create Primitive graphql type
    -Create class to call Primitive type 
    
  ##### v1.2.1 beta
    -Fixed Log service and add new method
    -Add composer to app container
    -Create Fractal trait
    -Fixed middleware auth
    
  ##### v1.2.0 beta
    -Changed many names and parameters of methods
    -Remove Dingo package
    -Fixed Respose service and add errorException function
    -Add json response in handler exception
    -Fixed Auth service

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
