#!/bin/bash
source .env
export PROJECT_NAME

log_message()
{
    LOGPREFIX="[$(date '+%Y-%m-%d %H:%M:%S')][rebuild]"
    MESSAGE=$1
    echo "$LOGPREFIX $MESSAGE"
}


log_message "Stopping containers..."
docker compose -p ${PROJECT_NAME} stop

log_message "Removing containers..."
docker compose -p ${PROJECT_NAME} rm -f

log_message "Starting containers..."
docker compose -p ${PROJECT_NAME} up -d --remove-orphans --build

echo "Go RUN project please open http://localhost:8185"
echo "DB adminer [${MYSQL_USER}:${MYSQL_PASSWORD}] http://localhost:8006/?server=mysql&username=${MYSQL_USER}&db=${MYSQL_DATABASE}&password=${MYSQL_PASSWORD}"