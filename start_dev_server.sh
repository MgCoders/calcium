#!/usr/bin/env bash
#/bin/bash
docker-compose -f docker-compose.development.yml kill && docker-compose -f docker-compose.development.yml up -d
echo "****"
echo "****  WP http://localhost"
echo "****  PHPMyAdmin en http://localhost:1000"
echo "****  git checkout -b incidencia-youtrack"
echo "****"
