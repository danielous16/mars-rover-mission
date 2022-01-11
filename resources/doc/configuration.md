# Project configuration

### Create and install local environment
Run at the root path of the project:
```
make build
```
By running this command you will:
- Build docker images
- Run the docker containers
- Install project dependencies
- Initialize the Database
  
(It might take a while)

#### Start development environment
Run at the root path of the project:
```
make start
```
By running this command you will:
- Start development environment

#### Stop development environment
Run at the root path of the project:
```
make stop
```
By running this command you will:
- Stop the docker containers

#### Run Unit Test
Run at the root path of the project:
```
make test
```
By running this command you will:
- Execute the unit tests made with PHPUnit