#!/bin/bash



if [[ $PROJECT_ENVIRONMENT == "DEV" || $PROJECT_ENVIRONMENT == "PREPROD" ]]; then 
    COMMIT_MESSAGE=$(git log -1 --pretty=%B)
    if [ "$COMMIT_MESSAGE" == *"NO_PIPELINE"* ] ; then 
        echo "Arrêt de la pipeline"; 
        exit 1; 
    fi
    ./deploy/scripts/php_install.sh
    ./deploy/scripts/composer_install.sh
    ./deploy/scripts/symfony_install.sh
    ./deploy/scripts/npm_install.sh
fi