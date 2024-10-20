#!/bin/bash
docker compose -f prod.docker-compose.yml pull
docker compose -f prod.docker-compose.yml up -d
docker image prune -f
