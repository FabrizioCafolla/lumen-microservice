# Docker infrastructure for Lumen 

![](https://img.shields.io/badge/version-2.0.0-green.svg)
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
        make setup

    2.  Set .env db connection into lumen/ dir:
        DB_CONNECTION=mysql
        DB_HOST=mysql.private
        DB_PORT=3306
        DB_DATABASE=lumen
        DB_USERNAME=root
        DB_PASSWORD=root
    
    
**- make commands**

    down:  down containers

    up:   up -d containers

    exec:  enter into lumen container

    ssh_root:  connection ssh (as root) to server

    ssh:  connection ssh (as www-data) to server

    deploy: rebuild containers (down, build and up)

    ## production ##

    image_build:  build immagine

    image_push: publish image


[Manual push](https://docs.docker.com/engine/reference/commandline/push/) into docker hub registry

### Features 
    
[base image](https://hub.docker.com/r/fabriziocaf/lumen)
**Webserver Nginx**: 1.17-alpine
**Application: PHP**: 7.4.3-fpm-alpine
**Lumen Framework**: 7

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
