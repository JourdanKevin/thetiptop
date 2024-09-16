#!/bin/bash

if [[ $PROJECT_ENVIRONMENT == "DEV" || $PROJECT_ENVIRONMENT == "PREPROD" ]]; then 
    composer install --no-progress --no-interaction
    composer dump-autoload --optimize --no-dev --classmap-authoritative
    composer require --dev symfony/test-pack
    npm install
    npm run build
   # composer update
fi