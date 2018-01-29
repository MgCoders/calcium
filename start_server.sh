#!/usr/bin/env bash
#/bin/bash
set -x
cd /home/ubuntu/wp-calcium-deploy
cp ../.env ./
echo docker-compose up
docker-compose build && docker-compose up -d
