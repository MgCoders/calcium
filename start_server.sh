#!/usr/bin/env bash
#/bin/bash
set -x
cd /home/ubuntu/wp-calcium-deploy
cp ../conf/wp-calcium-deploy.env /home/ubuntu/wp-calcium-deploy/.env
echo docker-compose up
docker-compose build && docker-compose up -d
