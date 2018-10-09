# DevOps Microservice Lumen Project
[build] [stable]

[version] [v1.1.1  beta]

##### Why use it?
>Microservice Lumen allows you to start from a solid foundation to build your backend. Using packages, services and patterns you'll be able to implement your app in an easy and efficient way. With this framework you can build your REST API in a few steps using artisan commands to create the Controller, the Repository linked to the data model and the Trasformer for data display. The microservice communicates with the outside through HTTP API calls with JWT authentication (stateless token). It implements base services for API controller, response and helpers.

## Official Documentation
[wiki] [https://github.com/FabrizioCafolla/microservice-lumen/wiki]

![](.github/Microservice%20Lumen.png)

## Features 
_The v1.1.1 beta version is the release that includes the following components in the framework:_

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
    -LogService to create and use log with Monolog package

**Repository pattern** implemented to manage the models in an abstract way and to allow the scalability of the business logic (used to guarantee also the code cleaning)

**Transformer** classes to manipulate data and better manage the recovery of related information (are transformed through functions implemented in ApiService)
  
**Artisan commands** to create Repository, ApiController and Transoformers (Other commands to create example file view documentation)

  ##### v1.1.2 beta
    -Create external package for Cache and require
    -Fixed App and Auth providers
    -Fixed boostrap file load
    
  ##### v1.1.1 beta
    -Fixed ResponseService success method
    -Fixed transform and give method
    -Fixed AbstractCache with serialization method
    -Install aws sdk
    
  ##### v1.1.0 beta
    -Fixed ResponseService custom method
    -Add new Cache service system, implement repository with method.
    -Create serialization json encode for cache system
    
  ##### v1.0.4 beta
    -Fixed AuthService and remove Abstract class
    -Fixed ApiService transform
    -Fixed and Add method ACLService
      
  ##### v1.0.3 beta
    -Fixed docker-compose build
    -Add redis cli to develop env (docker-compose) 
    -Add LogService for log managment
  
   ##### v1.0.2 beta
       The release is ready to be used in develop and production environments using in the first case docker-compose while in the second Docker. The code you develop when ready will have to build it with the Docker commands and then upload to Dockerhub or AWS ECR. The image created will allow you to have your app ready to be used by the ECS tasks
       
       After docker build => in the image all the necessary php extensions are installed, the relative vendors are downloaded, the workdir permissions are set and above all the docker-compose and git files are ignored. The port are not exposed because it is done in ECS
       
       Features
       Add Dockerfile and dockerignore for ecs production

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
