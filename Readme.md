# Docker infrastructure for Lumen 

![](https://img.shields.io/github/v/release/FabrizioCafolla/lumen-microservice)
![](https://img.shields.io/github/last-commit/FabrizioCafolla/lumen-microservice/main)


Microservice Lumen is a starting skeleton based on Docker and Lumen Framework. This project helps to develop and maintain a simple and clean infrastructure for the management / creation of php microservices. In just a few steps, the developer starts the development / staging / production environment as needed.
Basically, the Nginx containers are available for the webserver, the backend container in PHP 7.4 for the application, both based on Linux alpine. Include MySQL container by default.
The Dockefile (in the docker folder) is already set up to create the production image of the application, we recommend modifying it only to add dependencies or configurations.

### Develop env

The first time the setup is run some data will be asked as input (app name, larvel version, and others), this will generate an env.conf file and a .env file (which is the exact copy), the former you will have to version the latter will be excluded. Also, the laravel/lumen source code will be downloaded, it too will need to be versioned. In case your project has already been initialized, whoever is going to download it will still have to perform both the first step indicated in 'setup and run'.

**Required**
    
    OS: linux
    Packages: make
    Docker version: >= 18.09.6
    docker-compose version: >= 1.28.0

**Setup**

1. run ```make setup```

2. [not required] Set .env db connection into lumen/ dir:

    ``` 
    DB_CONNECTION=mysql
    DB_HOST=mysql.private
    DB_PORT=3306
    DB_DATABASE=lumen
    DB_USERNAME=root
    DB_PASSWORD=root
    ```
3. run ```make build && make up``` 
    
**Make commands**

    down:  down containers

    up:   up -d containers

    exec:  enter in app container

    exec_mysql:  enter in mysql container

    ssh_root:  connection ssh (as root) to server

    ssh:  connection ssh (as www-data) to server

    deploy: rebuild containers (down, build and up)

    image_build:  build immagine

    image_push: publish image
    
    image_push: run image


[Manual push](https://docs.docker.com/engine/reference/commandline/push/) into docker hub registry

### References 
    
**Nginx**: 1.22

**PHP**: 8.2-fpm-alpine

**MySQL**: 8.0

**Lumen Framework**: delfault master (or specific version)


## Mantained by

- **[Fabrizio Cafolla](https://github.com/FabrizioCafolla)**
  <a href="https://www.buymeacoffee.com/fabriziocafolla" target="_blank"><img  align="right" src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: 30px !important; width: 150px !important" ></a>

## License

This project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
