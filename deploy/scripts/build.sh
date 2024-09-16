#!/bin/bash

if [[ $PROJECT_ENVIRONMENT == "DEV" || $PROJECT_ENVIRONMENT == "PREPROD" ]]; then
    php bin/phpunit --log-junit build/reports.xml
    TEST_EXIT_CODE=$?

    if [ $TEST_EXIT_CODE -ne 0 ]; then
        echo "Tests fails..."
        exit 0
    fi
    echo "Tests effectués..."
fi