#!/bin/bash
source ./../.env
export PROJECT_NAME

log_message()
{
    LOGPREFIX="[$(date '+%Y-%m-%d %H:%M:%S')][rebuild]"
    MESSAGE=$1
    echo "$LOGPREFIX $MESSAGE"
}


log_message "Dump DB [${PROJECT_NAME}]..."
docker exec $(docker ps -aqf "name=${PROJECT_NAME}_mysql") mysqldump -u root -proot ${MYSQL_DATABASE} > ./dump.sql
