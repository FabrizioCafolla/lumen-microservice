# Docker infrastructure for Lumen 

![](https://img.shields.io/badge/version-4.0.0--beta-green.svg)
![](https://img.shields.io/badge/docker--compose-build-blue.svg)
![](https://img.shields.io/badge/docker-build-blue.svg)

### Description

Microservice Lumen è un'infrastruttura docker che permette di avviare un microservizio php basato sul framework Lumen. 
Mette a disposizione svariati strumenti e servizi che aiutano lo sviluppatore, che con pochi comandi gestisce l'ambiente di sviluppo/staging/produzione. 
Di base sono disponibili i container Nginx per il webserver, MySQL e Redis per il db e cache, e PHP 7.3 per l'applicazione, configurabili facilmente con il file di configurazione. 
Ricordare che l'immagine da usare in produzione o staging fa riferimento al Dockerfile presente nella dir application.

#### Develop env
**- require**
    
    Docker version 18.09.6, build 481bc77
    docker-compose version 1.24.0, build 0aa59064

**- setup and run**

    1.  (required) 
        Use to manage develop env https://github.com/FabrizioCafolla/docker-as-infrastructure
        or
        Create external network 
    
    2.  Edit .develop.env config 

    3.  Only first time run command:
        make init
    
    4.  Route test
        localhost/api/v1/test 
        localhost/api/v1/discovery
    
**- make coomand**

    version:    Print version of Docker, Docker compose, and PHP
    
    init:    Setup application use it only first time
    
    build:    Build all container of docker-compose file
    
    up:    Up all container of docker-compose file with -d mode
    
    down:    Down all container started
    
    run:    Run container
    
    rebuild:    Re-build and up all container
    
    exec:     Exec bash of container.

#### Production env

**- manual builds** 

    //build and run microservice
    docker build --tag microservice-lumen .
    docker run -d -p 9000:9000 --name name-of-container -it microservice-lumen /bin/sh

    //enter in microservice bash     
    docker exec -it name-of-container /bin/sh
    
    //stop and start microservice
    docker stop name-of-container
    docker start name-of-container
    docker rm name-of-container

[manual push](https://docs.docker.com/engine/reference/commandline/push/) in registry 

**- automatic builds** 

    //pull image from dockerhub (tagname: develop or latest)
    docker pull fabriziocaf/microservice-lumen:tagname
    
[docker hub example](https://hub.docker.com/r/fabriziocaf/microservice-lumen) with microservice-lumen.

If you want create automatic builds for your repository [see here](https://hub.docker.com/r/fabriziocaf/microservice-lumen).

### Features 
     
**Application env** 
    
    -Webserver Nginx 1.17-alpine
    -Application: PHP 7.3.8-fpm-alpine

**Kosmos X**

    -Support: services for manipulate data with Transformer, Api discovery, and more;
    -Response: create rest response more efficently;
    -Cache: services for manage File and Redis cache;
    -Auth: implement JWT auth and service to authenticate;
    -Helpers: function to help developer, artisan commands to create Repository, ApiController, Provider and Transoformers
    
### Changelog

  ##### v4.0.0 beta
    -Refactoring folder strcture
    -Add make file 
    -Fix docker-compose 
    -Add configs env 

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
