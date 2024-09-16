#!/bin/bash

the_tip_top_home=/home/the_tip_top

sudo apt-get install openssl

certificate_path=/home/the_tip_top/certbot/conf/live/<SERVER_NAME>

if [ ! -e "$certificate_path" ]; then
    mkdir -p $certificate_path
fi

openssl req -nodes -new -x509 \
    -keyout $certificate_path/privkey.pem \
    -out $certificate_path/fullchain.pem \
    -days 365 -subj "/C=/ST=/L=/O=/CN="

mv $the_tip_top_home/nginx/conf.d/project $the_tip_top_home/nginx/conf.d/project.conf

mv $the_tip_top_home/docker-compose-https $the_tip_top_home/docker-compose.yml

sudo chown -R the_tip_top:the_tip_top $the_tip_top_home/certbot $the_tip_top_home/nginx $the_tip_top_home/docker-compose.yml


aws s3 cp /path/to/local/folder s3://the-tip-top/certificate --recursive