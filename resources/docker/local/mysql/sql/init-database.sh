#!/usr/bin/env bash

mysql -uroot -p1234 mars_rover_mission < "/docker-entrypoint-initdb.d/000-create-database.sql"
mysql -uroot -p1234 mars_rover_mission < "/docker-entrypoint-initdb.d/001-create-tables.sql"