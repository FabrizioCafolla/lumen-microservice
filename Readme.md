# Docker infrastructure for Lumen 

![](https://img.shields.io/badge/version-1.0.0-green.svg)
![](https://img.shields.io/badge/docker--compose-build-blue.svg)
![](https://img.shields.io/badge/docker-build-blue.svg)

### Description

Microservice Lumen is a starting skeleton based on Docker and Lumen Framework 7. This project helps to develop and maintain a simple and clean infrastructure for the management / creation of php microservices. In just a few steps, the developer starts the development / staging / production environment as needed.
Basically, the Nginx containers are available for the webserver, the backend container in PHP 7.4 for the application, both based on Linux linux.
The Dockefile (in the docker folder) is already set up to create the production image of the application, we recommend modifying it only to add dependencies or configurations.

#### Develop env
**- require**
    
    Docker version: >= 18.09.6
    docker-compose version: >= 1.24.0

**- setup and run**

    1.  Edit .env.develop config and copy in root directory
        cp .env.dist .env

    3.  Only first time run command:
        make init
    
    4.  Route test
        localhost 
    
**- make commands**

    version:    Print version of Docker, Docker compose, and PHP
    
    init:    Setup application use it only first time
    
    build:    Build all container of docker-compose file
    
    up:    Up all container of docker-compose file with -d mode
    
    down:    Down all container started
    
    run:    Run container
    
    rebuild:    Re-build and up all container
    
    exec:     Exec bash of container.

#### Production env

    //build and run microservice (from root of project)
    docker build --tag IMAGENAME .
    docker run -d -p 9000:9000 --name CONTAINERNAME -it IMAGENAME /bin/sh

    //enter in microservice bash     
    docker exec -it CONTAINERNAME /bin/sh
    
    //stop and start microservice
    docker stop CONTAINERNAME
    docker start CONTAINERNAME
    docker rm CONTAINERNAME

[Manual push](https://docs.docker.com/engine/reference/commandline/push/) into docker hub registry

### Features 
    
[base image](https://hub.docker.com/r/fabriziocaf/lumen)
**Webserver Nginx**: 1.17-alpine
**Application: PHP**: 7.4.3-fpm-alpine
**Lumen Framework**: 7

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
