#!/bin/bash

if command -v docker ; then
    cd /home/the_tip_top
    docker compose down -v
    docker image prune -a -f
fi