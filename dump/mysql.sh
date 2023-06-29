#!/bin/bash
source ./../.env
export PROJECT_NAME

log_message()
{
    LOGPREFIX="[$(date '+%Y-%m-%d %H:%M:%S')][rebuild]"
    MESSAGE=$1
    echo "$LOGPREFIX $MESSAGE"
}

docker exec -it $(docker ps -aqf "name=${PROJECT_NAME}_mysql") /bin/bash
