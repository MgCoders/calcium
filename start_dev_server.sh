#!/usr/bin/env bash
#/bin/bash
chown -R www-data.www-data plugins
chown -R www-data.www-data uploads
docker-compose -f docker-compose.development.yml kill && docker-compose -f docker-compose.development.yml up -d
echo "****"
echo "****  WP http://localhost"
echo "****  PHPMyAdmin en http://localhost:1000"
echo "****  git checkout -b incidencia-youtrack"
echo "****"
