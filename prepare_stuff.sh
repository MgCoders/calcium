#!/usr/bin/env bash
#/bin/bash
set -x
mkdir -p /home/ubuntu/wp-REPLACE_PROJECT_NAME-files
if [ ! -f /home/ubuntu/conf/wp-REPLACE_PROJECT_NAME-deploy.env ]; then
    echo "/home/ubuntu/conf/wp-REPLACE_PROJECT_NAME-deploy.env not found" && exit 1;
fi

