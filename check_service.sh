#!/usr/bin/env bash
#/bin/bash
set -x
cd /home/ubuntu/wp-silicon-deploy
docker-compose ps -q | xargs docker inspect -f '{{ .State.ExitCode }}' | while read code; do  
    if [ "$code" == "1" ]; then    
       exit -1
    fi
done
