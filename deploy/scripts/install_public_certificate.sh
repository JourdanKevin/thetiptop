#!/bin/bash

the_tip_top_home=/home/the_tip_top

sudo systemctl stop apache2

docker compose -f $the_tip_top_home/docker-compose.yml up -d front nginx 

docker compose -f $the_tip_top_home/docker-compose.yml run certbot certonly --webroot \
       --webroot-path /var/www/certbot/ -d "<SERVER_NAME>" \
       --email webmaster@dsp-archiwebo21-ap-al-fa-kj.fr --agree-tos --no-eff-email

docker compose -f $the_tip_top_home/docker-compose.yml down

mv $the_tip_top_home/nginx/conf.d/project $the_tip_top_home/nginx/conf.d/project.conf

mv $the_tip_top_home/docker-compose-https $the_tip_top_home/docker-compose.yml

sudo chown -R the_tip_top:the_tip_top $the_tip_top_home/certbot $the_tip_top_home/nginx $the_tip_top_home/docker-compose.yml
