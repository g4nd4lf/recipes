#!/usr/bin/env bash

SCRIPT_PATH="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
USER=$(whoami)
COMMAND=$1
COMMAND_PARAM=$2

CODE_DIR="/home/${USER}/codebase/recipes"
DATA_DIR="${CODE_DIR}/data"
LOGS_DIR="${DATA_DIR}/logs";
CACHE_DIR="${DATA_DIR}/cache";

echo $CODE_DIR;

DOCKER_EXEC="docker exec -u app -it recipes_web /bin/bash -c"

echo ${CACHE_DIR}
echo ${LOGS_DIR}

if [ ! -d "${DATA_DIR}" ]; then
    echo "Creating data directory ${DATA_DIR}";
    sudo mkdir -p "${DATA_DIR}"
    sudo chown -R ${USER}:${USER} "${DATA_DIR}"
fi

if [ ! -d "${LOGS_DIR}" ]; then
    echo "Creating logs directory ${LOGS_DIR}";
    sudo mkdir -p "$LOGS_DIR"
    sudo chown -R ${USER}:${USER} "${LOGS_DIR}"

    echo "setfacl -R -m u:www-data:rwX -m u:${USER}:rwX ${LOGS_DIR}"

    setfacl -R -m u:www-data:rwX -m u:${USER}:rwX ${LOGS_DIR}
    setfacl -dR -m u:www-data:rwX -m u:${USER}:rwX ${LOGS_DIR}
fi

if [ ! -d "${CACHE_DIR}" ]; then
    echo "Creating logs directory ${CACHE_DIR}";
    sudo mkdir -p "${CACHE_DIR}"
    sudo chown -R ${USER}:${USER} "${CACHE_DIR}"

    echo "setfacl -R -m u:www-data:rwX -m u:${USER}:rwX ${CACHE_DIR}"

    setfacl -R -m u:www-data:rwX -m u:${USER}:rwX ${CACHE_DIR}
    setfacl -dR -m u:www-data:rwX -m u:${USER}:rwX ${CACHE_DIR}
fi

cd "${CODE_DIR}/docker/dev"

case ${COMMAND} in
  start|restart)
    echo "Starting Docker environment..."
    docker-compose stop
    docker-compose up -d
    ;;
  stop)
    echo "Stopping Docker environment..."
    docker-compose stop
    ;;
  build)
    echo "Building Dev environment..."
    docker-compose kill
    docker-compose build
    docker-compose up -d
    ;;
  composer)
    ${DOCKER_EXEC} "sudo phpdismod xdebug && composer ${COMMAND_PARAM} && sudo phpenmod xdebug"
    ;;
  term)
    DOCKER_USER="root"
    if [ -z ${COMMAND_PARAM} ]; then
        COMMAND_PARAM="recipes_web";
    fi
    if [ ${COMMAND_PARAM} == "recipes_web" ]; then
        DOCKER_USER="app";
    fi
    docker exec -it -u ${DOCKER_USER} ${COMMAND_PARAM} bash
    ;;
  purge|reset)
    echo "Purging and restarting Docker environment..."
    docker-compose kill
    echo "y" | docker-compose rm
    docker-compose up -d
    INITIALISE=true
    ;;
  clean)
    docker-compose kill
    echo "Cleaning docker containers..."
    docker rm -f $(docker ps -a -q) 2>/dev/null
    echo "Cleaning untagged images..."
    docker rmi -f $(docker images | grep "^<none>" | awk '{print $3}') 2>/dev/null
    docker-compose up -d
    ;;
  clear|cache|clear-cache)
    ${DOCKER_EXEC} "php bin/console cache:clear"
    ;;
  *)
    echo "
    Available options are:

    start            - Start a dev environment
    stop             - Stop a dev environment
    restart          - Restart a dev environment
    build            - Builds (or rebuilds) the dev containers
    purge / reset    - Remove current dev environment containers and restart environment
    composer <param> - Run composer in the container (pass install/update etc)
    clean            - Clean any dangling docker images saving precious space
    term <container> - Create a terminal for the container name
    "
    ;;
esac
