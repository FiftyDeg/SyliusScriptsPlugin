#!/bin/bash
export $(grep -v '^#' .env.dev | xargs)

docker exec -u root -it "${COMPOSE_PROJECT_NAME}_php" bash
