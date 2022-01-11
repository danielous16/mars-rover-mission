# Mars Rover Mission 🚀

## Your Task
You’re part of the team that explores Mars by sending remotely controlled vehicles to the surface of the planet. Develop a software that translates the commands sent from earth to instructions that are understood by the rover.

## Requirements

- You are given the initial starting point (x,y) of a rover and the direction (N,S,E,W) it is facing.
- The rover receives a collection of commands. (E.g.) FFRRFFFRL
- The rover can move forward (f).
- The rover can move left/right (l,r).
- Suppose we are on a really weird planet that is square. 200x200 for example :)
- Implement obstacle detection before each move to a new square. If a given
sequence of commands encounters an obstacle, the rover moves up to the last possible point, aborts the sequence and reports the obstacle.

##Take into account
- Rovers are expensive, make sure the software works as expected.

# Implementation 

## Stack
- MySQL 8.0
- Nginx 1.15
- PHP 8.0.5
- Symfony 5.4
- PHPUnit 9.5

###Premises
- Only the limits of the terrain have been considered as obstacles
- The Planet is not circular

###Improvements
- Create a service to validate that a vehicle does not collide with other vehicles
- Persist Uuid as binary to improve database performance
- Use Behat to create a more semantic E2E tests
- Complete testing (there are only little examples)

###More resources

####[Project configuration](resources/doc/configuration.md)
####[Api Urls available](resources/doc/api-urls.md)
####[Postman collection](resources/doc/postman-collection.md)