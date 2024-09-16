#!/bin/bash

case "$PROJECT_ENVIRONMENT" in
  DEV)
    ./deploy/scripts/set_conf_file_value.sh
    # aws ecr-public get-login-password --region us-east-1 | docker login --username AWS --password-stdin public.ecr.aws/g4p6u3n1
    docker build -t the_tip_top_api .
    docker tag the_tip_top_api:latest public.ecr.aws/g4p6u3n1/the_tip_top_api:$(echo "$BRANCH_NAME")
    docker push public.ecr.aws/g4p6u3n1/the_tip_top_api:$(echo "$BRANCH_NAME")
    ;;
  PREPROD)
    # aws ecr-public get-login-password --region us-east-1 | docker login --username AWS --password-stdin public.ecr.aws/g4p6u3n1
    git config --global credential.helper '!aws codecommit credential-helper $@'
    git config --global credential.UseHttpPath true
    export PROJECT_VERSION=$(git describe --tags --abbrev=0)
    if [ -z "$PROJECT_VERSION" ]; then
        PROJECT_VERSION="0.0.0"
    fi
    COMMIT_MESSAGE=COMMIT_MESSAGE=$(git log -1 --pretty=%B)
    INCREMENT_TYPE=$(echo $COMMIT_MESSAGE | grep -oE '(MAJOR|MINOR|PATCH)')
    if [ -z "$INCREMENT_TYPE" ]; then
        INCREMENT_TYPE="MINOR"
    fi
    case $INCREMENT_TYPE in
        "MAJOR")
            PROJECT_VERSION=$(echo $PROJECT_VERSION | awk -F. '{print $1 + 1 ".0.0"}')
            ;;
        "MINOR")
            PROJECT_VERSION=$(echo $PROJECT_VERSION | awk -F. '{print $1 "." $2 + 1 ".0"}')
            ;;
        "PATCH")
            PROJECT_VERSION=$(echo $PROJECT_VERSION | awk -F. '{print $1 "." $2 "." $3 + 1}')
            ;;
        *)
            echo "Type d'incrémentation non reconnu : $INCREMENT_TYPE"
            exit 1
            ;;
    esac
    git tag $PROJECT_VERSION
    git push origin $PROJECT_VERSION    
    ./deploy/scripts/set_conf_file_value.sh    
    docker build -t the_tip_top_api .
    docker tag the_tip_top_api:latest public.ecr.aws/g4p6u3n1/the_tip_top_api:"$PROJECT_VERSION"
    docker push public.ecr.aws/g4p6u3n1/the_tip_top_api:"$PROJECT_VERSION"
    ;;
  PROD)
    export PROJECT_VERSION=$(git describe --tags --abbrev=0 $(git log --pretty=format:'%h' -n 1))
    echo $PROJECT_VERSION
    ./deploy/scripts/set_conf_file_value.sh
    ;;
  *)
    echo "L'environnement spécifié n'est pas reconnu. Utilisez 'DEV', 'PREPROD' ou 'PROD'."
    # Commandes pour un choix invalide ou par défaut
    ;;
esac