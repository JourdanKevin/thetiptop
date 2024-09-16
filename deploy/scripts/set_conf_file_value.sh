#!/bin/bash

sed -i "s/<PROJECT_NAME>/${PROJECT_NAME}/g" deploy/scripts/start.sh deploy/scripts/setup_var_folder.sh
certificate_path="dev"
if [ "$PROJECT_ENVIRONMENT" = "DEV" ] ; then 
    sed -i "s/<IMAGE_NAME>/${BRANCH_NAME}/g" deploy/docker-compose.yml
else 
    certificate_path=$PROJECT_DOMAIN_NAME
    sed -i "s/<IMAGE_NAME>/${PROJECT_VERSION}/g" deploy/docker-compose.yml
fi

sed -i "s/<SERVER_NAME>/${PROJECT_DOMAIN_NAME}/g" \
    deploy/nginx/conf.d/project.conf \
    deploy/scripts/get_certificate.sh \
    deploy/docker-compose.yml

sed -i "s/<CERTIFICATE_PATH>/${certificate_path}/g" deploy/scripts/get_certificate.sh
