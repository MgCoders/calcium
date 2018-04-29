#!/usr/bin/env bash
#/bin/bash
export PROJECT_NAME=$(xmllint --xpath "//*[local-name()='project']/*[local-name()='artifactId']/text()" pom.xml)
chmod -R 777 themes
sed -i "s/REPLACE_PROJECT_NAME/$PROJECT_NAME/g" docker-compose.development.yml
docker-compose -f docker-compose.development.yml kill && docker-compose -f docker-compose.development.yml up -d
echo "****"
echo "****  WP http://localhost"
echo "****  PHPMyAdmin en http://localhost:1000"
echo "****  git checkout -b incidencia-youtrack"
echo "****"
