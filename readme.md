# Microservice Lumen - DevOps 
![](https://img.shields.io/badge/version-1.5.0--beta-green.svg)
![](https://img.shields.io/badge/docker--compose-build-blue.svg)
![](https://img.shields.io/badge/docker-build-blue.svg)

### Let's go
    /*dev env*/
    cp .env.docker .env
    docker-compose build
    docker-compose up -d
    /*only first time*/
    docker-compose exec workspace bash
    cp ./.env.example .env
    php artisan jwt:secret -f
    
    /*prod env*/
    docker build --tag microservice-lumen .
    docker run -d -p 9000:9000 --name name-of-container -it microservice-lumen /bin/bash

    /*pull container from dockergub (tagname: develop or latest)*/
    docker pull fabriziocaf/microservice-lumen:tagname
    
[Wiki](https://github.com/FabrizioCafolla/microservice-lumen/wiki)

[Documentation Api](https://fabriziocafolla.com/docs/microservice-lumen/)

### Features 

**Doker** to start the application with `Nginx`, `PHP 7.2.2-fpm`, `MySQL` and `Redis`;

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

### Changelog

  ##### v1.5.0 beta
    -Update directory and docker file
    -Update core package 
    -Update response package with new logic 
    -Update and clean code cahce package 
    -Fixed rest controllers
    -Clean code
    
  ##### v1.4.2 beta
    -Update core package 
    -Update response package 
    -Update cahce package 
    -Fixed rest controllers
    -Fixed errors
  
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
