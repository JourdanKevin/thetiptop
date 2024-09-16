#!/bin/bash


sudo systemctl stop apache2


cd /home/the_tip_top

docker compose up -d --remove-orphans --force-recreate
docker exec -i the_tip_top-front-1 composer install
