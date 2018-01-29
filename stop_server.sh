#!/usr/bin/env bash
#/bin/bash
set -x
cd /home/ubuntu/wp-silicon-deploy
docker-compose kill
if [ $? -eq 0 ]
then
  echo "Successfull"
  exit 0
else
  echo "Error" >&2
  exit 1
fi
