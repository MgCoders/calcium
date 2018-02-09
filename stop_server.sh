#!/usr/bin/env bash
#/bin/bash
set -x
cd /home/ubuntu/wp-REPLACE_PROJECT_NAME-deploy
docker-compose -f docker-compose.testing.yml kill
if [ $? -eq 0 ]
then
  echo "Successfull"
  exit 0
else
  echo "Error" >&2
  exit 1
fi
