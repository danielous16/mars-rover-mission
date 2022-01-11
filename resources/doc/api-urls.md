# Api Urls available

# Api
##Landing a Vechicle
```
POST
http://localhost:8008/vehicles/landing
```
VehicleTypes:
- Rover => 1
######Request payload:
```json
{
    "vehicle_type": 1,
    "coordinate_x": 10,
    "coordinate_y": 10,
    "orientation": "N"
}
```

######Response:
The endpoint returns:
- HTTP code: 201 Created
- Response body with the new landed vehicle identifier:
```json
{
    "vehicle_id": "a4d0b67a-03ef-4ebc-a3b2-0259f8b320a2"
}
```

##Move a Vechicle
This endpoint processes the sequence of movements received and moves the vehicle validating that it does not collide with the limits of the Planet.
```
POST
http://localhost:8008/vehicles/{vehicleId}/move

Example:
http://localhost:8080/vehicles/c99d66d0-c522-4075-a982-76a1f784abcd/move
```
######Request payload:
```json
{
    "movement_sequence": "FFRRFFFRL"
}
```

######Response:
The endpoint returns:
- HTTP code: 200 OK
- Response body with the results of process the sequence of movements received:
```json
{
    "vehicle_id": "c99d66d0-c522-4075-a982-76a1f784abcd",
    "movements": {
        "processed": "FFRRFFFRL"
    }
}
```

####Collision example
Example of a response when the vehicle collides and is not able to process part of the sequence of movements
######Request:
```json
{
    "movement_sequence": "RFFFFFFFFFFLFFF"
}
```
######Response:
The endpoint returns:
- HTTP code: 200 OK
- Response body contains the processed and unprocessed movements, indicating the coordinates where the collision occurs:
```json
{
    "vehicle_id": "c99d66d0-c522-4075-a982-76a1f784abcd",
    "movements": {
        "processed": "RFFFFFFFF",
        "not_processed": "FFLFFF",
        "error": "There was a collision in the coordinates <X:28> <Y:-1> when moving to the <F>"
    }
}
```