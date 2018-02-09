#!/usr/bin/env bash
#/bin/bash
set -x
cd /home/ubuntu/wp-REPLACE_PROJECT_NAME-deploy
docker-compose -f docker-compose.testing.yml ps -q | xargs docker inspect -f '{{ .State.ExitCode }}' | while read code; do  
    if [ "$code" == "1" ]; then    
       exit -1
    fi
done
